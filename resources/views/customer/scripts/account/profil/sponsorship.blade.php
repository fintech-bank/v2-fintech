<script type="text/javascript">
    let tables = {}
    let elements = {
        inputPostal: document.querySelector('[name="postal"]'),
        villeSelect: document.querySelector('#villeSelect')
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    let selectCity = (item) => {
        $.ajax({
            url: '/api/core/geo/cities/'+item.value,
            success: data => {
                elements.villeSelect.innerHTML = data
            }
        })
    }

    elements.inputPostal.addEventListener('keyup', e => {
        if(e.target.value.length === 5) {
            selectCity(e.target)
        }
    })
</script>
