<script type="text/javascript">
    let tables = {}
    let elements = {
        chart_expense: document.querySelector('#chart_expense'),
    }
    let modals = {
        modalRequestOverdraft: document.querySelector("#RequestOverdraft")
    }
    let forms = {
        formRequestOverdraft: document.querySelector("#formRequestOverdraft")
    }
    let dataTable = {}
    let block = {
        blockRequestOverdraft: new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
    }

    $(modals.modalRequestOverdraft).on('shown.bs.modal', e => {
        block.blockRequestOverdraft.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/request/overdraft',
            method: 'POST',
            success: data => {
                console.log(data)
            }
        })
    })
</script>
