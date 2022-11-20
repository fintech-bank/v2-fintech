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

    if(elements.selectCountry) {
        elements.selectCountry.addEventListener('change', e => {
            stateBirthByCountry(e.target)
            cityBirthByCountry(e.target)
        })
    }

    let stateBirthByCountry = (item) => {
        let country = item.value
        console.log(country)

        $.ajax({
            url: '/api/core/geo/states',
            method: 'POST',
            data: {
                'country': country,
            },
            success: data => {
                elements.selectDep.querySelector('select').innerHTML = '<option></option>'
                Array.from(data).forEach(option => {
                    elements.selectDep.querySelector('select').innerHTML += `<option value="${option.name}">${option.name}</option>`
                })
                $(elements.selectDep.querySelector('select')).select2()
            }
        })
    }
    let cityBirthByCountry = (item) => {
        let country = item.value
        console.log(country)

        $.ajax({
            url: '/api/core/geo/cities',
            method: 'POST',
            data: {
                'country': country,
            },
            success: data => {
                elements.selectCity.querySelector('select').innerHTML = '<option></option>'
                Array.from(data).forEach(option => {
                    elements.selectCity.querySelector('select').innerHTML += `<option value="${option}">${option}</option>`
                })
                $(elements.selectCity.querySelector('select')).select2()
            }
        })
    }
</script>
