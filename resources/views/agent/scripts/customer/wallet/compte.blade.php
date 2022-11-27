<script type="text/javascript">
    KTDrawer.createInstances()
    let tables = {
        tableComing: document.querySelector("#table_coming"),
        tableTransaction: document.querySelector("#kt_transaction_table"),
        tableTransfer: document.querySelector("#liste_transfers"),
        tableBeneficiaire: document.querySelector("#liste_beneficiaires"),
        tableSepa: document.querySelector("#liste_sepas"),
        tableCard: document.querySelector("#liste_card"),
    }
    let elements = {
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
        btnRemb: document.querySelectorAll('.btnRemb'),
        btnShowTransfer: document.querySelectorAll('.btnShowTransfer'),
        btnAcceptTransfer: document.querySelectorAll('.btnAcceptTransfer'),
        btnDeclineTransfer: document.querySelectorAll('.btnDeclineTransfer'),
        btnShowSepa: document.querySelectorAll('.btnViewSepa'),
        btnAcceptSepa: document.querySelectorAll('.btnAcceptSepa'),
        btnRejectSepa: document.querySelectorAll('.btnRejectSepa'),
        btnRembSepa: document.querySelectorAll('.btnRembSepa'),
        transactionDate: document.querySelector('#kt_transaction_flatpickr'),
        transactionType: document.querySelector('[data-kt-transaction-filter="types"]'),
        chartSummary: document.querySelector('#chart_summary'),
        tabInfo: document.querySelector('[href="#infos"]'),
        transferType: document.querySelector('[data-kt-transfer-filter="type"]'),
        transferStatus: document.querySelector('[data-kt-transfer-filter="status"]'),
        beneficiaireType: document.querySelector('[data-kt-beneficiaire-filter="type"]'),
        creditorField: document.querySelector('[data-kt-sepa-filter="creditor"]'),
        sepaStatus: document.querySelector('[data-kt-sepa-filter="status"]'),
        showTransfer: document.querySelector('#show_transfer'),
        showSepa: document.querySelector('#show_sepa'),
        retailField: document.querySelector("#add_beneficiaire").querySelector('#retailField'),
        corporateField: document.querySelector("#add_beneficiaire").querySelector('#corporateField'),
        cardStatus: document.querySelector('[data-kt-card-filter="status"]'),
        cardType: document.querySelector('[data-kt-card-filter="type"]'),
        inputTypeVirement: document.querySelector('[name="type_virement"]'),
        inputInterne: document.querySelector('#interne'),
        inputExterne: document.querySelector('#externe'),
    }
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalRequestOverdraft: document.querySelector("#requestOverdraft"),
        modalAddVirement: document.querySelector("#add_virement"),
        modalCreateCard: document.querySelector("#add_credit_card"),
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount"),
        formRequestOverdraft: document.querySelector("#formSubscribeOverdraft"),
        formAddVirement: document.querySelector("#formAddVirement"),
        formAddBeneficiaire: document.querySelector('#formAddBeneficiaire'),
        formAddCreditCard: document.querySelector('#formAddCreditCard'),
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
        datatableTransfer: $(tables.tableTransfer).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableBeneficiaire: $(tables.tableBeneficiaire).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableSepa: $(tables.tableSepa).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableCard: $(tables.tableCard).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
    }
    let block = {
        blockTableComing: messageBlock(tables.tableComing.querySelector("tbody")),
        blockTableTransaction: messageBlock(tables.tableTransaction.querySelector("tbody")),
        blockTableTransfer: messageBlock(tables.tableTransfer.querySelector("tbody")),
        blockTableBeneficiaire: messageBlock(tables.tableBeneficiaire.querySelector("tbody")),
        blockTableSepa: messageBlock(tables.tableSepa.querySelector("tbody")),
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
        drawerShowTransfer: KTDrawer.getInstance(elements.showTransfer),
        drawerShowSepa: KTDrawer.getInstance(elements.showSepa),
    }

    $(elements.inputInterne).fadeOut()
    $(elements.inputExterne).fadeOut()

    let initChartSummary = () => {
        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/chartSummary',
            success: data => {
                let chartSummary = new ApexCharts(elements.chartSummary, {
                    series: [{
                        name: 'Crédit',
                        data: data.credit[0]
                    },{
                        name: 'Débit',
                        data: data.debit[0]
                    },{
                        name: 'Découvert',
                        data: data.decouvert[0]
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: parseInt(KTUtil.css(elements.chartSummary, 'height')),
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        categories: ['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            position: 'front',
                            stroke: {
                                color: KTUtil.getCssVariableValue('--bs-gray-500'),
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return new Intl.NumberFormat('fr-Fr', {style: 'currency', currency: 'eur'}).format(val)
                            }
                        }
                    },
                    colors: [KTUtil.getCssVariableValue('--bs-success'), KTUtil.getCssVariableValue('--bs-warning'), KTUtil.getCssVariableValue('--bs-danger')],
                    grid: {
                        borderColor: KTUtil.getCssVariableValue('--bs-gray-200'),
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    markers: {
                        colors: [KTUtil.getCssVariableValue('--bs-light-success'), KTUtil.getCssVariableValue('--bs-light-warning'), KTUtil.getCssVariableValue('--bs-light-danger')],
                        strokeColor: [KTUtil.getCssVariableValue('--bs-light-success'), KTUtil.getCssVariableValue('--bs-light-warning'), KTUtil.getCssVariableValue('--bs-light-danger')],
                        strokeWidth: 3
                    }
                })
                chartSummary.render()
            }
        })
    }
    let selectedTypeVirement = (type) => {
        if(type.value === 'differed') {
            document.querySelector('#immediat').classList.add('d-none')
            document.querySelector('#differed').classList.remove('d-none')
            document.querySelector('#permanent').classList.add('d-none')
        } else if(type.value === 'permanent') {
            document.querySelector('#immediat').classList.add('d-none')
            document.querySelector('#differed').classList.add('d-none')
            document.querySelector('#permanent').classList.remove('d-none')
        } else {
            document.querySelector('#immediat').classList.remove('d-none')
            document.querySelector('#differed').classList.add('d-none')
            document.querySelector('#permanent').classList.add('d-none')
        }
    }
    let selectTypeBeneficiaire = () => {
        document.querySelector('#add_beneficiaire').querySelectorAll('[name="type"]').forEach(input => {
            elements.corporateField.classList.add('d-none')
            elements.retailField.classList.add('d-none')
            input.addEventListener('click', e => {
                console.log(e.target.value)

                if(e.target.value === 'retail') {
                    elements.corporateField.classList.add('d-none')
                    elements.retailField.classList.remove('d-none')
                } else {
                    elements.corporateField.classList.remove('d-none')
                    elements.retailField.classList.add('d-none')
                }
            })
        })
    }
    let selectTypeVirement = (item) => {
        if(item.value == 'interne') {
            $(elements.inputInterne).fadeIn()
            $(elements.inputExterne).fadeOut()
        } else {
            $(elements.inputInterne).fadeOut()
            $(elements.inputExterne).fadeIn()
        }
    }
    let optionFormatBank = (item) => {
        if ( !item.id ) {
            return item.text;
        }

        var span = document.createElement('span');
        var imgUrl = item.element.getAttribute('data-bank-logo');
        var template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }
    let cardsOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-card-img');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }
    let checkBankInfo = (item) => {
        $.ajax({
            url: '/api/connect/bank/'+item.value,
            success: data => {
                document.querySelector('[name="bic"]').value = data.bic
                document.querySelector('[name="bankname"]').value = data.name
            }
        })
    }
    let getPhysicalInfo = (item) => {
        if (item.value === 'physique') {
            modals.modalCreateCard.querySelector('#physical_card').classList.remove('d-none')
        } else {
            modals.modalCreateCard.querySelector('#physical_card').classList.add('d-none')
        }
    }
    selectTypeBeneficiaire()


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
    if(elements.btnRemb) {
        elements.btnRemb.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableTransaction.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transaction/'+btn.dataset.transaction,
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
    if(elements.btnShowTransfer) {
        elements.btnShowTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableTransfer.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transfers/'+btn.dataset.transfer,
                    success: data => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()
                        plugins.drawerShowTransfer.show()

                        elements.showTransfer.querySelector('[data-content="transfer_status"]').innerHTML = data.status_bullet
                        elements.showTransfer.querySelector('[data-content="emet_transfer"]').innerHTML = data.wallet.iban_format
                        elements.showTransfer.querySelector('[data-content="receip_transfer"]').innerHTML = data.beneficiaire.iban_format
                        elements.showTransfer.querySelector('[data-content="transfer_type"]').innerHTML = data.type_text
                        elements.showTransfer.querySelector('[data-content="transfer_date"]').innerHTML = data.date_format
                        elements.showTransfer.querySelector('[data-content="transfer_reference"]').innerHTML = data.reference
                        if(data.status === 'pending') {
                            elements.showTransfer.querySelector('.btnAcceptTransfer').setAttribute('data-transfer', data.uuid)
                            elements.showTransfer.querySelector('.btnDeclineTransfer').setAttribute('data-transfer', data.uuid)
                            elements.showTransfer.querySelector('.btnAcceptTransfer').classList.remove('d-none')
                            elements.showTransfer.querySelector('.btnDeclineTransfer').classList.remove('d-none')
                        } else {
                            elements.showTransfer.querySelector('.btnAcceptTransfer').classList.add('d-none')
                            elements.showTransfer.querySelector('.btnDeclineTransfer').classList.add('d-none')
                        }
                    },
                    error: err => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if(elements.btnAcceptTransfer) {
        elements.btnAcceptTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableTransfer.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transfers/'+btn.dataset.transfer,
                    method: 'PUT',
                    data: {"status": "accept"},
                    success: () => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()

                        toastr.success(`Le virement à bien été accepté`, `Virement Bancaire`)

                        setTimeout(() => {
                            window.location.reload()
                        })
                    },
                    error: err => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if(elements.btnDeclineTransfer) {
        elements.btnDeclineTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableTransfer.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transfers/'+btn.dataset.transfer,
                    method: 'PUT',
                    data: {"status": "decline"},
                    success: () => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()

                        toastr.success(`Le virement à bien été refusé`, `Virement Bancaire`)

                        setTimeout(() => {
                            window.location.reload()
                        })
                    },
                    error: err => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if(elements.btnShowSepa) {
        elements.btnShowSepa.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableSepa.block()

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/sepa/'+btn.dataset.sepa,
                    success: data => {
                        block.blockTableSepa.release()
                        block.blockTableSepa.destroy()
                        plugins.drawerShowSepa.show()

                        elements.showSepa.querySelector('[data-content="transfer_status"]').innerHTML = data.sepa.status_comment
                        elements.showSepa.querySelector('[data-content="code_banque"]').innerHTML = data.agency.code_banque
                        elements.showSepa.querySelector('[data-content="code_guichet"]').innerHTML = data.agency.code_agence
                        elements.showSepa.querySelector('[data-content="number_account"]').innerHTML = data.sepa.wallet.number_account
                        elements.showSepa.querySelector('[data-content="iban"]').innerHTML = data.sepa.wallet.iban
                        elements.showSepa.querySelector('[data-content="bic"]').innerHTML = data.agency.bic

                        elements.showSepa.querySelector('[data-content="creditor_name"]').innerHTML = data.sepa.creditors.name
                        elements.showSepa.querySelector('[data-content="creditor_id"]').innerHTML = data.sepa.creditors.identifiant

                        elements.showSepa.querySelector('[data-content="mandate_reference"]').innerHTML = data.sepa.number_mandate

                        elements.showSepa.querySelector('[data-content="mandat_amount"]').innerHTML = data.sepa.amount_format
                        elements.showSepa.querySelector('[data-content="status"]').innerHTML = `${data.sepa.status_text} le ${data.sepa.updated_at_format}`
                        elements.showSepa.querySelector('[data-content="mandat_motif"]').innerHTML = `${data.sepa.creditors.identifiant}/${data.sepa.wallet.number_account}/${data.sepa.number_mandate}`

                        if(data.sepa.status === 'waiting') {
                            elements.showSepa.querySelector('[data-content="btnAction"]').innerHTML = `
                            <button class="btn btn-success btnAcceptSepa me-3" data-sepa="${data.sepa.uuid}"><i class="fa-solid fa-check me-2"></i> Accepter le prélèvement</button>
                            <button class="btn btn-danger btnRejectSepa" data-sepa="${data.sepa.uuid}"><i class="fa-solid fa-xmark me-2"></i> Rejeter le prélèvement</button>
                            `
                        } else if(data.sepa.status === 'processed') {
                            elements.showSepa.querySelector('[data-content="btnAction"]').innerHTML = `
                            <button class="btn btn-info btnRembSepa" data-sepa="${data.sepa.uuid}"><i class="fa-solid fa-rotate-left me-2"></i> Demander le remboursement</button>
                            `
                        } else {
                            elements.showSepa.querySelector('[data-content="btnAction"]').innerHTML = ''
                        }


                    },
                    error: err => {
                        block.blockTableTransfer.release()
                        block.blockTableTransfer.destroy()
                        console.error(err)
                    }
                })
            })
        })
    }
    if(elements.btnAcceptSepa) {
        elements.btnAcceptSepa.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableSepa.block()

                Swal.fire({
                    title: "Voulez-vous accepter ce prélèvement ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#004486',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then(result => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/sepa/'+btn.dataset.sepa,
                            method: 'PUT',
                            data: {"action": "accept"},
                            statusCode: {
                                200: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.success(`Le prélèvement à été accepté, il va bientôt interrogé le serveur de passage`, `Prélèvement Bancaire`)

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1200)
                                },
                                522: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.warning(`L'établissement distant à refuser le passage en force du prélèvement.`, `Prélèvement bancaire`)
                                },
                                500: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                                }
                            }
                        })
                    }
                })
            })
        })
    }
    if(elements.btnRejectSepa) {
        elements.btnRejectSepa.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableSepa.block()

                Swal.fire({
                    title: "Voulez-vous rejeté ce prélèvement ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#004486',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then(result => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/sepa/'+btn.dataset.sepa,
                            method: 'PUT',
                            data: {"action": "reject"},
                            success: () => {
                                block.blockTableSepa.release()
                                block.blockTableSepa.destroy()

                                toastr.success(`Le prélèvement à été rejeté`, `Prélèvement Bancaire`)

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1200)
                            }
                        })
                    }
                })
            })
        })
    }
    if(elements.btnRembSepa) {
        elements.btnRembSepa.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockTableSepa.block()

                Swal.fire({
                    title: "Voulez-vous demander le remboursement de ce prélèvement ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#004486',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then(result => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/sepa/'+btn.dataset.sepa,
                            method: 'PUT',
                            data: {"action": "refunded"},
                            statusCode: {
                                200: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.success(`La demande de remboursement à bien été soumis à l'établissement distant.`, `Prélèvement Bancaire`)

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1200)
                                },
                                522: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.warning(`La demande de remboursement à été refusé par l'établissement distant`, `Prélèvement Bancaire`)
                                },
                                500: () => {
                                    block.blockTableSepa.release()
                                    block.blockTableSepa.destroy()
                                    toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                                }
                            }
                        })
                    }
                })
            })
        })
    }
    let inputAmount = modals.modalAddVirement.querySelector('[name="amount"]');
    inputAmount.addEventListener('blur', e => {
        if(inputAmount.value >= 1000) {
            document.querySelector('#immediat').querySelector('[value="express"]').setAttribute('disabled', '')
        } else {
            document.querySelector('#immediat').querySelector('[value="express"]').removeAttribute('disabled')
        }
    })

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
    $(forms.formAddVirement).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalAddVirement.querySelector(".modal-body"))
        let form = $(forms.formAddVirement)
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

                toastr.success(`Le virement à bien été enregistré`, `Virement Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formAddBeneficiaire).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalAddVirement.querySelector(".modal-body"))
        let form = $(forms.formAddBeneficiaire)
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

                toastr.success(`Le bénéficiaire à bien été enregistré`, `Virement Bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    $(forms.formAddCreditCard).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalCreateCard.querySelector(".modal-body"))
        let form = $(forms.formAddCreditCard)
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

                toastr.success(`La demande de nouvelle carte bancaire à été enregistré`, `Carte bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
    document.querySelector('[data-kt-transaction-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableTransaction.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-transfers-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableTransfer.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-beneficiaire-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableBeneficiaire.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-sepa-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableSepa.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-card-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableCard.search(e.target.value).draw()
    }))
    $(elements.transactionType).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableTransaction.column(1).search(n).draw()
    })
    $(elements.transferType).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableTransfer.column(2).search(n).draw()
    })
    $(elements.transferStatus).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableTransfer.column(3).search(n).draw()
    })
    $(elements.beneficiaireType).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableBeneficiaire.column(0).search(n).draw()
    })
    $(elements.creditorField).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableSepa.column(2).search(n).draw()
    })
    $(elements.sepaStatus).on('change', e => {
        let n = e.target.value;
        console.log(n)
        "all" === n && (n = ""), dataTable.datatableSepa.column(5).search(n).draw()
    })
    $(elements.cardStatus).on('change', e => {
        let n = e.target.value;
        "all" === n && (n = ""), dataTable.datatableCard.column(4).search(n).draw()
    })
    $(elements.cardType).on('change', e => {
        let n = e.target.value;
        "all" === n && (n = ""), dataTable.datatableCard.column(5).search(n).draw()
    })
    $("#bank_id").select2({
        templateSelection: optionFormatBank,
        templateResult: optionFormatBank
    })
    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })
    $(forms.formAddCreditCard).find('#support').select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    if(elements.tabInfo) {
        elements.tabInfo.addEventListener('shown.bs.tab', e => {
            initChartSummary()
        })
    }

    KTDrawer.createInstances()
</script>
