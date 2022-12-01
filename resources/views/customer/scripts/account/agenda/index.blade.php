<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#stepper_rdv"),
        divSubreason: document.querySelector("#divSubreason"),
        inputReason: document.querySelector('[name="reason_id"]'),
        divQuestion: document.querySelector("#divQuestion"),
        inputSubreason: document.querySelector('[name="subreason_id"]')
    }
    let modals = {}
    let forms = {
        formRdv: document.querySelector("#form_rdv")
    }
    let dataTable = {}
    let block = {}

    mobiscroll.setOptions({
        locale: mobiscroll.localeFr,
        theme: 'ios',
        themeVariant: 'light'
    })

    let min = '{{ now() }}';
    let max = '{{ now()->addMonths(6) }}';



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

    let getDisponibility = (agent_id, callback) => {
        let invalid = [];
        let valid = [];
        console.log("Agent:"+agent_id)

        mobiscroll.util.http.getJson(`/api/calendar/disponibility?agent_id=${agent_id}&start=${min}&end=${max}`, (bookings) => {
            console.log(bookings)
            for (let i = 0; i < bookings.length; ++i) {
                let booking = bookings[i];
                let bDate = new Date(booking.d);

                if (booking.nr > 0) {
                    labels.push({
                        start: bDate,
                        title: booking.nr + ' SPOTS',
                        textColor: '#e1528f'
                    });
                    $.merge(invalid, booking.invalid);
                } else {
                    invalid.push(bDate);
                }
            }
            callback({ labels: labels, invalid: invalid });
        }, 'jsonp')
    }

    let checkAgentId = (item) => {
        console.log("Click:"+item.value)
        $("#date_rdv").mobiscroll().datepicker({
            display: 'inline',
            controls: ['calendar', 'timegrid'],      // More info about controls: https://docs.mobiscroll.com/5-20-0/calendar#opt-controls
            min: min,                                // More info about min: https://docs.mobiscroll.com/5-20-0/calendar#opt-min
            max: max,                                // More info about max: https://docs.mobiscroll.com/5-20-0/calendar#opt-max
            minTime: '09:00',
            maxTime: '18:29',
            stepMinute: 30,
            width: null,
            returnFormat: 'iso8601',
            onChange: (event, inst) => {
                getDisponibility(item.value, event.firstDay, function callback(bookings) {
                    inst.setOptions({
                        labels: bookings.labels,     // More info about labels: https://docs.mobiscroll.com/5-20-0/calendar#opt-labels
                        invalid: bookings.invalid    // More info about invalid: https://docs.mobiscroll.com/5-20-0/calendar#opt-invalid
                    });
                });
                $("[name='start_at']").val(event.value)
            },
        });
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

    $(forms.formRdv).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formRdv)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('[data-kt-stepper-action="submit"]')

        console.log(data)
        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                toastr.success(`Votre demande de rendez-vous à bien été enregistré`, `Mes Rendez-vous`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
</script>
