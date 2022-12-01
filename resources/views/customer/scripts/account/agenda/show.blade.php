<script type="text/javascript">
    let tables = {}
    let elements = {
        btnCancel: document.querySelector('.btnCancelRdv')
    }
    let modals = {}
    let forms = {
        formPostEventMessage: document.querySelector("#formPostEventMessage")
    }
    let dataTable = {}
    let block = {}

    if(elements.btnCancel) {
        elements.btnCancel.addEventListener('click', e => {
            e.preventDefault()

        })
    }

    $(forms.formPostEventMessage).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formPostEventMessage)
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

                toastr.success(`Votre message à été posté avec succès`, `Message pour votre rendez-vous`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                btn.removeClass('btn-danger')
                btn.addClass('btn-danger')
                btn.find('.indicator-label').html('<i class="fa-solid fa-exclamation-triangle text-white me-2 fs-2"></i> Erreur')

                console.log(err)
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
