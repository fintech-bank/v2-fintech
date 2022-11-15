<script type="text/javascript">
    let tables = {}
    let elements = {
        divEditCard: document.querySelector("#divEditCard"),
        divSendCodeCard: document.querySelector("#divSendCodeCard"),
        divFaceliaCard: document.querySelector("#divFaceliaCard"),
        divCancelCard: document.querySelector("#divCancelCard"),
        divOppositCard: document.querySelector("#divOppositCard"),
        btnEditCard: document.querySelector(".btnEditCard"),
        btnSendCodeCard: document.querySelector(".btnSendCodeCard"),
        btnFaceliaCard: document.querySelector(".btnFaceliaCard"),
        btnCancelCard: document.querySelector(".btnCancelCard"),
        btnOppositCard: document.querySelector(".btnOppositCard"),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    $(elements.divEditCard).hide();
    $(elements.divSendCodeCard).hide();
    $(elements.divFaceliaCard).hide();
    $(elements.divCancelCard).hide();
    $(elements.divOppositCard).hide();

    elements.btnEditCard.addEventListener('click', () => {
        $(elements.divEditCard).show();
        $(elements.divSendCodeCard).hide();
        $(elements.divFaceliaCard).hide();
        $(elements.divCancelCard).hide();
        $(elements.divOppositCard).hide();
    })

    elements.btnSendCodeCard.addEventListener('click', () => {
        $(elements.divEditCard).hide();
        $(elements.divSendCodeCard).show();
        $(elements.divFaceliaCard).hide();
        $(elements.divCancelCard).hide();
        $(elements.divOppositCard).hide();
    })

</script>
