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

    let subscribeOverdraft = (item) => {
        $.ajax({
            url: url,
            method: 'POST',
            data: {""},
            success: data => {
                btn.removeAttr('data-kt-indicator')
                if(data.state === 'warning') {
                    toastr.warning(`${data.message}`)
                } else {
                    toastr.success(`${data.message}`)

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
    }

    $(modals.modalRequestOverdraft).on('shown.bs.modal', e => {
        block.blockRequestOverdraft.block()

        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/request/overdraft',
            method: 'POST',
            success: data => {
                block.blockRequestOverdraft.release()
                block.blockRequestOverdraft.destroy()
                console.log(data)
                if(data.access === true) {
                    modals.modalRequestOverdraft.querySelector(".modal-body").innerHTML = `<div class="alert bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
								<!--begin::Icon-->
                                <span class="iconify fs-5tx text-success mb-5" data-icon="material-symbols:playlist-add-check-circle-outline"></span>
								<!--end::Icon-->
								<!--begin::Content-->
								<div class="text-center text-dark">
									<h1 class="fw-bold mb-5">Découvert bancaire autorisé</h1>
									<div class="separator separator-dashed border-success opacity-25 mb-5"></div>
									<div class="mb-9">
									    Un découvert bancaire est effectivement possible suivant les conditions suivantes:
									    <ul>
									        <li><strong>Montant Maximal: ${data.value}</strong></li>
									        <li><strong>TAEG: ${data.taux}</strong></li>
									    </ul>
									    <p>Voulez-vous effectuer une demande de découvert bancaire ?</p>
                                        <input type="text" name="balance_decouvert" value="${data.value}" class="form-control form-control-solid">
									</div>
									<!--begin::Buttons-->
									<div class="d-flex flex-center flex-wrap">
										<a href="#" data-bs-dismiss="modal" class="btn btn-outline btn-outline-success btn-active-success m-2">Annuler ma demande</a>
										<a href="#" class="btn btn-success m-2 subscribeOverdraft" onclick="subscribeOverdraft(this)">Oui, souscrire</a>
									</div>
									<!--end::Buttons-->
								</div>
								<!--end::Content-->
								</div>`
                } else {
                    modals.modalRequestOverdraft.querySelector(".modal-body").innerHTML = `<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
								<!--begin::Icon-->
								<!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
								<span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"></path>
										<path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"></path>
									</svg>
								</span>
								<!--end::Svg Icon-->
                                <span class="iconify fs-2tx text-danger mb-5" data-icon="fa6-regular:circle-xmark"></span>
								<!--end::Icon-->
								<!--begin::Content-->
								<div class="d-flex flex-column text-light pe-0 pe-sm-10">
									<h4 class="mb-2 text-light">Découvert non autorisé</h4>
									<span>Certaines informations ne permettent pas de souscrire à un découvert bancaire:</span>
                                    <i>${data.errors}</i>
								</div>
								<!--end::Content-->
							</div>`
                }
            }
        })
    })
</script>
