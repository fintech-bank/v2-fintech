<script type="text/javascript">
    let tables = {}
    let elements = {
        chart_gauge: document.querySelector('#chart_gauge'),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

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
</script>
