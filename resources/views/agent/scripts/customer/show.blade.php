<script type="text/javascript">
    let tables = {}
    let elements = {
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
        outstanding: document.querySelector('#outstanding'),
        epargnePlanInfo: document.querySelector("#epargne_plan_info"),
        pretPlanInfo: document.querySelector("#pret_plan_info"),
    }
    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus'),
        modalUpdateTypeAccount: document.querySelector('#updateAccount'),
        modalWriteSms: document.querySelector('#write-sms'),
        modalWriteMail: document.querySelector('#write-mail'),
        modalCreateWallet: document.querySelector('#createWallet'),
        modalCreateEpargne: document.querySelector('#createEpargne'),
        modalCreatePret: document.querySelector('#createPret'),
    }
    let forms = {}
    let dataTable = {}
    let block = {}

    let verifSoldesAllWallets = () => {
        $.ajax({
            url: `/api/customer/{{ $customer->id }}/verifAllSolde`,
            success: data => {
                let arr = Array.from(data)

                arr.forEach(item => {
                    if (item.status === 'outdated') {
                        toastr.error(`Le compte ${item.compte} est débiteur, veuillez contacter le client`, 'Compte Débiteur')
                    }
                })
            }
        })
    }
    let citiesFromPostal = (select) => {
        let contentCities = document.querySelector('#divCity')
        let block = new KTBlockUI(contentCities, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
        block.block();

        $.ajax({
            url: '/api/core/geo/cities/' + select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }

    let countryOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let cardsOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-card-img');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let getInfoEpargnePlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/core/epargne/' + item.value,
            success: data => {
                block.release()
                console.log(data)
                modals.modalCreateEpargne.querySelector(".profit_percent").innerHTML = data.profit_percent + ' %'
                modals.modalCreateEpargne.querySelector(".lock_days").innerHTML = data.lock_days + ' jours'
                modals.modalCreateEpargne.querySelector(".profit_days").innerHTML = "Montant des interet remis à zero tous les " + data.profit_days + " jours"
                modals.modalCreateEpargne.querySelector(".init").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.init)
                modals.modalCreateEpargne.querySelector(".limit").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.limit)
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getInfoPretPlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/pret/' + item.value,
            success: data => {
                block.release()
                console.log(data)
                modals.modalCreatePret.querySelector(".min").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.min)
                modals.modalCreatePret.querySelector(".max").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.max)
                modals.modalCreatePret.querySelector(".duration").innerHTML = data.duration + ' mois'
                modals.modalCreatePret.querySelector(".interest").innerHTML = data.interests[0].interest + ' %'
                modals.modalCreatePret.querySelector(".instruction").innerHTML = data.instruction
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getFileFromCategory = (item) => {
        console.log(item.dataset)
        let block = new KTBlockUI(document.querySelector('.showFiles'), {message: messageOverlay})
        block.block()

        $.ajax({
            url: `/agence/customers/${item.dataset.customer}/files/${item.dataset.category}`,
            success: data => {
                block.release()
                console.log(data)
            },
            error: err => {
                block.release()
                console.log(err)
            }
        })
    }

    verifSoldesAllWallets()
    citiesFromPostal(document.querySelector("#postal"))

    modals.modalUpdateStatusAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateStatus")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'put',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le compte du client est maintenant <strong>${data.status}</strong>`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
    modals.modalUpdateTypeAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateAccount")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'put',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le type de compte du client à été mis à jours`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
    modals.modalWriteSms.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteSms")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Sms à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du sms au client", "Erreur Système")
            }
        })
    })
    modals.modalWriteMail.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteMail")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Mail à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du mail au client", "Erreur Système")
            }
        })
    })
    elements.btnPass.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitPass`,
            method: 'put',
            success: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le mot de passe du client à été réinitialiser", "Réinitialisation du mot de passe")
            },
            error: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du mot de passe", "Erreur système")
            }
        })
    })
    elements.btnCode.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitCode`,
            method: 'put',
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le Code SECURPASS du client à été réinitialiser", "Réinitialisation du code SECURPASS")
            },
            error: err => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
            }
        })
    })
    if (elements.btnAuth) {
        elements.btnAuth.addEventListener('click', e => {
            e.preventDefault()

            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/api/customer/${elements.btnCode.dataset.customer}/reinitAuth`,
                method: 'put',
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.success("L'authentification double facteur du client à été réinitialiser", "Réinitialisation de l'authentificateur")
                },
                error: err => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
                }
            })
        })
    }
    document.querySelectorAll('.callCategory').forEach(call => {
        call.addEventListener('click', e => {
            e.preventDefault();
            let showFile = document.querySelector('.showFiles')

            $.ajax({
                url: `/agence/customers/${call.dataset.customer}/files/${call.dataset.category}`,
                method: 'POST',
                success: data => {
                    showFile.querySelector('.content').innerHTML = ``
                    if (data.count === 0) {
                        showFile.querySelector(".empty").classList.remove('d-none')
                    } else {
                        showFile.querySelector(".empty").classList.add('d-none')
                        showFile.querySelector('.content').innerHTML = data.html
                    }
                    console.log(data)
                },
                error: err => {
                    console.log(err)
                }
            })
        })
    })

    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })
    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    $("#formCreateWallet").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateWallet")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
    $("#formCreateEpargne").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateEpargne")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
    $("#formCreatePret").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreatePret")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
</script>
