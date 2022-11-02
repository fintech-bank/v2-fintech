<script type="text/javascript">
    let tables = {}
    let elements = {
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
        outstanding: document.querySelector('#outstanding'),
        epargnePlanInfo: document.querySelector("#epargne_plan_info"),
        pretPlanInfo: document.querySelector("#pret_plan_info"),
    }
    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus'),
        modalUpdateTypeAccount: document.querySelector('#updateAccount'),
        modalWriteSms: document.querySelector('#write-sms'),
        modalWriteMail: document.querySelector('#write-mail'),
        modalCreateWallet: document.querySelector('#createWallet'),
        modalCreateEpargne: document.querySelector('#createEpargne'),
        modalCreatePret: document.querySelector('#createPret'),
    }
    let forms = {}
    let dataTable = {}
    let block = {}

    let verifSoldesAllWallets = () => {
        $.ajax({
            url: `/api/customer/{{ $customer->id }}/verifAllSolde`,
            success: data => {
                let arr = Array.from(data)

                arr.forEach(item => {
                    if (item.status === 'outdated') {
                        toastr.error(`Le compte ${item.compte} est débiteur, veuillez contacter le client`, 'Compte Débiteur')
                    }
                })
            }
        })
    }
    verifSoldesAllWallets()

    elements.btnPass.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitPass`,
            method: 'put',
            success: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le mot de passe du client à été réinitialiser", "Réinitialisation du mot de passe")
            },
            error: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du mot de passe", "Erreur système")
            }
        })
    })
    elements.btnCode.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitCode`,
            method: 'put',
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le Code SECURPASS du client à été réinitialiser", "Réinitialisation du code SECURPASS")
            },
            error: err => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
            }
        })
    })
    if (elements.btnAuth) {
        elements.btnAuth.addEventListener('click', e => {
            e.preventDefault()

            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/api/customer/${elements.btnCode.dataset.customer}/reinitAuth`,
                method: 'put',
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.success("L'authentification double facteur du client à été réinitialiser", "Réinitialisation de l'authentificateur")
                },
                error: err => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
                }
            })
        })
    }
</script>
