<script type="text/javascript">
    let tables = {
        tableCustomer: document.querySelector('#kt_customers_table')
    }
    let elements = {}
    let modals = {}
    let forms = {}
    let dataTable = {
        datatableCustomer: $(tables.tableCustomer).DataTable({
            info: !1,
            order: [],
            columnDefs: [{
                orderable: !1,
                targets: 0
            },
                {
                    orderable: !1,
                    targets: 6
                }]
        })
    }
    let block = {}
</script>
