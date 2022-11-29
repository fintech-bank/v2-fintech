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
        let chart = new ApexCharts(elements.chartEndet, {
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
                    track: {
                        background: "#3f3f3f",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 0,
                            color: '#999',
                            opacity: 1,
                            blur: 2
                        }
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
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
                colors: [data > 0 && data <= 25 ? success : (data >= 26 && data <= 33 ? warn : danger)],
            },
            labels: ['Average Results'],
        })
        chart.render()
    }

    $.ajax({
        url: '/api/customer/{{ $customer->id }}/gauge',
        success: data => {
            console.log(data)
            chartEnd(data.percent)
            document.querySelector("[data-content='taux_end']").innerHTML = data.percent + ' %';
            document.querySelector("[data-content='reste_vivre']").innerHTML = new Intl.NumberFormat('fr', {style: 'currency', currency: 'eur'}).format(data.reste);
        }
    })
</script>
