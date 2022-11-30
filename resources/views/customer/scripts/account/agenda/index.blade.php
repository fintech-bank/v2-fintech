<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#stepper_rdv"),
        divSubreason: document.querySelector("#divSubreason"),
        inputReason: document.querySelector('[name="reason"]'),
        divQuestion: document.querySelector("#divQuestion"),
        inputSubreason: document.querySelector('[name="subreason"]')
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
                elements.divSubreason.innerHTML = data
            }
        })
    }

    let showQuestion = (item) => {
        elements.divQuestion.classList.remove('d-none')
    }

    elements.inputReason.addEventListener('change', e => {
        e.preventDefault()
        showSubreason(e.target)
    })

    elements.inputSubreason.addEventListener('change', e => {
        e.preventDefault()
        showQuestion(e.target)
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
