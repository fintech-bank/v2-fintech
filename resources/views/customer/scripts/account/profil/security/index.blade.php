<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElementMobile: document.querySelector('#stepper_edit_mobile')
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    let stepperMobile = new KTStepper(elements.stepperElementMobile);
    stepperMobile.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });
    stepperMobile.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go next step
    });
    stepperMobile.on("kt.stepper.changed", function() {
        console.log(stepperMobile.getCurrentStepIndex())
    });
</script>
