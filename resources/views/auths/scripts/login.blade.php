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
            success: data => {
                elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
            },
            error: err => {
                elements.formLoginElement.querySelector(".btn-bank").removeAttribute('data-kt-indicator')
            }
        })
    })
</script>
