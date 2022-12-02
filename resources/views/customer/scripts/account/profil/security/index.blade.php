<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElementMobile: document.querySelector('#stepper_edit_mobile')
    }
    let modals = {
        modalEditMobile: document.querySelector("#editMobile")
    }
    let forms = {}
    let dataTable = {}
    let block = {
        blockEditMobile: new KTBlockUI(modals.modalEditMobile.querySelector('.modal-body'))
    }

    let stepperMobile = new KTStepper(elements.stepperElementMobile);
    stepperMobile.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });
    stepperMobile.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go next step
    });
    stepperMobile.on("kt.stepper.changed", function() {
        if(stepperMobile.getCurrentStepIndex() === 2) {
            block.blockEditMobile.block()
            $.ajax({
                url: '/api/user/verify/phone/code',
                method: 'POST',
                data: {
                    "mobile": document.querySelector("[name='mobile']").value,
                    "verify": "phoneCode",
                    "customer_id": {{ $customer->id }}
                },
                success: () => {
                    block.blockEditMobile.release()
                    block.blockEditMobile.destroy()
                    document.querySelector(".helpEditMobileCode").innerHTML = `Un code vous a été envoyé au numéro <strong>${document.querySelector("[name='mobile']").value}</strong>`
                }
            })
        }
    });
</script>
