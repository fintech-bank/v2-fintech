<script type="text/javascript">
    let tables = {
        tableReseller: document.querySelector('#kt_reseller_table')
    }
    let elements = {}
    let modals = {}
    let forms = {
        formAddReseller: document.querySelector('#formAddReseller')
    }

    let datatableReseller = $(tables.tableReseller).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })

    document.querySelector('[data-kt-reseller-filter="search"]').addEventListener("keyup", (function(t) {
        datatableReseller.search(t.target.value).draw()
    }))
</script>
