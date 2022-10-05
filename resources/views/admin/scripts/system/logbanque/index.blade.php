<script type="text/javascript">
    let tables = {
        tableLog: document.querySelector("#kt_log_bank_table")
    }
    let elements = {
        filterTableType: document.querySelector('[data-kt-ecommerce-product-filter="status"]')
    }
    let modals = {}
    let forms = {}

    let datatableLog = $(tables.tableLog).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })

    const t = document.querySelector('[data-kt-log-bank-filter="type"]');
    $(t).on("change", (t => {
        let o = t.target.value;
        "all" === o && (o = "")
        datatableLog.column(1).search(o).draw()
    }))

    document.querySelector('[data-kt-log-bank-filter="search"]').addEventListener("keyup", (function(t) {
        e.search(t.target.value).draw()
    }))
</script>
