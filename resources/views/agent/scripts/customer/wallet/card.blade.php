<script type="text/javascript">
    let tables = {}
    let elements = {
        divEditCard: document.querySelector("#divEditCard"),
        divSendCodeCard: document.querySelector("#divSendCodeCard"),
        divFaceliaCard: document.querySelector("#divFaceliaCard"),
        divCancelCard: document.querySelector("#divCancelCard"),
        divOppositCard: document.querySelector("#divOppositCard"),
        btnEditCard: document.querySelector(".btnEditCard"),
        btnSendCodeCard: document.querySelector(".btnSendCodeCard"),
        btnFaceliaCard: document.querySelector(".btnFaceliaCard"),
        btnCancelCard: document.querySelector(".btnCancelCard"),
        btnOppositCard: document.querySelectorAll(".btnOppositCard"),
    }
    let modals = {}
    let forms = {
        formEditCard: document.querySelector("#formEditCard"),
        formSendCodeCard: document.querySelector("#formSendCodeCard"),
        formFaceliaCard: document.querySelector("#formFaceliaCard"),
        formCancelCard: document.querySelector("#formCancelCard"),
        formOppositCard: document.querySelector("#formOppositCard"),
    }
    let dataTable = {}
    let block = {}

    $(elements.divEditCard).hide();
    $(elements.divSendCodeCard).hide();
    $(elements.divFaceliaCard).hide();
    $(elements.divCancelCard).hide();
    $(elements.divOppositCard).hide();

    elements.btnEditCard.addEventListener('click', () => {
        $(elements.divEditCard).fadeIn();
        $(elements.divSendCodeCard).fadeOut();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeOut();
        $(elements.divOppositCard).fadeOut();
    })
    elements.btnSendCodeCard.addEventListener('click', () => {
        $(elements.divEditCard).fadeOut();
        $(elements.divSendCodeCard).fadeIn();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeOut();
        $(elements.divOppositCard).fadeOut();
    })
    if(elements.btnFaceliaCard) {
        elements.btnFaceliaCard.addEventListener('click', () => {
            $(elements.divEditCard).fadeOut();
            $(elements.divSendCodeCard).fadeOut();
            $(elements.divFaceliaCard).fadeIn();
            $(elements.divCancelCard).fadeOut();
            $(elements.divOppositCard).fadeOut();
        })
    }
    elements.btnCancelCard.addEventListener('click', () => {
        $(elements.divEditCard).fadeOut();
        $(elements.divSendCodeCard).fadeOut();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeIn();
        $(elements.divOppositCard).fadeOut();
    })
    elements.btnOppositCard.forEach(btn => {
        btn.addEventListener('click', () => {
            $(elements.divEditCard).fadeOut();
            $(elements.divSendCodeCard).fadeOut();
            $(elements.divFaceliaCard).fadeOut();
            $(elements.divCancelCard).fadeOut();
            $(elements.divOppositCard).fadeIn();
        })
    })

    $(forms.formEditCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Les informations de la carte bancaire {{ $card->number }} on été mise à jour`, `Carte Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formSendCodeCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formSendCodeCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Le code de la carte bancaire {{ $card->number }} à été renvoyé au client`, `Carte Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formFaceliaCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formFaceliaCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: (data) => {
                console.log(data)
                if(data.state === 'success') {
                    btn.removeAttr('data-kt-indicator')

                    toastr.success(`La souscription au crédit renouvelable FACELIA à été pris en compte`, `Carte Bancaire`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                } else {
                    btn.removeAttr('data-kt-indicator')

                    toastr.warning(`${data.message}`, `Carte Bancaire`)
                    if(data.data.errors) {
                        console.log(data.data.errors)
                        Array.from(data.data.errors).forEach(error => {
                            toastr.warning(`${error}`, `Carte Bancaire`)
                        })
                    }
                }
            },
            error: data => {
                btn.removeAttr('data-kt-indicator')

                toastr.error(`${data.message}`, `Carte Bancaire`)
            }
        })
    })
    $(forms.formCancelCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formCancelCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`La carte bancaire {{ $card->number }} à bien été annulé`, `Carte Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formOppositCard).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formOppositCard)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`La requête d'opposition pour la carte {{ $card->number_format }} à bien été enregistré`, `Carte Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })

</script>
