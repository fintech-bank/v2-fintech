<script type="text/javascript">
    let tables = {}
    let elements = {
        btnCancelRequest: document.querySelectorAll('.btnCancelRequest')
    }
    let modals = {}
    let forms = {
        formGrpdConsent: document.querySelector('#formGrpdConsent'),
        formGrpdRip: document.querySelector('#formGrpdRip'),
        formDroitAcces: document.querySelector('#formDroitAcces'),
        formInacturate: document.querySelector('#formInacturate'),
        formComProspecting: document.querySelector('#formComProspecting'),
        formErasure: document.querySelector('#formErasure'),
        formLimit: document.querySelector('#formLimit'),
        formPortability: document.querySelector('#formPortability'),
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

    if(elements.btnCancelRequest) {
        elements.btnCancelRequest.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                btn.setAttribute('data-kt-indicator', 'on')

                $.ajax({
                    url: '/api/user/{{ $customer->user->id }}',
                    method: 'DELETE',
                    data: {'action': 'cancelRequest'},
                    success: data => {
                        btn.removeAttribute('data-kt-indicator')
                        $(e.target.parentNode.parentNode).fadeOut()
                    },
                    error: err => {
                        btn.removeAttribute('data-kt-indicator')
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            })
        })
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
    $(forms.formErasure).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formErasure)
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
    $(forms.formLimit).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formLimit)
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
    $(forms.formPortability).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formPortability)
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
