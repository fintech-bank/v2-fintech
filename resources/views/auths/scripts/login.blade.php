<script type="text/javascript">
    let tables = {}
    let elements = {
        formLoginElement: document.querySelector("#formLogin"),
        alertError: document.querySelector("#alert")
    }
    let modals = {}
    let forms = {
        formLogin: $("#formLogin")
    }

    forms.formLogin.on('submit', e => {
        e.preventDefault()
        let form = forms.formLogin
        let url = form.attr('action')
        let data = form.serializeArray()

        elements.formLoginElement.querySelector(".btn-bank").setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            statusCode: {
                204: () => {
                    elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
                    window.location.href='/redirect'
                },
                302: () => {
                    elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
                    window.location.href='/redirect'
                },
                500: err => {
                    elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
                    toastr.error("Une erreur à eu lieu !", "Erreur serveur")
                },
                422: err => {
                    elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
                    const errors = err.responseJSON.errors

                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key], "Champs: "+key)
                    })
                },
            }
        })
    })
</script>
