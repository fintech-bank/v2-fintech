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
                }
            })
        })
    }
</script>
