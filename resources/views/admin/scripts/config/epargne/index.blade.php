<script type="text/javascript">
    let tables = {
        tablePlan: document.querySelector('#kt_plan_table')
    }
    let elements = {
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
    }
    let modals = {
        modalEditPlan: document.querySelector("#EditPlan")
    }
    let forms = {
        formAddPlan: document.querySelector('#formAddPlan'),
        formEditPlan: document.querySelector('#formEditPlan'),
    }

    let datatablePlan = $(tables.tablePlan).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })

    if(document.querySelector('[data-kt-plan-filter="search"]')) {
        document.querySelector('[data-kt-plan-filter="search"]').addEventListener("keyup", (function(t) {
            datatablePlan.search(t.target.value).draw()
        }))
    }

    if(elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/epargne/'+e.target.dataset.plan,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditPlan)

                        forms.formEditPlan.setAttribute('action', '/api/core/epargne/'+data.id)
                        forms.formEditPlan.querySelector('[name="name"]').value = data.name
                        forms.formEditPlan.querySelector('[name="profit_percent"]').value = data.profit_percent
                        forms.formEditPlan.querySelector('[name="lock_days"]').value = data.lock_days
                        forms.formEditPlan.querySelector('[name="profit_days"]').value = data.profit_days
                        forms.formEditPlan.querySelector('[name="init"]').value = data.init
                        forms.formEditPlan.querySelector('[name="limit"]').value = data.limit

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
                    url: '/api/core/epargne/'+e.target.dataset.plan,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Un plan d'épargne à été supprimé avec succès`, `Plan d'épargne`)

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

    $(forms.formAddPlan).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddPlan)
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
                toastr.success(`Le plan d'épargne ${data.name} à été créer avec succès`, `Plan d'épargne`)

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
    $(forms.formEditPlan).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditPlan)
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
                toastr.success(`Le plan d'épargne ${data.name} à été edité avec succès`, `Plan d'épargne`)

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
