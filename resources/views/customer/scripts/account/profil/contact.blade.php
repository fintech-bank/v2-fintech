<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalEditMail: document.querySelector('#EditMail'),
        modalEditPhone: document.querySelector('#EditPhone'),
        modalEditAddress: document.querySelector('#EditAddress'),
    }
    let forms = {
        formEditMail: document.querySelector("#formEditMail"),
        formEditPhone: document.querySelector("#formEditPhone"),
        formEditAddress: document.querySelector("#formEditAddress"),
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
        executeVerifiedAjax('secure', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e, agent)
        @else
        executeVerifiedAjax('password', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e)
        @endif

    })
    $(forms.formEditPhone).on('submit', e => {

        e.preventDefault()
        let form = $(forms.formEditPhone)
        let url = form.attr('action')
        let method = 'PUT'
        let data = form.serializeArray()
        let btn = form.find('[type="submit"]')
        let modal = new bootstrap.Modal(modals.modalEditPhone)
        modal.hide()

        @if(Agent::isMobile())
        let agent = '{{ Agent::device().'-'.Agent::platform().'-'.Agent::version(Agent::platform()).'-'.gethostname() }}'
        executeVerifiedAjax('secure', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e, agent)
        @else
        executeVerifiedAjax('password', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e)
        @endif

    })
    $(forms.formEditAddress).on('submit', e => {

        e.preventDefault()
        let form = $(forms.formEditAddress)
        let url = form.attr('action')
        let method = 'PUT'
        let data = form.serializeArray()
        let btn = form.find('[type="submit"]')
        let modal = new bootstrap.Modal(modals.modalEditAddress)
        modal.hide()

        @if(Agent::isMobile())
        let agent = '{{ Agent::device().'-'.Agent::platform().'-'.Agent::version(Agent::platform()).'-'.gethostname() }}'
        executeVerifiedAjax('secure', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e, agent)
        @else
        executeVerifiedAjax('password', {{ $customer->id }}, {'form': form, 'url': url, 'method': method, 'data': data, 'btn': btn}, e)
        @endif

    })
</script>
