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

            $(this).find('[data-kt-repeater="select2"]').select2();
            $(this).find('[data-kt-repeater="datepicker"]').flatpickr();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },

        ready: (element) => {
            $(this).find('[data-kt-repeater="datepicker"]').flatpickr();
        }
    })
</script>
