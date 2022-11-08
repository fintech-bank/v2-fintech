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
        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/{{ $wallet->number_account }}',
            success: data => {
                console.log(data)
            }
        })
    })
</script>
