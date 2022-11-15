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
        btnOppositCard: document.querySelectorAll(".btnOppositCard"),
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
        $(elements.divEditCard).fadeIn();
        $(elements.divSendCodeCard).fadeOut();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeOut();
        $(elements.divOppositCard).fadeOut();
    })

    elements.btnSendCodeCard.addEventListener('click', () => {
        $(elements.divEditCard).fadeOut();
        $(elements.divSendCodeCard).fadeIn();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeOut();
        $(elements.divOppositCard).fadeOut();
    })

    if(elements.btnFaceliaCard) {
        elements.btnFaceliaCard.addEventListener('click', () => {
            $(elements.divEditCard).fadeOut();
            $(elements.divSendCodeCard).fadeOut();
            $(elements.divFaceliaCard).fadeIn();
            $(elements.divCancelCard).fadeOut();
            $(elements.divOppositCard).fadeOut();
        })
    }

    elements.btnCancelCard.addEventListener('click', () => {
        $(elements.divEditCard).fadeOut();
        $(elements.divSendCodeCard).fadeOut();
        $(elements.divFaceliaCard).fadeOut();
        $(elements.divCancelCard).fadeIn();
        $(elements.divOppositCard).fadeOut();
    })

    elements.btnOppositCard.forEach(btn => {
        btn.addEventListener('click', () => {
            $(elements.divEditCard).fadeOut();
            $(elements.divSendCodeCard).fadeOut();
            $(elements.divFaceliaCard).fadeOut();
            $(elements.divCancelCard).fadeOut();
            $(elements.divOppositCard).fadeIn();
        })
    })

</script>
