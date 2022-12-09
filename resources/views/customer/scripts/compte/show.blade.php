<script type="text/javascript">
    let tables = {}
    let elements = {
        chart_expense: document.querySelector('#chart_expense'),
    }
    let modals = {
        modalRequestOverdraft: document.querySelector("#RequestOverdraft")
    }
    let forms = {
        formRequestOverdraft: document.querySelector("#formRequestOverdraft")
    }
    let dataTable = {}
    let block = {
        blockRequestOverdraft: new KTBlockUI(modals.modalRequestOverdraft.querySelector(".modal-body"))
    }

    $(modals.modalRequestOverdraft).on('shown.bs.modal', e => {
        block.blockRequestOverdraft.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/request/overdraft',
            method: 'POST',
            success: data => {
                console.log(data)
                if(data.access === true) {
                    return `<div class="alert bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
								<!--begin::Icon-->
                                <span class="iconify fs-5tx text-danger mb-5" data-icon="material-symbols:playlist-add-check-circle-outline"></span>
								<!--end::Icon-->
								<!--begin::Content-->
								<div class="text-center text-dark">
									<h1 class="fw-bold mb-5">Découvert bancaire autorisé</h1>
									<div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
									<div class="mb-9">
									    Un découvert bancaire est effectivement possible suivant les conditions suivantes:
									    <ul>
									        <li><strong>Montant Maximal: ${data.value}</strong></li>
									        <li><strong>TAEG: ${data.taux}</strong></li>
									    </ul>
									    <p>Voulez-vous effectuer une demande de découvert bancaire ?</p>
									</div>
									<!--begin::Buttons-->
									<div class="d-flex flex-center flex-wrap">
										<a href="#" data-bs-dismiss="modal" class="btn btn-outline btn-outline-danger btn-active-danger m-2">Annuler ma demande</a>
										<a href="#" class="btn btn-danger m-2">Oui, souscrire</a>
									</div>
									<!--end::Buttons-->
								</div>
								<!--end::Content-->
								</div>`
                } else {

                }
            }
        })
    })
</script>
