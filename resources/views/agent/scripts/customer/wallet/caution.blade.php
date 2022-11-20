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

    elements.selectDep.querySelector('select').setAttribute('disabled', '')
    elements.selectCity.querySelector('select').setAttribute('disabled', '')


    let stateBirthByCountry = (item) => {
        let country = item.value
        console.log(country)

        $.ajax({
            url: '/api/core/geo/states',
            method: 'POST',
            data: {
                'country': country,
                'name': 'dep_naissance',
                'label': 'Département de naissance',
                'placeholder': 'Selectionner un département de naissance'
            },
            success: data => {
                elements.selectDep.innerHTML = data
            }
        })
    }
</script>
