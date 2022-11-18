<script type="text/javascript">
    let tables = {}
    let elements = {
        btnAcceptPret: document.querySelector(".btnAcceptPret"),
        btnRejectPret: document.querySelector(".btnRejectPret"),
        btnStudyPret: document.querySelector(".btnStudyPret"),
        btnProgressPret: document.querySelector(".btnProgressPret"),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    if (elements.btnProgressPret) {
        elements.btnProgressPret.addEventListener('click', e => {
            Swal.fire({
                title: "Voulez-vous valider définitivement le crédit N°{{ $facelia->pret->reference }} ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "OUI",
                cancelButtonText: "NON",
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/api/customer/{{ $facelia->card->wallet->customer->id }}/wallet/{{ $facelia->card->wallet->number_account }}/pret/{{ $facelia->pret->reference }}',
                        method: 'PUT',
                        data: {'action': 'state', 'state': 'progress'},
                        success: () => {
                            toastr.success(`Le status du pret à été mise à jours`, `Crédit FACELIA`)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    })
                }
            })
        })
    }
    if (elements.btnAcceptPret) {
        elements.btnAcceptPret.addEventListener('click', e => {
            Swal.fire({
                title: "Voulez-vous accepté le crédit N° {{ $facelia->pret->reference }} ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "OUI",
                cancelButtonText: "NON",
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/api/customer/{{ $facelia->card->wallet->customer->id }}/wallet/{{ $facelia->card->wallet->number_account }}/pret/{{ $facelia->pret->reference }}',
                        method: 'PUT',
                        data: {'action': 'state', 'state': 'accepted'},
                        success: () => {
                            toastr.success(`Le status du pret à été mise à jours`, `Crédit FACELIA`)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    })
                }
            })
        })
    }
    if (elements.btnRejectPret) {
        elements.btnRejectPret.addEventListener('click', e => {
            Swal.fire({
                title: "Voulez-vous refusé le crédit N° {{ $facelia->pret->reference }} ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "OUI",
                cancelButtonText: "NON",
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/api/customer/{{ $facelia->card->wallet->customer->id }}/wallet/{{ $facelia->card->wallet->number_account }}/pret/{{ $facelia->pret->reference }}',
                        method: 'PUT',
                        data: {'action': 'state', 'state': 'refused'},
                        success: () => {
                            toastr.success(`Le status du pret à été mise à jours`, `Crédit FACELIA`)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    })
                }
            })
        })
    }
    if (elements.btnStudyPret) {
        elements.btnStudyPret.addEventListener('click', e => {
            Swal.fire({
                title: "Voulez-vous étudié le crédit N° {{ $facelia->pret->reference }} ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "OUI",
                cancelButtonText: "NON",
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/api/customer/{{ $facelia->card->wallet->customer->id }}/wallet/{{ $facelia->card->wallet->number_account }}/pret/{{ $facelia->pret->reference }}',
                        method: 'PUT',
                        data: {'action': 'state', 'state': 'study'},
                        success: () => {
                            toastr.success(`Le status du pret à été mise à jours`, `Crédit FACELIA`)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    })
                }
            })
        })
    }
</script>
