<script type="text/javascript">
    let tables = {}
    let elements = {
        inputMobilityType: document.querySelectorAll('[name="mobility_type_id"]')
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}
    $("#cloture_old_account").fadeOut()

    if(elements.inputMobilityType) {
        elements.inputMobilityType.forEach(input => {
            input.addEventListener('click', e => {
                e.preventDefault()
                console.log(e)
                if(e.target.value === 1) {
                    $("#cloture_old_account").fadeIn()
                } else {
                    $("#cloture_old_account").fadeOut()
                }
            })
        })
    }
</script>
