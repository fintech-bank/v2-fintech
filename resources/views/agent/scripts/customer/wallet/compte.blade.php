<script type="text/javascript">
    let tables = {}
    let elements = {
        btnShowRib: document.querySelector('.showRib')
    }
    let modals = {
        modalShowRib: document.querySelector('#showRib'),
    }
    let forms = {}
    let dataTable = {}
    let block = {}

    elements.btnShowRib.addEventListener('click', e => {
        e.preventDefault()
        let modal = new bootstrap.Modal(modals.modalShowRib)
        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}',
            success: data => {
                modal.show()
                console.log(data)
            }
        })
    })
</script>
