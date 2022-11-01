<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {
        blockApp: new KTBlockUI(document.querySelector("#app"), {
            message: `<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement en cours...</div>`,
            overlayClass: "bg-gray-600",
        })
    }

    block.blockApp.block()
</script>
