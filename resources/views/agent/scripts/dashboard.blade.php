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
        cardAccording: document.querySelector('#card_according')
    }
    let modals = {}
    let forms = {}

    let datatableCustomer = $(tables.tableCustomer).DataTable()

    let getInfoDashboard = () => {
        let block = new KTBlockUI(elements.app, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement des statistiques...</div>',
            overlayClass: "bg-gray-600",
        })
        block.block()

        $.ajax({
            url: '/api/stat/agentDashboard',
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

                block.release()
                block.destroy()
            }
        })
    }

    getInfoDashboard()
</script>
