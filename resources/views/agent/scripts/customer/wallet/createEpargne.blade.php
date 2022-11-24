<script type="text/javascript">
    let tables = {}
    let elements = {
        inputEpargnePlanId: document.querySelector('[name="epargne_plan_id"]')
    }
    let modals = {}
    let forms = {
        formAddEpargne: document.querySelector('#formAddEpargne')
    }
    let dataTable = {}
    let block = {
        blockForm: new KTBlockUI(forms.formAddEpargne)
    }

    if(elements.inputEpargnePlanId) {
        elements.inputEpargnePlanId.addEventListener('change', e => {
            e.preventDefault()
            block.blockForm.block()

            $.ajax({
                url: '/api/core/epargne/'+e.target.value,
                success: data => {
                    block.blockForm.release()
                    block.blockForm.destroy()
                    console.log(data)

                    document.querySelector('[data-content="profit_percent"]').innerHTML = data.profit_percent_format
                    document.querySelector('[data-content="profit_days"]').innerHTML = data.profit_days === 0 ? 'Indisponible' : `Tous les ${data.profit_days} jours`;
                    document.querySelector('[data-content="lock_days"]').innerHTML = data.lock_days === 0 ? 'Disponible immédiatement' : (data.lock_days === 999999 ? 'Montant non déblocable' : `Au bout de ${data.lock_days} Jours`);
                    document.querySelector('[data-content="init"]').innerHTML = data.init === 0 ? 'Montant libre' : `${data.init_format}`
                    document.querySelector('[data-content="limit_amount"]').innerHTML = data.limit_amount === 0 ? 'Libre' : `${data.limit_amount_format}`

                    document.querySelector('#resultSimulation').classList.remove('d-none')
                    forms.formAddEpargne.querySelector('.btn-bank').removeAttribute('disabled')
                }
            })
        })
    }

    $(forms.formAddEpargne).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddEpargne);
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')

                if(data.state === 'warning') {
                    toastr.warning(`${data.message}`, `Création d'un compte d'épargne`)
                } else {
                    toastr.success(`Le compte d'épargne N°${data.data.reference} à été créer avec succès`, `Création d'un compte d'épargne`)

                    setTimeout(() => {
                        window.location.href='{{ route('agent.customer.show', $customer->id) }}'
                    }, 1200)
                }
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')

                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
