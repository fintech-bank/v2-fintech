<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalUpdateStateAccount: document.querySelector("#updateStateAccount"),
        modalRequestOverdraft: document.querySelector("#requestOverdraft")
    }
    let forms = {
        formUpdateStateAccount: document.querySelector("#formUpdateStateAccount")
    }
    let dataTable = {}
    let block = {}

    document.querySelector('.requestOverdraft').addEventListener('click', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
        block.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/request/overdraft',
            method: 'POST',
            success: data => {
                block.release()
                block.destroy()
                console.log(data)
                let divOverdraft = document.querySelector("#overdraft")

                if (data.access === false) {
                    let contentError = '';
                    data.errors.forEach(error => {
                        contentError += `<li><span class="bullet me-5"></span> ${error}</li>`
                    })
                    modals.modalRequestOverdraft.querySelector(".btn-bank").setAttribute('disabled', '')
                    divOverdraft.innerHTML = `
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa-solid fa-exclamation-triangle text-warning fs-4tx mb-2"></i>
                        <span class="fs-2tx fw-bolder text-warning mb-5">Découvert Impossible</span>
                        <ul class="list-unstyled fs-3">
                            ${contentError}
                        </ul>
                    </div>
                    `
                } else {
                    modals.modalRequestOverdraft.querySelector(".btn-bank").removeAttribute('disabled')
                    divOverdraft.innerHTML = `
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa-solid fa-check-circle text-success fs-4tx mb-2"></i>
                        <span class="fs-2tx fw-bolder success mb-5">Découvert Possible</span>
                        <div class="p-5 border rounded border-success mb-5">
                            <p>Votre demande de découvert bancaire à été pré-accepter pour un montant maximal de <strong>${data.value}</strong> au taux débiteur de ${data.taux}</p>
                        </div>
                        <input type="hidden" name="balance_max" value="${data.value}" />
                        <x-form.input
                                name="balance_decouvert"
                                type="text"
                                label="Montant Souhaité"
                                value="0" />
                    </div>
                    `
                }
            }
        })
    })

    $(forms.formUpdateStateAccount).on('submit', e => {
        e.preventDefault()
        let block = new KTBlockUI(modals.modalUpdateStateAccount.querySelector(".modal-body"))
        let form = $(forms.formUpdateStateAccount)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')
        block.block()

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                block.release()
                block.destroy()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`L'état du compte à été mise à jours`, `Changement de l'état du compte`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            }
        })
    })

</script>
