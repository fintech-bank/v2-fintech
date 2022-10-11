<script type="text/javascript">
    let tables = {
        tableService: document.querySelector('#kt_service_table')
    }
    let elements = {
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
    }
    let modals = {
        modalEditService: document.querySelector("#EditService"),
        modalShowService: document.querySelector("#ShowService"),
    }
    let forms = {
        formAddService: document.querySelector('#formAddService'),
        formEditService: document.querySelector('#formEditService'),
    }

    let datatableService = $(tables.tableService).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })


    if(document.querySelector('[data-kt-service-filter="search"]')) {
        document.querySelector('[data-kt-service-filter="search"]').addEventListener("keyup", (function(t) {
            datatableService.search(t.target.value).draw()
        }))
    }

    if(elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/service/'+e.target.dataset.service,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditService)

                        forms.formEditService.setAttribute('action', '/api/core/service/'+data.id)
                        forms.formEditService.querySelector('[name="name"]').value = data.name
                        forms.formEditService.querySelector('[name="price"]').value = data.price
                        $("#select2-type_prlv-container").html(data.type_prlv_text)
                        $("#select2-package_id-container").html(data.package_id)


                        modal.show()
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
                    }
                })
            })
        })
    }
    if(elements.btnDelete) {
        elements.btnDelete.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/service/'+e.target.dataset.service,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Un service bancaire à été supprimé avec succès`, `Service bancaire`)

                        $(e.target.parentNode.parentNode).animate({
                            width: ["toggle", "swing"],
                            height: ["toggle", "swing"],
                            opacity: "toggle"
                        }, 1000, "linear")
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
                    }
                })
            })
        })
    }

    $(forms.formAddService).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddService)
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
                toastr.success(`Le service bancaire ${data.name} à été créer avec succès`, `Service bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
            }
        })
    })
    $(forms.formEditService).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditService)
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
                toastr.success(`Le service bancaire ${data.name} à été edité avec succès`, `Service bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
            }
        })
    })
</script>
