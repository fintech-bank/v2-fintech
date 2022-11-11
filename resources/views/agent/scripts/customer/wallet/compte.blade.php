<script type="text/javascript">
    let tables = {
        tableComing: document.querySelector("#table_coming")
    }
    let elements = {
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
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
        })
    }
    let block = {
        blockTableComing: messageBlock(tables.tableComing.querySelector("tbody"))
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

</script>
