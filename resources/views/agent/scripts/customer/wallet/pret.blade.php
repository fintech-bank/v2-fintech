<script type="text/javascript">
    let tables = {
        tableTransaction: document.querySelector("#kt_transaction_table"),
        tableClaims: document.querySelector("#liste_claims"),
    }
    let elements = {}
    let modals = {}
    let forms = {}
    let dataTable = {
        datatableTransaction: $(tables.tableTransaction).DataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>",
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableClaims: $(tables.tableClaims).DataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>",
            info: !1,
            order: [],
            pageLength: 10,
        }),
    }
    let block = {}
</script>
