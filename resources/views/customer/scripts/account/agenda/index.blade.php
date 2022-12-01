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

    mobiscroll.setOptions({
        locale: mobiscroll.localeFr,
        theme: 'ios',
        themeVariant: 'light'
    })

    let min = '{{ now()->format('Y-m-dT00:00') }}';
    let max = '{{ now()->addMonths(6)->format('Y-m-dT00:00') }}';

    $("[name='start_at']").mobiscroll.datepicker({
        display: 'inline',
        controls: ['calendar', 'timegrid'],      // More info about controls: https://docs.mobiscroll.com/5-20-0/calendar#opt-controls
        min: min,                                // More info about min: https://docs.mobiscroll.com/5-20-0/calendar#opt-min
        max: max,                                // More info about max: https://docs.mobiscroll.com/5-20-0/calendar#opt-max
        minTime: '08:00',
        maxTime: '19:59',
        stepMinute: 60,
        width: null,
    });

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

    let stepperRdv = new KTStepper(elements.stepperElement)

    stepperRdv.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });

    // Handle previous step
    stepperRdv.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });
</script>
