<script type="text/javascript">
    let tables = {
        tableReseller: document.querySelector('#kt_reseller_table')
    }
    let elements = {
        btnDeleteReseller: document.querySelectorAll(".btnDeleteReseller")
    }
    let modals = {}
    let forms = {
        formAddReseller: document.querySelector('#formAddReseller')
    }

    let datatableReseller = $(tables.tableReseller).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })

    if(elements.btnDeleteReseller) {
        elements.btnDeleteReseller.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/reseller/'+e.target.dataset.reseller,
                    method: 'DELETE',
                    success: () => {
                        toastr.success(`Le distributeur à été supprimé avec succès.`, `Suppression d'un distributeur`)

                        setTimeout(function () {
                            window.location.reload()
                        }, 1200)
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            })
        })
    }

    if(document.querySelector('[data-kt-reseller-filter="search"]')) {
        document.querySelector('[data-kt-reseller-filter="search"]').addEventListener("keyup", (function(t) {
            datatableReseller.search(t.target.value).draw()
        }))
    }
</script>
