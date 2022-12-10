<script type="text/javascript">
    let tables = {}
    let elements = {
        repeaterChqRepeat: document.querySelector("#chq_repeat")
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    $(elements.repeaterChqRepeat).repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    })
</script>
