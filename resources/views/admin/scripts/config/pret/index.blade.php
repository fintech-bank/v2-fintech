<script type="text/javascript">
    let tables = {
        tablePret: document.querySelector('#kt_pret_table')
    }
    let elements = {
        btnShow: document.querySelectorAll('.btnShow'),
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
    }
    let modals = {
        modalEditPret: document.querySelector("#EditPret"),
        modalShowPret: document.querySelector("#ShowPret"),
    }
    let forms = {
        formAddPret: document.querySelector('#formAddPret'),
        formEditPret: document.querySelector('#formEditPret'),
    }

    $("#tauxFixe").hide();
    $("#tauxVariable").hide();

    let datatablePret = $(tables.tablePret).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })
    let selectTypeTaux = (select) => {
        if(select.value === 'fixe') {
            $("#tauxFixe").slideDown();
            $("#tauxVariable").slideUp();
        } else {
            $("#tauxFixe").slideUp();
            $("#tauxVariable").slideDown();
        }
    }

    if(document.querySelector('[data-kt-pret-filter="search"]')) {
        document.querySelector('[data-kt-pret-filter="search"]').addEventListener("keyup", (function(t) {
            datatablePret.search(t.target.value).draw()
        }))
    }

    if(elements.btnShow) {
        elements.btnShow.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/pret/'+e.target.dataset.pret,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalShowPret)
                        modals.modalShowPret.querySelector('[data-content="title"]').innerHTML = `${data.name}`
                        modals.modalShowPret.querySelector('[data-content="minimum"]').innerHTML = `${data.minimum} €`
                        modals.modalShowPret.querySelector('[data-content="maximum"]').innerHTML = `${data.maximum} €`
                        modals.modalShowPret.querySelector('[data-content="duration"]').innerHTML = `${data.duration} Mois`
                        modals.modalShowPret.querySelector('[data-content="report_echeance"]').innerHTML = data.avantage.report_echeance ? `<i class="fa-solid fa-check text-success me-2"></i> Report d'échéance` : `<i class="fa-solid fa-xmark text-danger me-2"></i> Report d'échéance`
                        modals.modalShowPret.querySelector('[data-content="adapt_mensuality"]').innerHTML = data.avantage.adapt_mensuality ? `<i class="fa-solid fa-check text-success me-2"></i> Adaptabilité des mensualité` : `<i class="fa-solid fa-xmark text-danger me-2"></i> Adaptabilité des mensualité`
                        modals.modalShowPret.querySelector('[data-content="online_subscription"]').innerHTML = data.avantage.online_subscription ? `<i class="fa-solid fa-check text-success me-2"></i> Souscription en ligne` : `<i class="fa-solid fa-xmark text-danger me-2"></i> Souscription en ligne`
                        modals.modalShowPret.querySelector('[data-content="report_echeance_max"]').innerHTML = data.condition.report_echeance_max !== null ? `Jusqu'à ${data.condition.report_echeance_max} fois par an` : `<i class="fa-solid fa-xmark text-danger me-2"></i> Aucun report d'échéance`
                        modals.modalShowPret.querySelector('[data-content="adapt_mensuality_month"]').innerHTML = data.condition.adapt_mensuality_month !== null ? `A partir du ${data.condition.adapt_mensuality_month}eme mois à compté de la signature du contrat` : `<i class="fa-solid fa-xmark text-danger me-2"></i> Aucune possibilité d'adapter la mensualité du crédit`
                        modals.modalShowPret.querySelector('[data-content="type_taux"]').innerHTML = data.tarif.type_taux === 'fixe' ? `Taux Fixe (${data.tarif.interest} %)` : `Taux Variable`
                        modal.show()
                    }
                })
            })
        })
    }
    if(elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/pret/'+e.target.dataset.pret,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditPret)

                        forms.formEditPret.setAttribute('action', '/api/core/pret/'+data.id)
                        modals.modalEditPret.querySelector('[name="name"]').value = data.name
                        modals.modalEditPret.querySelector('[name="minimum"]').value = data.minimum
                        modals.modalEditPret.querySelector('[name="maximum"]').value = data.maximum
                        modals.modalEditPret.querySelector('[name="duration"]').value = data.duration
                        modals.modalEditPret.querySelector('[name="instruction"]').value = data.instruction
                        data.avantage.report_echeance ? modals.modalEditPret.querySelector('[name="report_echeance"]').setAttribute('checked', 'checked') : '';
                        data.avantage.adapt_mensuality ? modals.modalEditPret.querySelector('[name="adapt_mensuality"]').setAttribute('checked', 'checked') : '';
                        data.avantage.online_subscription ? modals.modalEditPret.querySelector('[name="online_subscription"]').setAttribute('checked', 'checked') : '';
                        /*modals.modalEditPret.querySelector('[name="report_echeance_max"]').value = data.condition.report_echeance_max*/
                        modals.modalEditPret.querySelector('[name="adapt_mensuality_month"]').value = data.condition.adapt_mensuality_month
                        modals.modalEditPret.querySelector('[name="interest"]').value = data.tarif.interest
                        modals.modalEditPret.querySelector('[name="min_interest"]').value = data.tarif.min_interest
                        modals.modalEditPret.querySelector('[name="max_interest"]').value = data.tarif.max_interest

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
                    url: '/api/core/pret/'+e.target.dataset.pret,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Un type de pret à été supprimé avec succès`, `Type de pret`)

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

    $(forms.formAddPret).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddPret)
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
                toastr.success(`Le type de pret ${data.name} à été créer avec succès`, `Type de prêt`)

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
    $(forms.formEditPret).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditPret)
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
                toastr.success(`Le type de prêt ${data.name} à été edité avec succès`, `Type de prêt`)

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
