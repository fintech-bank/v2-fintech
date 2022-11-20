<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    let countryBirthOptions = (item) => {
        if (!item.id) {
            return item.text;
        }
        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-flag');
        let template = '';
        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;
        span.innerHTML = template;
        return $(span);
    }

    $("#country_naissance").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })
</script>
