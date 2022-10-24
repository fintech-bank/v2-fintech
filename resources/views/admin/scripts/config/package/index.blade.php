<script type="text/javascript">
    let tables = {
        tableForfait: document.querySelector('#kt_forfait_table')
    }
    let elements = {
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
    }
    let modals = {
        modalEditForfait: document.querySelector("#EditForfait")
    }
    let forms = {
        formAddForfait: document.querySelector('#formAddForfait'),
        formEditForfait: document.querySelector('#formEditForfait'),
    }

    let datatableForfait = $(tables.tableForfait).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })

    if(document.querySelector('[data-kt-forfait-filter="search"]')) {
        document.querySelector('[data-kt-forfait-filter="search"]').addEventListener("keyup", (function(t) {
            datatableForfait.search(t.target.value).draw()
        }))
    }

    if(elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/forfait/'+e.target.dataset.forfait,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditForfait)

                        forms.formEditForfait.setAttribute('action', '/api/core/forfait/'+data.id)
                        forms.formEditForfait.querySelector('[name="name"]').value = data.name
                        forms.formEditForfait.querySelector('[name="price"]').value = data.price
                        $("#select2-type_cpt-container").html(data.type_cpt_text)
                        $("#select2-type_prlv-container").html(data.type_prlv_text)
                        data.visa_classic ? forms.formEditForfait.querySelector('[name="visa_classic"]').setAttribute('checked', 'checked') : ''
                        data.check_deposit ? forms.formEditForfait.querySelector('[name="check_deposit"]').setAttribute('checked', 'checked') : ''
                        data.payment_withdraw ? forms.formEditForfait.querySelector('[name="payment_withdraw"]').setAttribute('checked', 'checked') : ''
                        data.overdraft ? forms.formEditForfait.querySelector('[name="overdraft"]').setAttribute('checked', 'checked') : ''
                        data.cash_deposit ? forms.formEditForfait.querySelector('[name="cash_deposit"]').setAttribute('checked', 'checked') : ''
                        data.withdraw_international ? forms.formEditForfait.querySelector('[name="withdraw_international"]').setAttribute('checked', 'checked') : ''
                        data.payment_international ? forms.formEditForfait.querySelector('[name="payment_international"]').setAttribute('checked', 'checked') : ''
                        data.payment_insurance ? forms.formEditForfait.querySelector('[name="payment_insurance"]').setAttribute('checked', 'checked') : ''
                        data.check ? forms.formEditForfait.querySelector('[name="check"]').setAttribute('checked', 'checked') : ''
                        forms.formEditForfait.querySelector('[name="nb_carte_physique"]').value = data.nb_carte_physique
                        forms.formEditForfait.querySelector('[name="nb_carte_virtuel"]').value = data.nb_carte_virtuel
                        forms.formEditForfait.querySelector('[name="subaccount"]').value = data.subaccount

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
                    url: '/api/core/forfait/'+e.target.dataset.forfait,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Une forfait bancaire à été supprimé avec succès`, `Forfait Bancaire`)

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

    $(forms.formAddForfait).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddForfait)
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
                toastr.success(`Le forfait bancaire ${data.name} à été créer avec succès`, `Forfait Bancaire`)

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
    $(forms.formEditForfait).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditForfait)
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
                toastr.success(`Le forfait bancaire ${data.name} à été edité avec succès`, `Forfait Bancaire`)

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
