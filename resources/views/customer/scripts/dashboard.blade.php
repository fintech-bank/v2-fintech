<script type="text/javascript">
    let tables = {}
    let elements = {
        chart_gauge: document.querySelector('#chart_gauge'),
    }
    let modals = {
        modalConfigGauge: document.querySelector("#configGauge"),
    }
    let forms = {
        formConfigGauge: document.querySelector("#formUpdateGauge")
    }
    let dataTable = {}
    let block = {
        blockModalConfigGauge: new KTBlockUI(modals.modalConfigGauge.querySelector('.modal-body'))
    }

    let chartEnd = (data) => {
        let success = "#00b518"
        let warn = "#b53f00"
        let danger = "#b50000"
        let chart = new ApexCharts(elements.chart_gauge, {
            series: [data],
            chart: {
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    hollow: {
                        margin: 15,
                        size: '70%'
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            show: false,
                            offsetY: -2,
                            fontSize: '22px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            fill: {
                colors: [data > 0 && data <= 25 ? danger : (data >= 26 && data <= 33 ? warn : success)],
            },
            stroke: {
                lineCap: "round",
            },
            labels: ['Average Results'],
            tooltip: {
                enable: true
            }
        })
        chart.render()
    }

    $.ajax({
        url: '/api/customer/{{ $customer->id }}/gauge',
        success: data => {
            console.log(data)
            chartEnd(data.percent)
        }
    })

    $(forms.formConfigGauge).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formConfigGauge)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.blockModalConfigGauge.block()

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                toastr.success(`La gauge d'affichage du solde à été paramétré`, `Gauge`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })
</script>
