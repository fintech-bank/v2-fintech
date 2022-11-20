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

    let countryBirthOptions = (item) => {
        if (!item.id) {
            return item.text;
        }
        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-flag');
        let template = '';
        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;
        span.innerHTML = template;
        return $(span);
    }

    let stateBirthByCountry = (item) => {
        let country = item.value
        console.log(country)
    }

    $("#country_naissance").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })
</script>
