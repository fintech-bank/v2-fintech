<script type="text/javascript">
    let tables = {}
    let elements = {
        stepperElement: document.querySelector("#credit_stepper")
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    let stepper = new KTStepper(elements.stepperElement)

    stepper.on("kt.stepper.next", function (stepper) {
        stepper.goNext();
    });

    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious();
    });
</script>
