<script type="text/javascript">
    let tables = {
        tableComing: document.querySelector("#table_coming"),
        tableTransaction: document.querySelector("#kt_transaction_table"),
        tableTransfer: document.querySelector("#liste_transfers"),
        tableBeneficiaire: document.querySelector("#liste_beneficiaires"),
    }
    let elements = {
        btnAcceptTransaction: document.querySelectorAll('.btnAcceptTransaction'),
        btnRejectTransaction: document.querySelectorAll('.btnRejectTransaction'),
        btnOppositPayment: document.querySelectorAll('.btnOppositPayment'),
        btnRemb: document.querySelectorAll('.btnRemb'),
        transactionDate: document.querySelector('#kt_transaction_flatpickr'),
        transactionType: document.querySelector('[data-kt-transaction-filter="types"]'),
        chartSummary: document.querySelector('#chart_summary'),
        tabInfo: document.querySelector('[href="#infos"]'),
        transferType: document.querySelector('[data-kt-transfer-filter="type"]'),
        transferStatus: document.querySelector('[data-kt-transfer-filter="status"]'),
        beneficiaireType: document.querySelector('[data-kt-beneficiaire-filter="type"]'),
    }
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalRequestOverdraft: document.querySelector("#requestOverdraft"),
        modalAddVirement: document.querySelector("#add_virement"),
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount"),
        formRequestOverdraft: document.querySelector("#formSubscribeOverdraft"),
        formAddVirement: document.querySelector("#formAddVirement"),
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
    }
    let block = {
        blockTableComing: messageBlock(tables.tableComing.querySelector("tbody")),
        blockTableTransaction: messageBlock(tables.tableTransaction.querySelector("tbody")),
        blockTableTransfer: messageBlock(tables.tableTransfer.querySelector("tbody")),
        blockTableBeneficiaire: messageBlock(tables.tableBeneficiaire.querySelector("tbody")),
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
        if(type.value === 'differed')
            document.querySelector('#immediat').classList.add('d-none'){
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
    document.querySelector('[data-kt-transaction-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableTransaction.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-transfers-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableTransfer.search(e.target.value).draw()
    }))
    document.querySelector('[data-kt-beneficiaire-filter="search"]').addEventListener("keyup", (function (e) {
        dataTable.datatableBeneficiaire.search(e.target.value).draw()
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

    if(elements.tabInfo) {
        elements.tabInfo.addEventListener('shown.bs.tab', e => {
            initChartSummary()
        })
    }
</script>
