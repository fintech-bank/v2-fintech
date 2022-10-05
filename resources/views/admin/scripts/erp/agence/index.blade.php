<script type="text/javascript">
    let tables = {
        tableAgence: document.querySelector("#kt_agence_table")
    }
    let elements = {
        btnViewAgence: document.querySelectorAll('.viewAgency'),
        btnEditAgence: document.querySelectorAll('.editAgency'),
        btnDeleteAgence: document.querySelectorAll('.deleteAgency'),
    }
    let modals = {
        modalAgence: document.querySelector("#viewAgence")
    }
    let forms = {
        formAddAgency: $("#formAddAgency"),
        formEditAgency: $("#formEditAgency"),
    }

    let dataTableAgence = $(tables.tableAgence).DataTable()

    let citiesFromCountry = (select) => {
        console.log(select.value)
        let contentCities = document.querySelector('#divCities')
        $.ajax({
            url: '/api/geo/cities',
            method: 'post',
            data: {"country": select.value},
            success: data => {
                console.log(data)
                contentCities.innerHTML = data
                $("#citybirth").select2()
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

    if(document.querySelector('[data-kt-agence-filter="search"]')) {
        document.querySelector('[data-kt-agence-filter="search"]').addEventListener("keyup", (function (t) {
            dataTableAgence.search(t.target.value).draw()
        }))
    }
    if (elements.btnViewAgence) {
        elements.btnViewAgence.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                let modal = new bootstrap.Modal(modals.modalAgence)

                $.ajax({
                    url: '/api/core/agency/'+e.target.dataset.agency,
                    success: data => {
                        modals.modalAgence.querySelector('[data-content="title"]').innerHTML = `Information sur l'agence ${data.name}`
                        modals.modalAgence.querySelector('[data-content="agenceSl"]').innerHTML = data.agenceSl
                        modals.modalAgence.querySelector('[data-content="address"]').innerHTML = data.address
                        modals.modalAgence.querySelector('[data-content="communication"]').innerHTML = data.communication
                        modals.modalAgence.querySelector('[data-content="agence_type"]').innerHTML = data.agence_type
                        modals.modalAgence.querySelector('[data-content="count_user"]').innerHTML = data.count
                        modals.modalAgence.querySelector('[data-content="sum_wallet"]').innerHTML = data.sum_all_wallet
                        modal.show()
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            })
        })
    }
    if (elements.btnEditAgence) {
        elements.btnEditAgence.forEach(btn => {
            btn.addEventListener('click', e => {
                window.location.href='/admin/erp/agence/'+e.target.dataset.agency+'/edit'
            })
        })
    }
    if (elements.btnDeleteAgence) {
        elements.btnDeleteAgence.forEach(btn => {
            btn.addEventListener('click', e => {
                $.ajax({
                    url: '/api/core/agency/'+e.target.dataset.agency,
                    method: 'DELETE',
                    success: data => {
                        toastr.success(`L'agence ${data.name} à été supprimé avec succès`, `Edition d'une Agence`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    statusCode: {
                        408: data => {
                            toastr.warning(`L'agence ${data.name} ne peut être supprimer car elle comporte des clients.`, `Edition d'une Agence`)
                        },
                        500: () => {
                            toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                        }
                    }
                })
            })
        })
    }

    forms.formAddAgency.on('submit', e => {
        e.preventDefault()
        let form = forms.formAddAgency
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
                toastr.success(`L'agence ${data.name} à été ajouté avec succès`, `Nouvelle Agence`)

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
    forms.formEditAgency.on('submit', e => {
        e.preventDefault()
        let form = forms.formEditAgency
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`L'agence ${data.name} à été édité avec succès`, `Edition d'une Agence`)

                setTimeout(() => {
                    window.location.href='{{ route('admin.erp.agence.index') }}'
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })

    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })
</script>
