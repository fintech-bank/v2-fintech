<script type="text/javascript">
    let tables = {
        tableMailbox: document.querySelector('#kt_inbox_listing')
    }
    let elements = {
        starAll: document.querySelector('[data-action="mailbox-star-all"]'),
        trashAll: document.querySelector('[data-action="mailbox-trash-all"]'),
        reply: document.querySelector('[data-action="mailbox-reply"]'),
        forward: document.querySelector('[data-action="mailbox-forward"]'),
        send: document.querySelector('[data-action="mailbox-send"]'),
    }
    let modals = {}
    let forms = {}

    let datatableMailbox = $(tables.tableMailbox).DataTable({
        info: !1,
        order: [],
        language: {
            "emptyTable": "<div class='d-flex flex-row flex-center align-items-center'><i class='fa-solid fa-warning text-grey-100 fs-2 me-3'></i> Aucun message</div>",
        }
    })

    datatableMailbox.on('draw', () => {
        document.querySelector(".dataTables_wrapper").querySelector('.row').classList.add("px-9", "pt-3", "pb-5")
    })

    document.querySelector('[data-kt-inbox-listing-filter="search"]').addEventListener("keyup", (function (t) {
        n.search(t.target.value).draw()
    }))

    let Mailbox = {
        toggleImportant: function toggleImportant(ids, cb) {

        },
        trash: function trash(ids, cb) {

        },
        send: function send(mailbox_id) {
            window.location.replace(BASE_URL + "/agence/account/mailbox/" + mailbox_id + '/send');
        },
        reply: function reply(mailbox_id) {
            window.location.replace(BASE_URL + "/agence/account/mailbox/" + mailbox_id + '/reply');
        },
        forward: function forward(mailbox_id) {
            window.location.replace(BASE_URL + "/agence/account/mailbox/" + mailbox_id + '/forward');
        },
    }

    $(elements.reply).on('click', e => {
        if($(".form-check-input:checked").length !== 1) {
            toastr.warning('Please select one message only to reply')
            return false;
        }

        Mailbox.reply($(".form-check-input:checked").parents('tr').attr('data-mailbox-id'))
    })

    $(elements.forward).on('click', e => {
        if($(".form-check-input:checked").length !== 1) {
            toastr.warning('Please select one message only to forward')
            return false;
        }

        Mailbox.forward($(".form-check-input:checked").parents('tr').attr('data-mailbox-id'))
    })

    $(elements.send).on('click', e => {
        if($(".form-check-input:checked").length !== 1) {
            toastr.warning('Please select one message only to send')
            return false;
        }

        Mailbox.send($(".form-check-input:checked").parents('tr').attr('data-mailbox-id'))
    })

</script>
