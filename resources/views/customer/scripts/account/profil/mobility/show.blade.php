<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}
    let forms = {
        formSelectMvmBank: document.querySelector("#formSelectMvmBank")
    }
    let dataTable = {}
    let block = {}

    $(forms.formSelectMvmBank).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formSelectMvmBank)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('[type="submit"]')
        let method = form.find('[name="_method"]').val()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                if(data.state === 'warning') {
                    toastr.warning(`${data.message}`)
                } else {
                    toastr.success(`${data.message}`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                }
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
