<script type="text/javascript">
    KTDrawer.createInstances()
    let tables = {}
    let elements = {
        app: document.querySelector('#app'),
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
        btnRemb: document.querySelectorAll('.btnRemb'),
        btnViewTransfer: document.querySelectorAll('.btnViewTransfer'),
        btnAcceptTransfer: document.querySelectorAll('.btnAcceptTransfer'),
        btnRefuseTransfer: document.querySelectorAll('.btnRefuseTransfer'),
    }
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalNewTransfer: document.querySelector('#newTransfer'),
        modalNewWithdraw: document.querySelector('#addRetrait'),
        modalNewDeposit: document.querySelector('#addDepot'),
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount"),
        formNewTransfer: document.querySelector('#formNewTransfer'),
        formNewWithdraw: document.querySelector('#formNewWithdraw'),
        formNewDeposit: document.querySelector('#formNewDeposit'),
    }
    let dataTable = {}
    let block = {
        blockApp: new KTBlockUI(elements.app, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
            overlayClass: "bg-gray-600 bg-opacity-25",
        }),
        blockNewTransfer: new KTBlockUI(modals.modalNewTransfer.querySelector('.modal-body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
            overlayClass: "bg-gray-600 bg-opacity-25",
        }),
        blockNewWithdraw: new KTBlockUI(modals.modalNewWithdraw.querySelector('.modal-body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
            overlayClass: "bg-gray-600 bg-opacity-25",
        }),
        blockNewDeposit: new KTBlockUI(modals.modalNewDeposit.querySelector('.modal-body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
            overlayClass: "bg-gray-600 bg-opacity-25",
        }),
    }
    let plugins = {}

    $(forms.formNewTransfer).find('#immediat').fadeIn()
    $(forms.formNewTransfer).find('#permanent').fadeOut()
    $("#courant").fadeIn()
    $("#orga").fadeOut()
    $("#assoc").fadeOut()
    $("#money_deposit").fadeOut()
    $("#check_deposit").fadeOut()

    let selectTypeTransfer = (item) => {
        console.log(item.value)
        if(item.value === 'immediat' || item.value === 'differed') {
            $(forms.formNewTransfer).find('#immediat').fadeIn()
            $(forms.formNewTransfer).find('#permanent').fadeOut()
        } else {
            $(forms.formNewTransfer).find('#immediat').fadeOut()
            $(forms.formNewTransfer).find('#permanent').fadeIn()
        }
    }
    let selectDestTransfer = (item) => {
        switch (item.value) {
            case 'courant':
                $("#courant").fadeIn()
                $("#orga").fadeOut()
                $("#assoc").fadeOut()
                break;

            case 'orga':
                $("#courant").fadeOut()
                $("#orga").fadeIn()
                $("#assoc").fadeOut()
                break;

            case 'assoc':
                $("#courant").fadeOut()
                $("#orga").fadeOut()
                $("#assoc").fadeIn()
                break;
        }
    }

    forms.formNewDeposit.querySelectorAll('[name="type_deposit"]').forEach(input => {
        input.addEventListener('click', e => {
            console.log(e.target.value)
            if(e.target.value === 'money') {
                $("#money_deposit").fadeIn()
                $("#check_deposit").fadeOut()
            } else {
                $("#money_deposit").fadeOut()
                $("#check_deposit").fadeIn()
            }

        })
    })

    if (elements.btnAcceptTransaction) {
        elements.btnAcceptTransaction.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockApp.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
                    method: 'POST',
                    data: {"action": "accept"},
                    success: () => {
                        block.blockApp.release()
                        block.blockApp.destroy()
                        toastr.success(`La transaction à bien été accepté`, `Transaction`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: err => {
                        block.blockApp.release()
                        block.blockApp.destroy()
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
                block.blockApp.block()
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
                                block.blockApp.release()
                                block.blockApp.destroy()
                                toastr.success(`La transaction à bien été refusé`, `Transaction`)

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1200)
                            },
                            error: err => {
                                block.blockApp.release()
                                block.blockApp.destroy()
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
                block.blockApp.block()
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
                                block.blockApp.release()
                                block.blockApp.destroy()
                                toastr.success(`La transaction à bien été opposé`, `Transaction`)

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1200)
                            },
                            error: err => {
                                block.blockApp.release()
                                block.blockApp.destroy()
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
                block.blockApp.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/' + btn.dataset.transaction,
                    method: 'POST',
                    data: {"action": "remb"},
                    success: () => {
                        block.blockApp.release()
                        block.blockApp.destroy()
                        toastr.success(`La transaction à bien été remboursé`, `Transaction`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: err => {
                        block.blockApp.release()
                        block.blockApp.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if (elements.btnAcceptTransfer) {
        elements.btnAcceptTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockApp.block()

                $.ajax({
                    url: '/api/epargne/{{ $wallet->epargne->reference }}/transfer/'+e.target.dataset.transfer,
                    method: 'PUT',
                    data: {"action": "accept"},
                    success: data => {
                        block.blockApp.release()
                        block.blockApp.destroy()
                        if(data.state === 'warning') {
                            toastr.warning(`${data.message}`, `Virement Bancaire`)
                        } else {
                            toastr.success(`Le virement à bien été accepté`, `Virement Bancaire`)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    },
                    error: err => {
                        block.blockApp.release()
                        block.blockApp.destroy()
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
    $(forms.formNewTransfer).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formNewTransfer)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.blockNewTransfer.block()

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                block.blockNewTransfer.release()
                block.blockNewTransfer.destroy()
                btn.removeAttr('data-kt-indicator')

                if(data.state === 'warning') {
                    toastr.warning(`${data.message()}`, `Création d'un virement`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                } else {
                    toastr.success(`Le virement à été créer avec succès`, `Création d'un virement`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                }
            }
        })
    })
    $(forms.formNewWithdraw).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formNewWithdraw)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.blockNewTransfer.block()

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                block.blockNewTransfer.release()
                block.blockNewTransfer.destroy()
                btn.removeAttr('data-kt-indicator')

                if(data.state === 'warning') {
                    toastr.warning(`${data.message()}`, `Création d'un retrait`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                } else {
                    toastr.success(`Le virement à été créer avec succès`, `Création d'un retrait`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                }
            }
        })
    })
    $(forms.formNewDeposit).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formNewDeposit)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.blockNewDeposit.block()

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                block.blockNewDeposit.release()
                block.blockNewDeposit.destroy()
                btn.removeAttr('data-kt-indicator')
                console.log(data)

                /*if(data.state === 'warning') {
                    toastr.warning(`${data.message()}`, `Création d'un dépot`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                } else {
                    toastr.success(`Le dépot à été créer avec succès`, `Création d'un dépot`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                }*/
            }
        })
    })

    KTDrawer.createInstances()
</script>
