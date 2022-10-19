<script type="text/javascript">
    let tables = {
        tableCustomer: document.querySelector("#liste_customer")
    }
    let elements = {
        app: document.querySelector("#app"),
        data: {
            count_actif_customer: document.querySelector("[data-content='count_actif_customer']"),
            count_disable_customer: document.querySelector("[data-content='count_disable_customer']"),
            count_deposit: document.querySelector("[data-content='count_deposit']"),
            count_withdraw: document.querySelector("[data-content='count_withdraw']"),
            count_loan: document.querySelector("[data-content='count_loan']"),
            count_loan_study: document.querySelector("[data-content='count_loan_study']"),
            count_loan_progress: document.querySelector("[data-content='count_loan_progress']"),
            count_loan_terminated: document.querySelector("[data-content='count_loan_terminated']"),
            count_loan_rejected: document.querySelector("[data-content='count_loan_rejected']"),
            sum_withdraw: document.querySelector("[data-content='sum_withdraw']"),
            sum_deposit: document.querySelector("[data-content='sum_deposit']"),
            sum_agency: document.querySelector("[data-content='sum_agency']"),
        },
        cardAccording: document.querySelector('#card_according'),
        cardCalendar: document.querySelector(".cardCalendar"),
        cardNotification: document.querySelector(".cardNotification"),
        cardMailbox: document.querySelector(".cardMailbox"),
    }
    let modals = {}
    let forms = {}

    let datatableCustomer = $(tables.tableCustomer).DataTable()

    let templateEvent = (event) => {
        return `
        <div class="timeline-item">
            <div class="timeline-label fw-bold text-gray-800 fs-7">${moment(event.start_at).format('hh:mm')}</div>
            <div class="timeline-badge">
                <i class="fa fa-genderless text-${event.type_cl} fs-1"></i>
            </div>
            <div class="fw-mormal timeline-content text-muted ps-3">${event.title}</div>
            <div class="fw-italic text-muted">${moment(event.start_at).diff(moment(), 'minutes') <= 15 ? 'Dans ' + moment(event.start_at).diff(moment(), 'minutes')+ ' Min' : ''}</div>
        </div>
        `
    }
    let templateNotify = (notify) => {
        return `
        <div class="d-flex align-items-center bg-light-${notify.data.color} rounded p-5 mb-7">
            <i class="fa-solid ${notify.data.icon} text-${notify.data.color} fs-1 me-5"></i>
            <div class="flex-grow-1 me-2">
                <a href="/agence/account/notify/${notify.id}" class="fw-bold text-gray-800 text-hover-primary fs-6">${notify.data.title}</a>
                <span class="text-muted fw-semibold d-block">${moment(notify.created_at).diff(moment())}</span>
            </div>
        </div>
        `
    }
    let templateMail = (message) => {
        console.log(message.sender)
        let time = moment(message.created_at)
        return `
        <a href="/agence/account/mailbox/message/${message.id}" class="d-flex flex-row justify-centent-between align-items-center text-black mb-5">
            <div class="d-flex flex-row align-items-center">
                <div class="symbol symbol-50px me-5">
                    ${message.sender.avatar_symbol}
                </div>
                <div class="d-flex flex-column">
                    <div class="fw-bolder">${message.sender.name}</div>
                    <div class="text-muted">${message.subject}</div>
                    <div class="fs-9">${time.diff(moment(), 'days') > 1 ? time.format('D MMM') : time.locale('fr_FR').fromNow(true)}</div>
                </div>
            </div>
        </a>
        `
    }

    let getInfoDashboard = () => {
        let block = new KTBlockUI(elements.app, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement des statistiques...</div>',
            overlayClass: "bg-gray-600",
        })
        block.block()

        $.ajax({
            url: '/api/stat/agentDashboard',
            data: {"user_id": {{ auth()->user()->id }}},
            success: data => {
                elements.data.count_actif_customer.innerHTML = data.count_actif_customer
                elements.data.count_disable_customer.innerHTML = data.count_disable_customer
                elements.data.count_deposit.innerHTML = data.count_deposit
                elements.data.count_withdraw.innerHTML = data.count_withdraw
                elements.data.count_loan.innerHTML = data.count_loan
                elements.data.count_loan_study.innerHTML = data.count_loan_study
                elements.data.count_loan_progress.innerHTML = data.count_loan_progress
                elements.data.count_loan_terminated.innerHTML = data.count_loan_terminated
                elements.data.count_loan_rejected.innerHTML = data.count_loan_rejected
                elements.data.sum_withdraw.innerHTML = data.sum_withdraw
                elements.data.sum_deposit.innerHTML = data.sum_deposit
                elements.data.sum_agency.innerHTML = data.sum_agency
                elements.cardAccording.classList.remove('bg-body')
                elements.cardAccording.classList.add('bg-light-'+data.according_pret_text.color)
                elements.cardAccording.querySelector('.fa-solid').classList.remove('text-danger')
                elements.cardAccording.querySelector('.fa-solid').classList.add('text-'+data.according_pret_text.color)
                elements.cardAccording.querySelector('[data-content="according_pret"]').innerHTML = data.according_pret_text.text

                elements.cardCalendar.querySelector('.timeline-label').innerHTML = ''

                if(data.events.length !== 0) {
                    data.events.forEach(event => {
                        elements.cardCalendar.querySelector('.timeline-label').innerHTML += templateEvent(event)
                    })
                } else {
                    elements.cardCalendar.querySelector('.timeline-label').innerHTML += `<div class="d-flex flex-row justify-content-center align-items-center p-5 bg-light fs-3"><i class="fa-solid fa-triangle-exclamation text-warning fs-1 me-2"></i> Aucun rendez-vous aujourd'hui </div>`
                }

                elements.cardNotification.querySelector('.card-body').innerHTML = '';
                if(data.notifies.length !== 0) {
                    data.notifies.forEach(notify => {
                        elements.cardNotification.querySelector('.card-body').innerHTML += templateNotify(notify)
                    })
                } else {
                    elements.cardNotification.querySelector('.card-body').innerHTML = `<div class="d-flex flex-row justify-content-center align-items-center p-5 bg-light fs-3"><i class="fa-solid fa-triangle-exclamation text-warning fs-1 me-2"></i> Aucune nouvelle notification </div>`;
                }

                elements.cardMailbox.querySelector('.card-body').innerHTML = '';

                if(data.messages.length !== 0) {
                    data.messages.forEach(message => {
                        console.log(message.flags[0])
                        if(message.flags[0].is_unread === 0) {
                            elements.cardMailbox.querySelector('.card-body').innerHTML += templateMail(message)
                        }
                    })
                } else {
                    elements.cardMailbox.querySelector('.card-body').innerHTML = `<div class="d-flex flex-row justify-content-center align-items-center p-5 bg-light fs-3"><i class="fa-solid fa-triangle-exclamation text-warning fs-1 me-2"></i> Aucun nouveau message actuellement </div>`;
                }

                block.release()
                block.destroy()
            }
        })
    }

    getInfoDashboard()
</script>
