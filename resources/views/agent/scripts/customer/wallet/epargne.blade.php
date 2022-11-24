<script type="text/javascript">
    KTDrawer.createInstances()
    let tables = {}
    let elements = {
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
        btnRemb: document.querySelectorAll('.btnRemb'),
        searchSuggestion: document.querySelector('[data-kt-search-element="suggestions"]'),
        searchResult: document.querySelector('[data-kt-search-element="results"]'),
        searchEmpty: document.querySelector('[data-kt-search-element="empty"]'),
        searchElement: document.querySelector('#kt_docs_search_handler_basic'),
    }
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount"),
    }
    let dataTable = {}
    let block = {}
    let plugins = {}


    let processSearch = (search) => {
        console.log(search)
        elements.searchSuggestion.classList.add('d-none')

    }
    let clear = (search) => {
        elements.searchSuggestion.classList.remove('d-none')
        elements.searchResult.classList.add('d-none')
        elements.searchEmpty.classList.add('d-none')
    }
    let handleSearchInput = () => {
        const inputSearch = element.querySelector('[data-kt-search-element="input"]')
        inputSearch.addEventListener('keydown', e => {
            if (e.key === "Enter") {
                e.preventDefault()
            }
        })
    }

    let searchWrapper = elements.searchElement.querySelector('[data-kt-search-element="wrapper"]')
    let searchObject = new KTSearch(elements.searchElement)
    searchObject.on('kt.search.process', processSearch)
    searchObject.on('kt.search.clear', clear)
    handleSearchInput()


    if (elements.btnAcceptTransaction) {
        elements.btnAcceptTransaction.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableComing.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
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
    if (elements.btnRejectTransaction) {
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
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
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
    if (elements.btnOppositPayment) {
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
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
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
    if (elements.btnRemb) {
        elements.btnRemb.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableTransaction.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
                    method: 'POST',
                    data: {"action": "remb"},
                    success: () => {
                        block.blockTableTransaction.release()
                        block.blockTableTransaction.destroy()
                        toastr.success(`La transaction à bien été remboursé`, `Transaction`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: err => {
                        block.blockTableTransaction.release()
                        block.blockTableTransaction.destroy()
                        console.error(err)
                    }
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

    KTDrawer.createInstances()
</script>
