<script type="text/javascript">
    let tables = {}
    let elements = {
        field_datebirth: document.querySelector('[name="datebirth"]'),
        field_package_id: document.querySelector('[name="package_id"]'),
        blockDivPackage: document.querySelector('#blockDivPackage'),
        divPackage: document.querySelector('#package_info')
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {
        blockDivPackage: messageBlock(elements.blockDivPackage)
    }

    let countryBirthOptions = (item) => {
        if ( !item.id ) {
            return item.text;
        }
        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';
        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;
        span.innerHTML = template;
        return $(span);
    }

    let countryOptions = (item) => {
        if ( !item.id ) {
            return item.text;
        }
        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';
        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;
        span.innerHTML = template;
        return $(span);
    }

    let citiesFromCountry = (select) => {
        console.log(select.value)
        let contentCities = document.querySelector('#divCities')
        $.ajax({
            url: '/api/core/geo/cities',
            method: 'post',
            data: {"country": select.value},
            success: data => {
                console.log(data)
                contentCities.innerHTML = data
                $("#citybirth").select2()
                $(contentCities).fadeIn()
            }
        })
    }
    let citiesFromPostal = (select) => {
        let contentCities = document.querySelector('#divCity')
        let block = new KTBlockUI(contentCities, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
        block.block();
        $.ajax({
            url: '/api/core/geo/cities/'+select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }
    let getInfoPackage = (packageId) => {
        block.blockDivPackage.block()
        elements.divPackage.classList.remove('d-none')

        let iconTemplate =  {
            'Cristal': {'icon': 'gem', 'color': 'secondary'},
            'Gold': {'icon': 'gem', 'color': 'warning'},
            'Platine': {'icon': 'gem', 'color': 'black'},
            'Pro Metal': {'icon': 'ring', 'color': 'secondary'},
            'Pro Gold': {'icon': 'ring', 'color': 'warning'},
        }

        let deleteIconColor = () => {
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-secondary')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-warning')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('text-black')
        }

        let deleteIcon = () => {
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('fa-gem')
            elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.remove('fa-ring')
        }
        $.ajax({
            url: '/api/core/forfait/'+packageId.value,
            success: data => {
                console.log(data)
                block.blockDivPackage.release()
                block.blockDivPackage.destroy()

                deleteIconColor()
                elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.add('text-'+iconTemplate[data.name].color)

                deleteIcon()
                elements.divPackage.querySelector('[data-content="icon"]').querySelector('i').classList.add('fa-'+iconTemplate[data.name].icon)

                elements.divPackage.querySelector('[data-content="package_name"]').innerHTML = `Forfait ${data.name}`
                elements.divPackage.querySelector('[data-content="package_price"]').innerHTML = `${new Intl.NumberFormat('fr', {style: 'currency', currency: 'eur'}).format(data.price)}`
                elements.divPackage.querySelector('[data-content="package_type_prlv"]').innerHTML = `${data.type_prlv_text}`
            }
        })

    }

    document.querySelectorAll('[name="postal"]').forEach(input => {
        input.addEventListener('keyup', e => {
            console.log(e.target.value.length)
            if(e.target.value.length === 5) {
                citiesFromPostal(e.target)
            }
        })
    })

    if(elements.field_datebirth) { $(elements.field_datebirth).flatpickr({"locale": "fr"}) }

    $("#countrybirth").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })

    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })
</script>
