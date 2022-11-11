<script type="text/javascript">
    let tables = {
        tableComing: document.querySelector("#table_coming"),
        tableTransaction: document.querySelector("#kt_transaction_table"),
    }
    let elements = {
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
        btnRemb: document.querySelectorAll('.btnRemb'),
        transactionDate: document.querySelector('#kt_transaction_flatpickr'),
        transactionType: document.querySelector('[data-kt-transaction-filter="types"]')
    }
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalRequestOverdraft: document.querySelector("#requestOverdraft")
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount"),
        formRequestOverdraft: document.querySelector("#formSubscribeOverdraft")
    }
    let dataTable = {
        datatableComing: $(tables.tableComing).DataTable({
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>"
        }),
        datatableTransaction: $(tables.tableTransaction).DataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>",
            info: !1,
            order: [],
            pageLength: 10,
        }),
    }
    let block = {
        blockTableComing: messageBlock(tables.tableComing.querySelector("tbody")),
        blockTableTransaction: messageBlock(tables.tableTransaction.querySelector("tbody")),
    }
    let plugins = {

        flatTransactionDate: $(elements.transactionDate).flatpickr({
            altInput: !0,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            mode: "range",
            onChange: (e, t, n) => {
                a(e,t,n)
            }
        }),

    }

    let e, t, n, r, o, a = (e, n, a) => {
        r = e[0] ? new Date(e[0]) : null, o = e[1] ? new Date(e[1]) : null, $.fn.dataTable.ext.search.push((function (e, t, n) {
            let a = r,
                c = o,
                l = new Date(moment($(t[0]).getAttribute('data-order'), "YYYY-MM-DD")),
                u = new Date(moment($(t[0]).getAttribute('data-order'), "YYYY-MM-DD"));
            return null === a && null === c || null === a && c >= u || a <= l && null === c || a <= l && c >= u
        })), dataTable.datatableTransaction.draw()
    }

    document.querySelector('.requestOverdraft').addEventListener('click', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
        block.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/request/overdraft',
            method: 'POST',
            success: data => {
                block.release()
                block.destroy()
                console.log(data)
                let divOverdraft = document.querySelector("#overdraft")

                if (data.access === false) {
                    let contentError = '';
                    data.errors.forEach(error => {
                        contentError += `<li><span class="bullet me-5"></span> ${error}</li>`
                    })
                    modals.modalRequestOverdraft.querySelector(".btn-bank").setAttribute('disabled', '')
                    divOverdraft.innerHTML = `
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa-solid fa-exclamation-triangle text-warning fs-4tx mb-2"></i>
                        <span class="fs-2tx fw-bolder text-warning mb-5">Découvert Impossible</span>
                        <ul class="list-unstyled fs-3">
                            ${contentError}
                        </ul>
                    </div>
                    `
                } else {
                    modals.modalRequestOverdraft.querySelector(".btn-bank").removeAttribute('disabled')
                    divOverdraft.innerHTML = `
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa-solid fa-check-circle text-success fs-4tx mb-2"></i>
                        <span class="fs-2tx fw-bolder success mb-5">Découvert Possible</span>
                        <div class="p-5 border rounded border-success mb-5">
                            <p>Votre demande de découvert bancaire à été pré-accepter pour un montant maximal de <strong>${data.value}</strong> au taux débiteur de ${data.taux}</p>
                        </div>
                        <input type="hidden" name="balance_max" value="${data.value}" />
                        <x-form.input
                                name="balance_decouvert"
                                type="text"
                                label="Montant Souhaité"
                                value="0" />
                    </div>
                    `
                }
            }
        })
    })
    if(elements.btnAcceptTransaction) {
        elements.btnAcceptTransaction.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableComing.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/'+btn.dataset.transaction,
                    method: 'POST',
                    data: {"action": "accept"},
                    success: () => {
                        block.blockTableComing.release()
                        block.blockTableComing.destroy()
                        toastr.success(`La transaction à bien été accepté`, `Transaction`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: err => {
                        block.blockTableComing.release()
                        block.blockTableComing.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if(elements.btnRejectTransaction) {
        elements.btnRejectTransaction.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableComing.block()
                Swal.fire({
                    title: 'Donner la raison de ce rejet',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (raison) => {
                        $.ajax({
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/'+btn.dataset.transaction,
                            method: 'POST',
                            data: {"action": "reject", "raison": raison},
                            success: () => {
                                block.blockTableComing.release()
                                block.blockTableComing.destroy()
                                toastr.success(`La transaction à bien été refusé`, `Transaction`)

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1200)
                            },
                            error: err => {
                                block.blockTableComing.release()
                                block.blockTableComing.destroy()
                                console.error(err)
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })
        })
    }
    if(elements.btnOppositPayment) {
        elements.btnOppositPayment.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableComing.block()
                Swal.fire({
                    title: 'Donner la raison de cette opposition',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (raison) => {
                        $.ajax({
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/'+btn.dataset.transaction,
                            method: 'POST',
                            data: {"action": "opposit", "raison": raison},
                            success: () => {
                                block.blockTableComing.release()
                                block.blockTableComing.destroy()
                                toastr.success(`La transaction à bien été opposé`, `Transaction`)

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1200)
                            },
                            error: err => {
                                block.blockTableComing.release()
                                block.blockTableComing.destroy()
                                console.error(err)
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })
        })
    }

    $(forms.formUpdateStateAccount).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalUpdateStateAccount.querySelector(".modal-body"))
        let form = $(forms.formUpdateStateAccount)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.block()

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                block.release()
                block.destroy()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`L'état du compte à été mise à jours`, `Changement de l'état du compte`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formRequestOverdraft).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
        let form = $(forms.formRequestOverdraft)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.block()

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: () => {
                block.release()
                block.destroy()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`La souscription au découvert bancaire à été enregistré`, `Souscription au découvert bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    document.querySelector('[data-kt-transaction-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableTransaction.search(e.target.value).draw()
    }))
    $(elements.transactionType).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableTransaction.column(1).search(n).draw()
    })

</script>
