<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}
    let forms = {
        formGrpdConsent: document.querySelector('#formGrpdConsent'),
        formGrpdRip: document.querySelector('#formGrpdRip'),
        formDroitAcces: document.querySelector('#formDroitAcces'),
        formInacturate: document.querySelector('#formInacturate'),
        formComProspecting: document.querySelector('#formComProspecting'),
    }
    let dataTable = {}
    let block = {}

    let selectDroitAccesType = (item) => {
        if (item.value === 'other') {
            forms.formDroitAcces.querySelector(".other").classList.remove('d-none')
        } else {
            forms.formDroitAcces.querySelector(".other").classList.add('d-none')
        }
    }

    $(forms.formGrpdConsent).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formGrpdConsent)
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
    $(forms.formGrpdRip).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formGrpdRip)
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
    $(forms.formDroitAcces).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formDroitAcces)
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
    $(forms.formInacturate).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formInacturate)
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
    $(forms.formComProspecting).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formComProspecting)
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
