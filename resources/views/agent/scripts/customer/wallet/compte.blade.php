<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalRequestOverdraft: document.querySelector("#requestOverdraft")
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount")
    }
    let dataTable = {}
    let block = {}

    document.querySelector('.requestOverdraft').addEventListener('click', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
        block.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->id }}/request/overdraft',
            method: 'POST',
            success: data => {
                block.release()
                block.destroy()
                console.log(data)
            }
        })
    })

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
    })

</script>
