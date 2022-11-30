<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#stepper_rdv"),
        inputSubreason: document.querySelector("#inputSubreason"),
        inputReason: document.querySelector('[name="reason"]')
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    let showSubreason = (item) => {
        $.ajax({
            url: '/api/calendar/subreason',
            method: 'POST',
            data: {"reason_id": item.value},
            success: data => {
                elements.inputSubreason.innerHTML = data
            }
        })
    }

    elements.inputReason.addEventListener('change', e => {
        e.preventDefault()
        showSubreason(e.target)
    })

    let stepperRdv = new KTStepper(elements.stepperElement)

    stepperRdv.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });

    // Handle previous step
    stepperRdv.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });
</script>
