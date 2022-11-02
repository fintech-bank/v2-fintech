<script type="text/javascript">
    let tables = {}
    let elements = {
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

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
            url: `/agence/customers/${elements.btnCode.dataset.customer}/reinitCode`,
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
                url: `/agence/customers/${elements.btnCode.dataset.customer}/reinitAuth`,
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
