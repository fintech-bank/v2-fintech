<script type="text/javascript">
    let tables = {}
    let elements = {
        field_datebirth: document.querySelector('[name="datebirth"]'),
        field_package_id: document.querySelector('[name="package_id"]'),
        blockDivPackage: document.querySelector('#blockDivPackage'),
        divPackage: document.querySelector('#package_info')
    }
    let modals = {
        modalVerifyCustomer: document.querySelector("#modalVerifCustomer")
    }
    let forms = {
        formPartPro: document.querySelector('#formPartPro')
    }
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
    let cardsOptions = (item) => {
        if ( !item.id ) {
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

        let deleteIconC = (name) => {
            elements.divPackage.querySelector('[data-content="'+name+'"]').querySelector('i').classList.remove('fa-check-circle')
            elements.divPackage.querySelector('[data-content="'+name+'"]').querySelector('i').classList.remove('fa-check-circle')
            elements.divPackage.querySelector('[data-content="'+name+'"]').querySelector('i').classList.remove('text-success')
            elements.divPackage.querySelector('[data-content="'+name+'"]').querySelector('i').classList.remove('text-danger')
        }

        let checkIfValid =  {
            0: {'icon': 'xmark-circle', 'color': 'danger'},
            1: {'icon': 'check-circle', 'color': 'success'},
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

                deleteIconC('visa_classic')
                elements.divPackage.querySelector('[data-content="visa_classic"]').querySelector('i').classList.add('fa-'+checkIfValid[data.visa_classic].icon)
                elements.divPackage.querySelector('[data-content="visa_classic"]').querySelector('i').classList.add('text-'+checkIfValid[data.visa_classic].color)

                deleteIconC('check_deposit')
                elements.divPackage.querySelector('[data-content="check_deposit"]').querySelector('i').classList.add('fa-'+checkIfValid[data.check_deposit].icon)
                elements.divPackage.querySelector('[data-content="check_deposit"]').querySelector('i').classList.add('text-'+checkIfValid[data.check_deposit].color)

                deleteIconC('payment_withdraw')
                elements.divPackage.querySelector('[data-content="payment_withdraw"]').querySelector('i').classList.add('fa-'+checkIfValid[data.payment_withdraw].icon)
                elements.divPackage.querySelector('[data-content="payment_withdraw"]').querySelector('i').classList.add('text-'+checkIfValid[data.payment_withdraw].color)

                deleteIconC('overdraft')
                elements.divPackage.querySelector('[data-content="overdraft"]').querySelector('i').classList.add('fa-'+checkIfValid[data.overdraft].icon)
                elements.divPackage.querySelector('[data-content="overdraft"]').querySelector('i').classList.add('text-'+checkIfValid[data.overdraft].color)

                deleteIconC('cash_deposit')
                elements.divPackage.querySelector('[data-content="cash_deposit"]').querySelector('i').classList.add('fa-'+checkIfValid[data.cash_deposit].icon)
                elements.divPackage.querySelector('[data-content="cash_deposit"]').querySelector('i').classList.add('text-'+checkIfValid[data.cash_deposit].color)

                deleteIconC('withdraw_international')
                elements.divPackage.querySelector('[data-content="withdraw_international"]').querySelector('i').classList.add('fa-'+checkIfValid[data.withdraw_international].icon)
                elements.divPackage.querySelector('[data-content="withdraw_international"]').querySelector('i').classList.add('text-'+checkIfValid[data.withdraw_international].color)

                deleteIconC('payment_international')
                elements.divPackage.querySelector('[data-content="payment_international"]').querySelector('i').classList.add('fa-'+checkIfValid[data.payment_international].icon)
                elements.divPackage.querySelector('[data-content="payment_international"]').querySelector('i').classList.add('text-'+checkIfValid[data.payment_international].color)

                deleteIconC('payment_insurance')
                elements.divPackage.querySelector('[data-content="payment_insurance"]').querySelector('i').classList.add('fa-'+checkIfValid[data.payment_insurance].icon)
                elements.divPackage.querySelector('[data-content="payment_insurance"]').querySelector('i').classList.add('text-'+checkIfValid[data.payment_insurance].color)

                deleteIconC('check')
                elements.divPackage.querySelector('[data-content="check"]').querySelector('i').classList.add('fa-'+checkIfValid[data.check].icon)
                elements.divPackage.querySelector('[data-content="check"]').querySelector('i').classList.add('text-'+checkIfValid[data.check].color)

                elements.divPackage.querySelector('[data-content="nb_carte_physique"]').innerHTML = data.nb_carte_physique
                elements.divPackage.querySelector('[data-content="nb_carte_virtuel"]').innerHTML = data.nb_carte_virtuel
                elements.divPackage.querySelector('[data-content="subaccount"]').innerHTML = data.subaccount


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
    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })
    $(forms.formPartPro).on('submit', e => {
        e.preventDefault()
        let modal = new bootstrap.Modal(modals.modalVerifyCustomer)
        modal.show()

        let fccTemplate = {
            'true': {'text': "Inscrit dans le fichier", 'color': 'danger'},
            'false': {'text': 'Non Inscrit dans le fichier', 'color': 'success'}
        }

        let ficpTemplate = {
            'true': {'text': "Inscrit dans le fichier", 'color': 'danger'},
            'false': {'text': 'Non Inscrit dans le fichier', 'color': 'success'}
        }

        $.ajax({
            url: '/api/connect/customer_verify',
            success: data => {
                console.log(data)
                modals.modalVerifyCustomer.querySelector(".icon").querySelector('.spinner').classList.add('d-none')
                modals.modalVerifyCustomer.querySelector(".icon").innerHTML = '<i class="fa-solid fa-warning text-warning fs-3hx"></i>'
                modals.modalVerifyCustomer.querySelector('.fw-bolder').classList.add('d-none')
                modals.modalVerifyCustomer.querySelector('#errors').innerHTML = `
                <div class="d-flex flex-row justify-content-around">
                    <strong>Fichier Central des chèques: <span class="text-${fccTemplate[data.fcc].color}">${fccTemplate[data.fcc].text}</span></strong>
                    <strong>Fichier Incident Crédit Particulier: <span class="text-${ficpTemplate[data.ficp].color}">${ficpTemplate[data.ficp].text}</span></strong>
                </div>
                `

                modal.addEventListener('hidden.bs.modal', e => {
                    $(forms.formPartPro).submit()
                })
            }
        })
    })
</script>
