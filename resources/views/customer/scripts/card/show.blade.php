<script type="text/javascript">
    let tables = {}
    let elements = {
        btnDesactiveCard: document.querySelector('.btnDesactiveCard'),
        btnActiveCard: document.querySelector('.btnActiveCard'),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    if(elements.btnDesactiveCard) {
        elements.btnDesactiveCard.addEventListener('click', e => {
            e.preventDefault()
            elements.btnDesactiveCard.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: '/api/card/{{ $card->id }}',
                method: 'PUT',
                data: {"action": "desactiveCard"},
                success: data => {
                    elements.btnDesactiveCard.removeAttr('data-kt-indicator')
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
                    elements.btnDesactiveCard.removeAttr('data-kt-indicator')
                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                }
            })
        })

        $().on('submit', e => {
            e.preventDefault()
            let form = $()
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
    }
</script>
