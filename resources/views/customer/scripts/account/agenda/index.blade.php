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

    let min = '{{ now() }}';
    let max = '{{ now()->addMonths(6) }}';

    $("#date_rdv").mobiscroll().datepicker({
        display: 'inline',
        controls: ['calendar', 'timegrid'],      // More info about controls: https://docs.mobiscroll.com/5-20-0/calendar#opt-controls
        min: min,                                // More info about min: https://docs.mobiscroll.com/5-20-0/calendar#opt-min
        max: max,                                // More info about max: https://docs.mobiscroll.com/5-20-0/calendar#opt-max
        minTime: '09:00',
        maxTime: '18:29',
        stepMinute: 30,
        width: null,
        onPageLoading: function (event, inst) {  // More info about onPageLoading: https://docs.mobiscroll.com/5-20-0/calendar#event-onPageLoading
            console.log(event.firstDay.getMonth())
            getDisponibility(event.firstDay, function callback(bookings) {
                inst.setOptions({
                    labels: bookings.labels,     // More info about labels: https://docs.mobiscroll.com/5-20-0/calendar#opt-labels
                    invalid: bookings.invalid    // More info about invalid: https://docs.mobiscroll.com/5-20-0/calendar#opt-invalid
                });
            });
        }
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

    let getDisponibility = (day, callback) => {
        let invalid = [];
        let valid = [];

        mobiscroll.util.http.getJson(`/api/calendar/disponibility?agent_id=${document.querySelector('[name="agent_id"]').value}&start=${min}&end=${max}`, (bookings) => {
            console.log(bookings)
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
