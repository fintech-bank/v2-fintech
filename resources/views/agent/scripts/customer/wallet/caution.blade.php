<script type="text/javascript">
    let tables = {}
    let elements = {
        selectType: document.querySelector('#type'),
        selectCountry: document.querySelector('.selectCountry'),
        selectDep: document.querySelector('.selectDep'),
        selectCity: document.querySelector('.selectCity'),
        inputCni: document.querySelector('[name="cni_number"]'),
        inputSiret: document.querySelector('[name="siret"]'),
        inputCompany: document.querySelector('[name="company"]'),
        cardCaution: document.querySelector("#cardCaution"),
        divPhysique: document.querySelector("#physique"),
        divMoral: document.querySelector("#moral"),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {
        blockCaution: new KTBlockUI(elements.cardCaution)
    }

    elements.divPhysique.classList.add('d-none')
    elements.divMoral.classList.add('d-none')

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
    if(elements.inputCompany) {
        elements.inputCompany.addEventListener('change', e => {
            block.blockCaution.block();

            $.ajax({
                url: '/api/connect/siret',
                method: 'POST',
                data: {"company": e.target.value},
                success: data => {
                    block.blockCaution.release()
                    block.blockCaution.destroy()
                    if(data.header.statut === 404) {
                        let p = document.createElement('p')
                        elements.inputCompany.classList.remove('is-valid')
                        elements.inputCompany.classList.add('is-invalid')
                        elements.inputCompany.parentNode.append(p)
                        p.classList.remove('text-success')
                        p.classList.add('text-danger')
                        p.innerHTML = data.header.message
                    } else {
                        let p = document.createElement('p')
                        elements.inputCompany.classList.remove('is-invalid')
                        elements.inputCompany.classList.add('is-valid')
                        elements.inputCompany.parentNode.append(p)
                        p.classList.remove('text-danger')
                        p.classList.add('text-success')
                        p.innerHTML = data.header.message
                    }
                }
            })
        })
    }
    if(elements.selectType) {
        elements.selectType.addEventListener('change', e => {
            selectType(e.target)
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
    let selectType = (item) => {
        let value = item.value

        if(value === 'physique') {
            elements.divPhysique.classList.remove('d-none')
            elements.divMoral.classList.add('d-none')
        } else {
            elements.divPhysique.classList.add('d-none')
            elements.divMoral.classList.remove('d-none')
        }
    }

</script>
