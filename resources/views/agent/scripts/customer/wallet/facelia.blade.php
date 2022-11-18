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
                title: "Voulez-vous passer ce crédit en étude ?",
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

                        }
                    })
                }
            })
        })
    }
</script>
