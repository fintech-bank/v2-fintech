<script type="text/javascript">
    let tables = {}
    let elements = {
        btnShowRib: document.querySelector('.showRib'),
        btnCopyIban: document.querySelector(".btnCopyIban"),
        targetCopyIban: document.querySelector(".ibanText")
    }
    let modals = {
        modalShowRib: document.querySelector('#showRib'),
    }
    let forms = {}
    let dataTable = {}
    let block = {}

    clipboard = new ClipboardJS(elements.btnCopyIban, {
        target: elements.targetCopyIban,
        text: () => {
            return elements.targetCopyIban.innerHTML
        }
    }).on('success', (e) => {
        let checkIcon = elements.btnCopyIban.querySelector('.fa-check')
        let icon = elements.btnCopyIban.querySelector('.fa-copy')

        if(checkIcon) {
            return;
        }

        checkIcon = document.createElement('i')
        checkIcon.classList.add('fa-solid')
        checkIcon.classList.add('fa-check')
        checkIcon.classList.add('fs-2')

        elements.btnCopyIban.appendChild(checkIcon)

        const classes = ['text-success', 'fw-boldest']
        elements.targetCopyIban.classList.add(...classes)
        elements.btnCopyIban.classList.add('btn-success')
        icon.classList.add('d-none')

        setTimeout(function () {
            icon.classList.remove('d-none');
            elements.btnCopyIban.removeChild(checkIcon);
            elements.targetCopyIban.classList.remove(...classes);
            elements.btnCopyIban.classList.remove('btn-success');
        }, 3000)
    })

    elements.btnShowRib.addEventListener('click', e => {
        e.preventDefault()
        let modal = new bootstrap.Modal(modals.modalShowRib)
        let block = new KTBlockUI(modals.modalShowRib.querySelector('.modal-body'))
        block.block()
        modal.show()
        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}',
            success: data => {
                console.log(data)
                block.release()
                block.destroy()
            }
        })
    })
</script>
