<script type="text/javascript">
    let tables = {}
    let elements = {
        calendarApp: document.querySelector('#kt_calendar_app'),
        btnNewEvent: document.querySelector('[data-kt-calendar="add"]')
    }
    let modals = {
        modalViewEvent: document.querySelector('#kt_modal_view_event'),
        modalAddEvent: document.querySelector("#kt_modal_add_event")
    }
    let forms = {
        formAddEvent: document.querySelector("#kt_modal_add_event_form")
    }

    let formatEvent = {
        id: "",
        eventName: "",
        eventDescription: "",
        eventLocation: "",
        startDate: "",
        endDate: "",
        allDay: !1,
        eventDuration: ""
    }
    let l = flatpickr(forms.formAddEvent.querySelector('#kt_calendar_datepicker_end_date'), {
        enableTime: !1,
        dateFormat: "Y-m-d",
        locale: 'fr'
    })
    let r = flatpickr(forms.formAddEvent.querySelector('#kt_calendar_datepicker_start_date'), {
        enableTime: !1,
        dateFormat: "Y-m-d",
        locale: 'fr'
    })
    let s = flatpickr(forms.formAddEvent.querySelector('#kt_calendar_datepicker_start_time'), {
        enableTime: !0,
        noCalendar: !0,
        dateFormat: "H:i",
        locale: 'fr'
    })
    let t = flatpickr(forms.formAddEvent.querySelector('#kt_calendar_datepicker_end_time'), {
        enableTime: !0,
        noCalendar: !0,
        dateFormat: "H:i",
        locale: 'fr'
    })

    let N = e => {
        formatEvent.id = e.id,
            formatEvent.eventName = e.title,
            formatEvent.eventDescription = e.description,
            formatEvent.eventLocation = e.location,
            formatEvent.startDate = e.startStr,
            formatEvent.endDate = e.endStr,
            formatEvent.allDay = e.allDay
            formatEvent.eventDuration = e.duration
    }
    const x = () => {
            v.innerText = "Add a New Event", u.show();
            const o = f.querySelectorAll('[data-kt-calendar="datepicker"]'),
                i = f.querySelector("#kt_calendar_datepicker_allday");
            i.addEventListener("click", (e => {
                e.target.checked ? o.forEach((e => {
                    e.classList.add("d-none")
                })) : (l.setDate(M.startDate, !0, "Y-m-d"), o.forEach((e => {
                    e.classList.remove("d-none")
                })))
            })), C(M), D.addEventListener("click", (function(o) {
                o.preventDefault(), p && p.validate().then((function(o) {
                    console.log("validated!"), "Valid" == o ? (D.setAttribute("data-kt-indicator", "on"), D.disabled = !0, setTimeout((function() {
                        D.removeAttribute("data-kt-indicator"), Swal.fire({
                            text: "New event added to calendar!",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then((function(o) {
                            if (o.isConfirmed) {
                                u.hide(), D.disabled = !1;
                                let o = !1;
                                i.checked && (o = !0), 0 === c.selectedDates.length && (o = !0);
                                var d = moment(r.selectedDates[0]).format(),
                                    s = moment(l.selectedDates[l.selectedDates.length - 1]).format();
                                if (!o) {
                                    const e = moment(r.selectedDates[0]).format("YYYY-MM-DD"),
                                        t = e;
                                    d = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss"), s = t + "T" + moment(m.selectedDates[0]).format("HH:mm:ss")
                                }
                                e.addEvent({
                                    id: A(),
                                    title: t.value,
                                    description: n.value,
                                    location: a.value,
                                    start: d,
                                    end: s,
                                    allDay: o
                                }), e.render(), f.reset()
                            }
                        }))
                    }), 2e3)) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }

    let B = (ed) => {
        console.log(ed)
        var e, t, n, k;
        w.show(),
            formatEvent.allDay ? (e = "All Day", t = moment(formatEvent.startDate).format("Do MMM, YYYY"),
                n = moment(formatEvent.endDate).format("Do MMM, YYYY")) :
                (e = "", t = moment(formatEvent.startDate).format("DD/MM/YYYY à hh:mm"), n = moment(formatEvent.endDate).format("DD/MM/YYYY à hh:mm"), k = moment(formatEvent.endDate).diff(moment(formatEvent.startDate), 'minutes')+ 'min'),
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_name"]').innerText = formatEvent.eventName,
            modals.modalViewEvent.querySelector('[data-kt-calendar="all_day"]').innerText = e,
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_description"]').innerText =
                formatEvent.eventDescription ? formatEvent.eventDescription : "--",
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_location"]').innerText =
                formatEvent.eventLocation ? formatEvent.eventLocation : "--",
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_start_date"]').innerText = t,
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_end_date"]').innerText = n,
            modals.modalViewEvent.querySelector('[data-kt-calendar="event_duration_date"]').innerText = k
    }

    let A = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();
    let O = moment().startOf("day")
    let I = O.format("YYYY-MM")
    let R = O.clone().subtract(1, "day").format("YYYY-MM-DD")
    let V = O.format("YYYY-MM-DD")
    let P = O.clone().add(1, "day").format("YYYY-MM-DD")
    let formAddEvent = (calendar) => {
        $(forms.formAddEvent).on('submit', e => {
            e.preventDefault()
            let form = $(forms.formAddEvent)
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
                    m.hide()
                    calendar.addEvent({
                        id: A(),
                        title: t.value,
                        description: n.value,
                        location: a.value,
                        start: d,
                        end: s,
                        allDay: o
                    })
                    calendar.render()

                    toastr.success(`L'évènement ${data.title} à été ajouté avec succès`, `Rendez-vous`)
                },
                error: err => {
                    btn.removeAttr('data-kt-indicator')
                    toastr.error(`Erreur lors de l'execution du script serveur`, `Erreur Système`)
                }
            })
        })
    }
    let optionAttendeeFormat = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let template = '';

        template += '<div class="d-flex align-items-center">';
        template += item.element.getAttribute('data-avatar');
        template += '<div class="d-flex flex-column">'
        template += '<span class="fs-4 fw-bold lh-1">' + item.text + '</span>';
        template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-type') + '</span>';
        template += '</div>';
        template += '</div>';

        span.innerHTML = template;

        return $(span);
    }

    let w = new bootstrap.Modal(modals.modalViewEvent)
    let m = new bootstrap.Modal(modals.modalAddEvent)

    elements.btnNewEvent.addEventListener('click', e => {
        forms.formAddEvent.querySelector('[data-kt-calendar="title"]').innerHTML = "Nouveau rendez-vous"
        const datepickers = forms.formAddEvent.querySelectorAll('[data-kt-calendar="datepicker"]'),
            allday = forms.formAddEvent.querySelector('#kt_calendar_datepicker_allday');

        allday.addEventListener('click', e => {
            e.target.checked ? datepickers.forEach((datepicker) => {
                datepicker.classList.add('d-none')
            }) : (l.setDate(formatEvent.startDate, !0, 'Y-m-d'), datepickers.forEach((datepicker) => {
                datepicker.classList.remove('d-none')
            }))
        })



        m.show()
    })

    $(".attendeesSelect").select2({
        placeholder: "Select an option",
        minimumResultsForSearch: Infinity,
        templateSelection: optionAttendeeFormat,
        templateResult: optionAttendeeFormat
    })

    $.ajax({
        url: '/api/calendar/list',
        method: 'POST',
        data: {'user_id': {{ auth()->user()->id }}},
        success: data => {
            let calendar = new FullCalendar.Calendar(elements.calendarApp, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },
                initialView: 'timeGridDay',
                initialDate: "{{ now()->format('Y-m-d') }}",
                locale: 'fr',
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                nowIndicator: true,
                businessHours: {
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Thursday

                    startTime: '08:30', // a start time (10am in this example)
                    endTime: '17:30', // an end time (6pm in this example)
                },
                select: function(e) {
                    N(e)
                    x()
                },
                eventClick: function(e) {
                    N({
                        id: e.event.id,
                        title: e.event.title,
                        description: e.event.extendedProps.description,
                        location: e.event.extendedProps.location,
                        startStr: e.event.startStr,
                        endStr: e.event.endStr,
                        allDay: e.event.allDay,
                        duration: e.event.duration
                    })
                    B()
                },
                editable: !0,
                dayMaxEvents: !0,
                events: data,
                datesSet: function() {}
            })

            calendar.render()
            formAddEvent(calendar)
        }
    })


</script>
