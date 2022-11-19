<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#credit_stepper"),
        btnNextElement: document.querySelector('[data-kt-stepper-action="next"]'),
        validResultPrerequest: document.querySelector("#validResultPrerequest"),
        validResultPret: document.querySelector("#validResultPret"),
        result: document.querySelector("#result"),
    }
    let modals = {}
    let forms = {
        formAddCredit: document.querySelector("#formAddCredit")
    }
    let dataTable = {}
    let block = {
        blockResultPrerequest: new KTBlockUI(elements.validResultPrerequest),
        blockResultPret: new KTBlockUI(elements.validResultPret),
        blockResult: new KTBlockUI(elements.result),
    }

    let stepper = new KTStepper(elements.stepperElement)

    stepper.on("kt.stepper.click", function (stepper) {
        stepper.goTo(stepper.getClickedStepIndex());
    });

    stepper.on("kt.stepper.next", function (stepper) {
        stepper.goNext();
    });

    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious();
    });

    stepper.on("kt.stepper.changed", function (stepper) {
        if (stepper.getCurrentStepIndex() === 2) {
            block.blockResultPrerequest.block()
            block.blockResultPret.block()
            elements.btnNextElement.setAttribute('disabled', '')

            $.ajax({
                url: '/api/customer/{{ $customer->id }}/pret/verify',
                method: 'POST',
                data: {"verify": 'prerequest'},
                success: data => {
                    block.blockResultPrerequest.release()
                    block.blockResultPrerequest.destroy()
                    let elDiv = elements.validResultPrerequest.querySelector('.card-body').querySelector('ul');
                    elDiv.innerHTML = ``
                    if(Array.from(data.data).length !== 0) {
                        Array.from(data.data).forEach(alert => {
                            elDiv.innerHTML += `<li class="text-danger">${alert}</li>`
                        })
                    } else {
                        elDiv.parentNode.innerHTML = ``
                        elDiv.innerHTML = `
                                <div class="d-flex flex-center w-100 mx-auto">
                                    <i class="fa-solid fa-check-circle text-success fs-3tx me-2"></i>
                                    <div class="fw-bolder fs-1">Condition Personnel atteinte</div>
                                </div>
                                `
                    }

                    $.ajax({
                        url: '/api/customer/{{ $customer->id }}/pret/verify',
                        method: 'POST',
                        data: {"verify": 'loan'},
                        success: data => {
                            block.blockResultPret.release()
                            block.blockResultPret.destroy()
                            let elDiv = elements.validResultPret.querySelector('.card-body');
                            console.log(data.data[0])
                            if(data.data[0] === false) {
                                elDiv.innerHTML = `
                                <div class="d-flex flex-center w-100 mx-auto">
                                    <i class="fa-solid fa-xmark-circle text-danger fs-3tx me-2"></i>
                                    <div class="fw-bolder fs-1">Condition financière non atteinte</div>
                                </div>
                                `
                            } else {
                                elDiv.innerHTML = `
                                <div class="d-flex flex-center w-100 mx-auto">
                                    <i class="fa-solid fa-check-circle text-success fs-3tx me-2"></i>
                                    <div class="fw-bolder fs-1">Condition financière atteinte</div>
                                </div>
                                `
                                elements.btnNextElement.removeAttribute('disabled')
                            }
                        }
                    })
                }
            })
        }
        if(stepper.getCurrentStepIndex() === 3) {
            block.blockResult.block()
            let form = $(forms.formAddCredit)
            let data = form.serializeArray()
            $.ajax({
                url: '/api/customer/{{ $customer->id }}/pret/verify',
                method: 'POST',
                data: data,
                success: data => {
                    console.log(data)
                }
            })
        }
    });
</script>
