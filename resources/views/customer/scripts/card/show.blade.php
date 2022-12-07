<script type="text/javascript">
    let tables = {}
    let elements = {
        btnDesactiveCard: document.querySelector('.btnDesactiveCard'),
        btnActiveCard: document.querySelector('.btnActiveCard'),
    }
    let modals = {}
    let forms = {
        formOppositCard: document.querySelector("#formOppositCard")
    }
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


    $(forms.formOppositCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formOppositCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('[type="submit"]')
        let method = form.find('[name="_method"]').val()

        btn.attr('data-kt-indicator', 'on')

        Swal.fire({
            title: 'Êtes-vous sur ?',
            text: "La création d'un dossier d'opposition va bloquer votre carte bancaire ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui!'
        }).then((result) => {
            if (result.isConfirmed) {
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
            }
        })


    })
</script>
