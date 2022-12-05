<script type="text/javascript">
    let tables = {}
    let elements = {
        btnDesactivePaystar: document.querySelector(".btnDesactivePaystar"),
        btnActivePaystar: document.querySelector(".btnActivePaystar"),
    }
    let modals = {}
    let forms = {}
    let dataTable = {}
    let block = {}

    if(elements.btnActivePaystar) {
        elements.btnActivePaystar.addEventListener('click', e => {
            e.preventDefault()
            elements.btnActivePaystar.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: '/api/user/{{ $customer->user->id }}',
                method: 'PUT',
                data: {"action": "activePaystar", "customer_id": {{ $customer->id }}},
                success: data => {
                    elements.btnActivePaystar.removeAttribute('data-kt-indicator')
                    if(data.state === 'warning') {
                        toastr.warning(`${data.message}`)
                    } else {
                        toastr.success(`${data.message}`, `Paystar`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    }
                }
            })
        })
    }
    if(elements.btnDesactivePaystar) {
        elements.btnDesactivePaystar.addEventListener('click', e => {
            e.preventDefault()
            elements.btnDesactivePaystar.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: '/api/user/{{ $customer->user->id }}',
                method: 'PUT',
                data: {"action": "desactivePaystar", "customer_id": {{ $customer->id }}},
                success: data => {
                    elements.btnDesactivePaystar.removeAttribute('data-kt-indicator')
                    if(data.state === 'warning') {
                        toastr.warning(`${data.message}`)
                    } else {
                        toastr.success(`${data.message}`, `Paystar`)

                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    }
                }
            })
        })
    }
</script>
