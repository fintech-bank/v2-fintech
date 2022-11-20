<script type="text/javascript">
    let tables = {}
    let elements = {
        selectCountry: document.querySelector('.selectCountry'),
        selectDep: document.querySelector('.selectDep'),
        selectCity: document.querySelector('.selectCity'),
        inputCni: document.querySelector('[name="cni_number"]'),
        inputSiret: document.querySelector('[name="siret"]'),
        inputCompany: document.querySelector('[name="company"]'),
        cardCaution: document.querySelector("#cardCaution")
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {
        blockCaution: new KTBlockUI(elements.cardCaution)
    }

    if(elements.selectCountry) {
        elements.selectCountry.addEventListener('change', e => {
            stateBirthByCountry(e.target)
        })
    }
    if(elements.inputCni) {
        elements.inputCni.addEventListener('keyup', e => {
            e.preventDefault()
            if(e.target.value.length === 12 || e.target.value.length === 9 ) {
                elements.inputCni.classList.remove('is-invalid')
                elements.inputCni.classList.add('is-valid')
            } else {
                elements.inputCni.classList.remove('is-valid')
                elements.inputCni.classList.add('is-invalid')
            }
        })
    }
    if(elements.inputSiret) {
        elements.inputSiret.addEventListener('change', e => {
            block.blockCaution.block();

            $.ajax({
                url: '/api/connect/siret',
                method: 'POST',
                data: {"siret": e.target.value},
                success: data => {
                    block.blockCaution.release()
                    block.blockCaution.destroy()
                    if(data.header.statut === 404) {
                        let p = document.createElement('p')
                        elements.inputSiret.classList.remove('is-valid')
                        elements.inputSiret.classList.add('is-invalid')
                        elements.inputSiret.parentNode.append(p)
                        p.classList.remove('text-success')
                        p.classList.add('text-danger')
                        p.innerHTML = data.header.message
                    } else {
                        let p = document.createElement('p')
                        elements.inputSiret.classList.remove('is-invalid')
                        elements.inputSiret.classList.add('is-valid')
                        elements.inputSiret.parentNode.append(p)
                        p.classList.remove('text-danger')
                        p.classList.add('text-success')
                        p.innerHTML = data.header.message
                    }
                }
            })
        })
    }

    elements.selectDep.addEventListener('change', e => {
        cityBirthByCountry(e.target)
    })

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
    let cityBirthByCountry = () => {
        let country = elements.selectCountry.querySelector('select').value
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
