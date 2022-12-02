<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalEditMail: document.querySelector('#EditMail')
    }
    let forms = {
        formEditMail: document.querySelector("#formEditMail")
    }
    let dataTable = {}
    let block = {
        blockEditMail: new KTBlockUI(modals.modalEditMail.querySelector('.modal-body'))
    }

    $(forms.formEditMail).on('submit', e => {

        e.preventDefault()
        let form = $(forms.formEditMail)
        let url = form.attr('action')
        let method = 'PUT'
        let data = form.serializeArray()
        let btn = form.find('[type="submit"]')
        let modal = new bootstrap.Modal(modals.modalEditMail)
        modal.hide()

        @if(Agent::isMobile())
        let agent = '{{ Agent::device().'-'.Agent::platform().'-'.Agent::version(Agent::platform()).'-'.gethostname() }}'
        executeVerifiedAjax('secure', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, agent)
        @else
        executeVerifiedAjax('password', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn})
        @endif

    })
</script>
