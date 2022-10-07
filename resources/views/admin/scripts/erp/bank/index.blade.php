<script type="text/javascript">
    let tables = {
        tableBank: document.querySelector('#kt_bank_table')
    }
    let elements = {}
    let modals = {}
    let forms = {}

    let datatableBank = $(tables.tableBank).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })

    document.querySelector('[data-kt-bank-filter="search"]').addEventListener("keyup", (function(t) {
        datatableBank.search(t.target.value).draw()
    }))
</script>
