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
            $.ajax({
                url: '{{ route('agent.account.mailbox.toggleImportant') }}',
                method: "PUT",
                data: {mailbox_flag_ids: ids, method: "PUT"},
                dataType: "json",
                success: function (response) {
                    cb(response);
                }
            })
        },
        trash: function trash(ids, cb) {
            $.ajax({
                url: '{{ route('agent.account.mailbox.trash') }}',
                method: "DELETE",
                data: {mailbox_flag_ids: ids, method: "PUT"},
                dataType: "json",
                success: function (response) {
                    cb(response);
                }
            })
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

    function checkboxCheck()
    {
        if($(".check-message:checked").length == 0) {
            alert("Please select at least one row to process!");
            return false;
        }
        return true;
    }

    function handleImportant(data)
    {
        Mailbox.toggleImportant(data, function (response) {
            if(response.state === 0) {
                toastr.warning(response.msg)
            } else {
                response.updated.map(function(value) {
                    if(value.is_important === 1) {
                        //Switch states
                        $("tr[data-mailbox-flag-id='"+value.id+"'] td.mailbox-star").find("a > i").removeClass("fa-star-o").addClass("fa-star");
                    } else {
                        //Switch states
                        $("tr[data-mailbox-flag-id='"+value.id+"'] td.mailbox-star").find("a > i").removeClass("fa-star").addClass("fa-star-o");
                    }
                });
                toastr.success(response.msg)
            }
        });
    }
    function handleTrash(data)
    {
        Mailbox.trash(data, function (response) {
            if(response.state === 0) {
                alert(response.msg);
            } else {
                alert(response.msg);
                setInterval(function () {
                    location.reload();
                }, 3000);
            }
        });
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

    $(".mailbox-star").click(function (e) {
        e.preventDefault();
        handleImportant([$(this).parents("tr").attr("data-mailbox-flag-id")]);
    });

    $('[data-action="mailbox-star-all"]').on("click", function (e) {
        if(!checkboxCheck()) {
            return;
        }
        let checked = [];
        $(".check-message:checked").each(function (val) {
            checked.push($(this).parents("tr").attr("data-mailbox-flag-id"));
        });
        handleImportant(checked);
    });
    $('[data-action="mailbox-trash-all"]').on("click", function (e) {
        if(!checkboxCheck()) {
            return;
        }
        let checked = [];
        $(".check-message:checked").each(function (val) {
            checked.push($(this).parents("tr").attr("data-user-folder-id"));
        });
        handleTrash(checked);
    });

</script>
