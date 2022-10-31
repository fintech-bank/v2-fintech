<script type="text/javascript">
    let tables = {}
    let elements = {
        field_datebirth: document.querySelector('[name="datebirth"]'),
        field_package_id: document.querySelector('[name="package_id"]'),
        field_card_support: document.querySelector('[name="card_support"]'),
        field_differed_card_type: document.querySelector('#differed_card_type'),
        field_differed_card_amount: document.querySelector('#differed_card_amount'),
        blockDivPackage: document.querySelector('#blockDivPackage'),
        divPackage: document.querySelector('#package_info'),
        btnVerifyCustomer: document.querySelector("#btnVerifyCustomer"),
        btnSubscribe: document.querySelectorAll('.btnSubscribe'),
        btnSignate: document.querySelectorAll('.btnSignate'),
        startPersonnaCustomer: document.querySelector('.startPersonnaCustomer'),
        startPersonnaDomicile: document.querySelector('.startPersonnaDomicile'),
        startAuthyRegister: document.querySelector('.startAuthyRegister'),

    }
    let modals = {
        modalVerifyCustomer: document.querySelector("#modalVerifCustomer"),
        modalSubscribeAlerta: document.querySelector("#subscribeAlerta")
    }
    let forms = {
        formPartPro: document.querySelector('#formPartPro')
    }
    let dataTable = {}
    let block = {
        blockDivPackage: messageBlock(elements.blockDivPackage)
    }

    let countryBirthOptions = (item) => {
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

    let citiesFromCountry = (select) => {
        console.log(select.value)
        let contentCities = document.querySelector('#divCities')
        $.ajax({
            url: '/api/core/geo/cities',
            method: 'post',
            data: {"country": select.value},
            success: data => {
                console.log(data)
                contentCities.innerHTML = data
                $("#citybirth").select2()
                $(contentCities).fadeIn()
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
    let getInfoPackage = (packageId) => {
        block.blockDivPackage.block()
        elements.divPackage.classList.remove('d-none')

        let iconTemplate = {
            'Cristal': {'icon': 'gem', 'color': 'secondary'},
            'Gold': {'icon': 'gem', 'color': 'warning'},
            'Platine': {'icon': 'gem', 'color': 'black'},
            'Pro Metal': {'icon': 'ring', 'color': 'secondary'},
            'Pro Gold': {'icon': 'ring', 'color': 'warning'},
        }

        let deleteIconColor = () => {
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-secondary')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-warning')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-black')
        }

        let deleteIcon = () => {
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('fa-gem')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('fa-ring')
        }

        let deleteIconC = (name) => {
            elements.divPackage.querySelector('[data-content="' + name + '"]').querySelector('i').classList.remove('fa-check-circle')
            elements.divPackage.querySelector('[data-content="' + name + '"]').querySelector('i').classList.remove('fa-check-circle')
            elements.divPackage.querySelector('[data-content="' + name + '"]').querySelector('i').classList.remove('text-success')
            elements.divPackage.querySelector('[data-content="' + name + '"]').querySelector('i').classList.remove('text-danger')
        }

        let checkIfValid = {
            0: {'icon': 'xmark-circle', 'color': 'danger'},
            1: {'icon': 'check-circle', 'color': 'success'},
        }
        $.ajax({
            url: '/api/core/forfait/' + packageId.value,
            success: data => {
                console.log(data)
                block.blockDivPackage.release()
                block.blockDivPackage.destroy()

                deleteIconColor()
                elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.add('text-' + iconTemplate[data.name].color)

                deleteIcon()
                elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.add('fa-' + iconTemplate[data.name].icon)

                elements.divPackage.querySelector('[data-content="package_name"]').innerHTML = `Forfait ${data.name}`
                elements.divPackage.querySelector('[data-content="package_price"]').innerHTML = `${new Intl.NumberFormat('fr', {
                    style: 'currency',
                    currency: 'eur'
                }).format(data.price)}`
                elements.divPackage.querySelector('[data-content="package_type_prlv"]').innerHTML = `${data.type_prlv_text}`

                deleteIconC('visa_classic')
                elements.divPackage.querySelector('[data-content="visa_classic"]').querySelector('i').classList.add('fa-' + checkIfValid[data.visa_classic].icon)
                elements.divPackage.querySelector('[data-content="visa_classic"]').querySelector('i').classList.add('text-' + checkIfValid[data.visa_classic].color)

                deleteIconC('check_deposit')
                elements.divPackage.querySelector('[data-content="check_deposit"]').querySelector('i').classList.add('fa-' + checkIfValid[data.check_deposit].icon)
                elements.divPackage.querySelector('[data-content="check_deposit"]').querySelector('i').classList.add('text-' + checkIfValid[data.check_deposit].color)

                deleteIconC('payment_withdraw')
                elements.divPackage.querySelector('[data-content="payment_withdraw"]').querySelector('i').classList.add('fa-' + checkIfValid[data.payment_withdraw].icon)
                elements.divPackage.querySelector('[data-content="payment_withdraw"]').querySelector('i').classList.add('text-' + checkIfValid[data.payment_withdraw].color)

                deleteIconC('overdraft')
                elements.divPackage.querySelector('[data-content="overdraft"]').querySelector('i').classList.add('fa-' + checkIfValid[data.overdraft].icon)
                elements.divPackage.querySelector('[data-content="overdraft"]').querySelector('i').classList.add('text-' + checkIfValid[data.overdraft].color)

                deleteIconC('cash_deposit')
                elements.divPackage.querySelector('[data-content="cash_deposit"]').querySelector('i').classList.add('fa-' + checkIfValid[data.cash_deposit].icon)
                elements.divPackage.querySelector('[data-content="cash_deposit"]').querySelector('i').classList.add('text-' + checkIfValid[data.cash_deposit].color)

                deleteIconC('withdraw_international')
                elements.divPackage.querySelector('[data-content="withdraw_international"]').querySelector('i').classList.add('fa-' + checkIfValid[data.withdraw_international].icon)
                elements.divPackage.querySelector('[data-content="withdraw_international"]').querySelector('i').classList.add('text-' + checkIfValid[data.withdraw_international].color)

                deleteIconC('payment_international')
                elements.divPackage.querySelector('[data-content="payment_international"]').querySelector('i').classList.add('fa-' + checkIfValid[data.payment_international].icon)
                elements.divPackage.querySelector('[data-content="payment_international"]').querySelector('i').classList.add('text-' + checkIfValid[data.payment_international].color)

                deleteIconC('payment_insurance')
                elements.divPackage.querySelector('[data-content="payment_insurance"]').querySelector('i').classList.add('fa-' + checkIfValid[data.payment_insurance].icon)
                elements.divPackage.querySelector('[data-content="payment_insurance"]').querySelector('i').classList.add('text-' + checkIfValid[data.payment_insurance].color)

                deleteIconC('check')
                elements.divPackage.querySelector('[data-content="check"]').querySelector('i').classList.add('fa-' + checkIfValid[data.check].icon)
                elements.divPackage.querySelector('[data-content="check"]').querySelector('i').classList.add('text-' + checkIfValid[data.check].color)

                elements.divPackage.querySelector('[data-content="nb_carte_physique"]').innerHTML = data.nb_carte_physique
                elements.divPackage.querySelector('[data-content="nb_carte_virtuel"]').innerHTML = data.nb_carte_virtuel
                elements.divPackage.querySelector('[data-content="subaccount"]').innerHTML = data.subaccount


            }
        })

    }
    let getShowDifferedType = (support) => {
        if (support.value !== 'visa-classic') {
            elements.field_differed_card_type.classList.remove('d-none')
        } else {
            elements.field_differed_card_type.classList.add('d-none')
        }
    }
    let getShowDifferedAmount = (debit) => {
        if (debit.value === 'differed') {
            elements.field_differed_card_amount.classList.remove('d-none')
        } else {
            elements.field_differed_card_amount.classList.add('d-none')
        }
    }

    document.querySelectorAll('[name="postal"]').forEach(input => {
        input.addEventListener('keyup', e => {
            console.log(e.target.value.length)
            if (e.target.value.length === 5) {
                citiesFromPostal(e.target)
            }
        })
    })

    if (elements.field_datebirth) {
        $(elements.field_datebirth).flatpickr({"locale": "fr"})
    }
    if (elements.btnSubscribe) {
        elements.btnSubscribe.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                btn.setAttribute('data-kt-indicator', 'on')

                $.ajax({
                    url: '/agence/customer/create/subscribe',
                    method: 'POST',
                    data: {
                        'action': e.target.dataset.subscribe,
                        'overdraft_amount': document.querySelector('[name="overdraft_amount"]') ? document.querySelector('[name="overdraft_amount"]').value : ''
                    },
                    success: data => {
                        btn.removeAttribute('data-kt-indicator')
                        toastr.success(`Souscription à l'offre ${data.offer} effectuer`, `Souscription pris en compte`)
                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: () => {
                        btn.removeAttr('data-kt-indicator')
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            })
        })
    }
    @if(isset($customer))
    if (elements.startPersonnaCustomer) {
        elements.startPersonnaCustomer.addEventListener('click', e => {
            e.preventDefault()
            const client = new Persona.Client({
                templateId: "itmpl_dtC4KRK6GMLCzXtRcRZ68gVv",
                environment: "sandbox",
                referenceId: "{{ isset($customer) ? $customer->persona_reference_id : '' }}",
                onReady: () => client.open(),
                onComplete: ({inquiryId, status, fields}) => {
                    console.log("onComplete")
                    @if(isset($customer))
                    $.ajax({
                        url: '/api/user/verify/customer',
                        method: 'POST',
                        data: {"customer_id": {{ $customer->id }}},
                        success: () => {
                            window.location.href = "/agence/customer/create/finish?refresh&customer_id=" + {{ $customer->id }}
                        }
                    })
                    @endif
                },
                onCancel: ({inquiryId, sessionToken}) => console.log('onCancel'),
                onError: (error) => console.log("onError"),
                fields: {
                    nameFirst: "{{ $customer->info->firstname }}",
                    nameLast: "{{ $customer->info->lastname }}",
                    birthdate: "{{ $customer->info->datebirth->format('Y-m-d') }}",
                    addressStreet1: "{{ $customer->info->address }}",
                    addressCity: "{{ $customer->info->city }}",
                    addressPostalCode: "{{ $customer->info->postal }}",
                    addressCountryCode: "{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::limit($customer->info->address, 2, '')) }}",
                    phoneNumber: "{{ $customer->info->mobile }}",
                    emailAddress: "{{ $customer->user->email }}",
                }
            });
        })
    }
    if (elements.startPersonnaDomicile) {
        elements.startPersonnaDomicile.addEventListener('click', e => {
            e.preventDefault()
            const client = new Persona.Client({
                templateId: "itmpl_qvuQuXt48aMJYd6o345x7Ldm",
                environment: "sandbox",
                referenceId: "{{ isset($customer) ? $customer->persona_reference_id : '' }}",
                onReady: () => client.open(),
                onComplete: ({inquiryId, status, fields}) => {
                    console.log("onComplete")
                        $.ajax({
                        url: '/api/user/verify/domicile',
                        method: 'POST',
                        data: {"customer_id": {{ $customer->id }}},
                        success: () => {
                            window.location.href = "/agence/customer/create/finish?refresh&customer_id=" + {{ $customer->id }}
                        }
                    })
                },
                onCancel: ({inquiryId, sessionToken}) => console.log('onCancel'),
                onError: (error) => console.log("onError"),
                fields: {
                    nameFirst: "{{ $customer->info->firstname }}",
                    nameLast: "{{ $customer->info->lastname }}",
                    birthdate: "{{ $customer->info->datebirth->format('Y-m-d') }}",
                    addressStreet1: "{{ $customer->info->address }}",
                    addressCity: "{{ $customer->info->city }}",
                    addressPostalCode: "{{ $customer->info->postal }}",
                    addressCountryCode: "{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::limit($customer->info->address, 2, '')) }}",
                    phoneNumber: "{{ $customer->info->mobile }}",
                    emailAddress: "{{ $customer->user->email }}",
                }
            });
        })
    }
    if(elements.btnSignate) {
        elements.btnSignate.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                $.ajax({
                    url: '/api/user/signate',
                    method: 'POST',
                    data: {'document_id': e.target.dataset.document},
                    success: data => {
                        toastr.success(`Un email à été envoyer au client`, `Signature de document`)
                        setInterval(() => {
                            $.ajax({
                                url: '/api/user/signate/verify',
                                method: 'GET',
                                data: {'document_id': data.id},
                                success: data => {
                                    if(data.status === 'signed') {
                                        toastr.success(`Le document à été signé`, `Signature de document`)
                                        setTimeout(() => {
                                            window.location.href = "/agence/customer/create/finish?refresh&customer_id=" + {{ $customer->id }}
                                        }, 500)
                                    } else {
                                        console.log("En attente de signature")
                                    }
                                }
                            })
                        }, 3000)
                    }
                })
            })
        })
    }
    if(elements.startAuthyRegister) {
        elements.startAuthyRegister.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: '/auth/register',
                data: {"customer_id": {{ $customer->id }}},
                success: data => {
                    toastr.success(`L'authentification forte à été paramétré`, `Authentification 2FA`)
                }
            })
        })
    }
    @endif

    $("#countrybirth").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })
    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })
    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })
    if (elements.btnVerifyCustomer) {
        elements.btnVerifyCustomer.addEventListener('click', e => {
            e.preventDefault()
            let modal = new bootstrap.Modal(modals.modalVerifyCustomer)
            modal.show()

            let fccTemplate = {
                'true': {'text': "Inscrit dans le fichier", 'color': 'danger'},
                'false': {'text': 'Non Inscrit dans le fichier', 'color': 'success'}
            }

            let ficpTemplate = {
                'true': {'text': "Inscrit dans le fichier", 'color': 'danger'},
                'false': {'text': 'Non Inscrit dans le fichier', 'color': 'success'}
            }

            $.ajax({
                url: '/api/connect/customer_verify',
                success: data => {
                    console.log(data)
                    modals.modalVerifyCustomer.querySelector(".icon").querySelector('.spinner').classList.add('d-none')
                    modals.modalVerifyCustomer.querySelector(".icon").innerHTML = '<i class="fa-solid fa-warning text-warning fs-3hx"></i>'
                    modals.modalVerifyCustomer.querySelector('.fw-bolder').classList.add('d-none')
                    modals.modalVerifyCustomer.querySelector('#errors').innerHTML = `
                <div class="d-flex flex-column justify-content-between">
                    <strong>Fichier Central des chèques: <span class="text-${fccTemplate[data.fcc].color}">${fccTemplate[data.fcc].text}</span></strong>
                    <strong>Fichier Incident Crédit Particulier: <span class="text-${ficpTemplate[data.ficp].color}">${ficpTemplate[data.ficp].text}</span></strong>
                </div>
                `

                    modals.modalVerifyCustomer.addEventListener('hidden.bs.modal', e => {
                        $(forms.formPartPro).submit()
                    })
                }
            })
        })
    }
</script>
