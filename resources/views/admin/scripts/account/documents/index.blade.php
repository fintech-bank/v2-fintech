<script type="text/javascript">
    let tables = {
        tableManager: document.querySelector('#tableManager')
    }
    let elements = {}
    let modals = {}
    let forms = {}

    let getFolders = (parent = null) => {
        $.ajax({
            url: '/api/manager/folders',
            data: {'user_id': '{{ $user->id }}'},
            success: data => {
                console.log(data)
                let table = tables.tableManager.querySelector('tbody');
                table.innerHTML = ''
                data.forEach(folder => {
                    table.innerHTML += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-folder text-primary me-4"></i>
                                <a href="" class="text-gray-800 text-hover-primary">${folder.name}</a>
                            </div>
                        </td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <button class="btn btn-icon btn-sm btn-light btn-active-danger me-2"><i class="fa-solid fa-trash"></i> </button>
                        </td>
                    </tr>
                    `
                })

                $(tables.tableManager).DataTable()
            }
        })
    }

    getFolders()
</script>
