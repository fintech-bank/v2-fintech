<script type="text/javascript">
    let tables = {
        tableTransaction: document.querySelector("#kt_transaction_table"),
        tableClaims: document.querySelector("#liste_claims"),
        tableCaution: document.querySelector("#liste_caution"),
    }
    let elements = {}
    let modals = {}
    let forms = {
        formAddClaim: document.querySelector("#formAddClaim")
    }
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
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableCaution: $(tables.tableCaution).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
    }
    let block = {}

    $(forms.formAddClaim).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddClaim)
        let url = '/api/insurance/{{ $wallet->loan->insurance->reference }}/claim'
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La déclaration de sinitre à bien été enregistré`, `Déclaration de sinistre`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
