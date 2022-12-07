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
                    elements.btnDesactiveCard.removeAttribute('data-kt-indicator')
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
                    elements.btnDesactiveCard.removeAttribute('data-kt-indicator')
                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                }
            })
        })
    }
    if(elements.btnActiveCard) {
        elements.btnActiveCard.addEventListener('click', e => {
            e.preventDefault()
            elements.btnActiveCard.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: '/api/card/{{ $card->id }}',
                method: 'PUT',
                data: {"action": "activeCard"},
                success: data => {
                    elements.btnActiveCard.removeAttribute('data-kt-indicator')
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
                    elements.btnActiveCard.removeAttribute('data-kt-indicator')
                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                }
            })
        })
    }
</script>
