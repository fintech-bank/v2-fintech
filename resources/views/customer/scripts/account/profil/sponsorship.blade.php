<script type="text/javascript">
    let tables = {}
    let elements = {
        inputPostal: document.querySelector('[name="postal"]'),
        villeSelect: document.querySelector('#villeSelect')
    }
    let modals = {}
    let forms = {
        formSponsorship: document.querySelector("#formSponsorship")
    }
    let dataTable = {}
    let block = {}

    let selectCity = (item) => {
        $.ajax({
            url: '/api/core/geo/cities/'+item.value,
            success: data => {
                elements.villeSelect.innerHTML = data
            }
        })
    }

    elements.inputPostal.addEventListener('keyup', e => {
        if(e.target.value.length === 5) {
            selectCity(e.target)
        }
    })

    $(forms.formSponsorship).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formSponsorship)
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
