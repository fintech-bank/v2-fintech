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
            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/api/calendar/${e.target.dataset.event}`,
                method: 'DELETE',
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')

                    toastr.success(`Votre rendez-vous à été annulé avec succès`, `Votre rendez-vous`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                },
                error: err => {
                    e.target.removeAttribute('data-kt-indicator')
                    e.target.classList.remove('btn-danger')
                    e.target.classList.add('btn-danger')
                    e.target.queryselector('.indicator-label').html('<i class="fa-solid fa-exclamation-triangle text-white me-2 fs-2"></i> Erreur')

                    console.log(err)
                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                }
            })
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
