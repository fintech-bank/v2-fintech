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

    $(elements.stepperElementMobile).on('submit', e => {
        e.preventDefault()
        let form = $(elements.stepperElementMobile)
        let url = form.attr('action')
        let data =  form.serializeArray()
        let btn = form.find('.btn-success')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                let modal = new bootstrap.Modal(modals.modalEditMobile)
                btn.removeAttr('data-kt-indicator')

                if(data.state === 'warning') {
                    console.log(data.data)
                    toastr.success(`${data.message}`, `Sécurité`)
                    modal.hide()
                } else {
                    toastr.success(`Votre numéro de téléphone de sécurité à bien été mise à jour`, `Sécurité`)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                }
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
