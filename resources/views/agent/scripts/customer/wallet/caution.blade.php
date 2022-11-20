<script type="text/javascript">
    let tables = {}
    let elements = {
        selectCountry: document.querySelector('.selectCountry'),
        selectDep: document.querySelector('.selectDep'),
        selectCity: document.querySelector('.selectCity'),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}


    let stateBirthByCountry = (item) => {
        let country = item.value
        console.log(country)

        $.ajax({
            url: '/api/core/geo/states',
            method: 'POST',
            data: {'country': country},
            success: data => {
                console.log(data)
            }
        })
    }
</script>
