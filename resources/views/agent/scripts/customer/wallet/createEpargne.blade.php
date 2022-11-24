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
</script>
