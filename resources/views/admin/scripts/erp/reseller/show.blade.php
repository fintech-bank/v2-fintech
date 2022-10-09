<script type="text/javascript">
    let tables = {
        tableOutgoing: document.querySelector('#kt_outgoing_table'),
        tableIncoming: document.querySelector('#kt_incoming_table'),
        tableInvoice: document.querySelector('#kt_invoice_table'),
    }
    let elements = {
        inputType: document.querySelector('[name="type"]'),
        inputState: document.querySelector('[name="state"]'),
        inputSearchOutgoing: document.querySelector('[data-kt-outgoing-filter="search"]'),
        inputStatusOutgoing: document.querySelector('[data-kt-outgoing-filter="status"]'),
        inputSearchIncoming: document.querySelector('[data-kt-incoming-filter="search"]'),
        inputStatusIncoming: document.querySelector('[data-kt-incoming-filter="status"]'),
        inputSearchInvoice: document.querySelector('[data-kt-invoice-filter="search"]'),
        inputStatusInvoice: document.querySelector('[data-kt-invoice-filter="status"]'),
    }
    let modals = {}
    let forms = {}

    let datatableOutgoing = $(tables.tableOutgoing).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })
    let datatableIncoming = $(tables.tableIncoming).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })
    let datatableInvoice = $(tables.tableInvoice).DataTable({
        info: !1,
        order: [],
        pageLength: 10
    })

    let changeType = (type) => {
        let blockType = new KTBlockUI(elements.inputType.parentNode.parentNode)
        blockType.block()

        $.ajax({
            url: '/api/core/reseller/{{ $reseller->id }}',
            method: 'PUT',
            data: {"action": "updateType", "type": type.value},
            success: data => {
                blockType.release()
                blockType.destroy()
                toastr.success(`Le type du distributeur ${data.dab.name} à été mis à jours par ${data.dab.type_string}.`, `Mise à jour du type`)
            },
            error: () => {
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    }

    let changeState = (state) => {
        let blockState = new KTBlockUI(elements.inputState.parentNode.parentNode)
        blockState.block()

        $.ajax({
            url: '/api/core/reseller/{{ $reseller->id }}',
            method: 'PUT',
            data: {"action": "updateState", "state": state.value},
            success: data => {
                blockState.release()
                blockState.destroy()
                toastr.success(`Le statut du distributeur ${data.dab.name} à été mis à jours par ${data.dab.open_text}.`, `Mise à jour du Statut`)
            },
            error: () => {
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    }

    $(elements.inputStatusOutgoing).on('change', t => {
        let r = t.target.value;
        "all" === r && (r = "")
        datatableOutgoing.column(5).search(r).draw()
    })

    $(elements.inputSearchOutgoing).on('keyup', t => {
        datatableOutgoing.search(t.target.value).draw()
    })

    $(elements.inputStatusIncoming).on('change', t => {
        let r = t.target.value;
        "all" === r && (r = "")
        datatableIncoming.column(5).search(r).draw()
    })

    $(elements.inputSearchIncoming).on('keyup', t => {
        datatableIncoming.search(t.target.value).draw()
    })

    $(elements.inputStatusInvoice).on('change', t => {
        let r = t.target.value;
        "all" === r && (r = "")
        datatableInvoice.column(3).search(r).draw()
    })

    $(elements.inputSearchInvoice).on('keyup', t => {
        datatableInvoice.search(t.target.value).draw()
    })
</script>
