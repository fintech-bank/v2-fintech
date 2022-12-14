<script type="text/javascript">
    let tables = {
        tableCustomer: document.querySelector('#kt_customers_table')
    }
    let elements = {
        filterStatus: $('[data-kt-customer-table-filter="status"]'),
        filterTypes: document.querySelectorAll('[data-kt-customer-table-filter="type"] [name="type"]')
    }
    let modals = {}
    let forms = {}
    let dataTable = {
        datatableCustomer: $(tables.tableCustomer).DataTable({
            info: !1,
            order: [],
            columnDefs: [{
                    orderable: !1,
                    targets: 5
                }]
        })
    }
    let block = {}

    document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener('keyup', e => {
        dataTable.datatableCustomer
            .search(e.target.value)
            .draw()
    })

    document.querySelector('[data-kt-customer-table-filter="filter"]').addEventListener("click", () => {
        const n = elements.filterStatus.val()
        let c = ""
        elements.filterTypes.forEach((t => {
            t.checked && (c = t.value),
                "all" === c && (c = "")
        }))

        const r = `${n} ${c}`
        dataTable.datatableCustomer.search(r).draw()
    })
</script>
