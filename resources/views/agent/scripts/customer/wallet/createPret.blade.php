<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#credit_stepper"),
        btnNextElement: document.querySelector('[data-kt-stepper-action="next"]'),
        validResultPrerequest: document.querySelector("#validResultPrerequest"),
        validResultPret: document.querySelector("#validResultPret"),
    }
    let modals = {}
    let forms = {
        formAddCredit: document.querySelector("#formAddCredit")
    }
    let dataTable = {}
    let block = {
        blockResultPrerequest: new KTBlockUI(elements.validResultPrerequest),
        blockResultPret: new KTBlockUI(elements.validResultPret),
    }

    let stepper = new KTStepper(elements.stepperElement)
    console.log(stepper.getClickedStepIndex())

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
                    let elDiv = elements.validResultPrerequest.querySelector('.card-body');
                    elDiv.innerHTML = ``
                    Array.from(data.data).forEach(alert => {
                        elDiv.innerHTML += `${alert}<br>`
                    })
                    $.ajax({
                        url: '/api/customer/{{ $customer->id }}/pret/verify',
                        method: 'POST',
                        data: {"verify": 'loan'},
                        success: data => {
                            console.log(data)
                        }
                    })
                }
            })
        }
    });
</script>
