<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount")
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount")
    }
    let dataTable = {}
    let block = {}

    $(forms.formUpdateStateAccount).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalUpdateStateAccount.querySelector(".modal-body"))
        let form = $(forms.formUpdateStateAccount)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.block()

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                block.release()
                block.destroy()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`L'état du compte à été mise à jours`, `Changement de l'état du compte`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })

        $.ajax({
            url:
        })
    })

</script>
