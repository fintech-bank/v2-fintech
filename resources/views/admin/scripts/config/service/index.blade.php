<script type="text/javascript">
    let tables = {
        tableVersion: document.querySelector('#kt_version_table')
    }
    let elements = {
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
        elementTags: document.querySelectorAll('[name="types"]'),
    }
    let modals = {
        modalEditVersion: document.querySelector("#EditVersion"),
    }
    let forms = {
        formAddVersion: document.querySelector('#formAddVersion'),
        formEditVersion: document.querySelector('#formEditVersion'),
    }

    let dataTypes = null;

    let datatableVersion = $(tables.tableVersion).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })

    let edit = editor("#content")


    if (document.querySelector('[data-kt-version-filter="search"]')) {
        document.querySelector('[data-kt-version-filter="search"]').addEventListener("keyup", (function (t) {
            datatableVersion.search(t.target.value).draw()
        }))
    }

    if (elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/version/' + e.target.dataset.version,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditVersion)

                        forms.formEditVersion.setAttribute('action', '/api/core/version/' + data.id)
                        forms.formEditVersion.querySelector('[name="name"]').value = data.name
                        forms.formEditVersion.querySelector('[name="types"]').value = ''
                        data.types.forEach(type => {
                            forms.formEditVersion.querySelector('[name="types"]').value += type.name
                        })
                        forms.formEditVersion.querySelector('[name="content"]').value = data.content
                        data.publish ? forms.formEditVersion.querySelector('[name="publish"]').setAttribute('checked', 'checked') : ''


                        modal.show()
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
                    }
                })
            })
        })
    }
    if (elements.btnDelete) {
        elements.btnDelete.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/version/' + e.target.dataset.version,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Une version à été supprimé avec succès`, `Version`)

                        $(e.target.parentNode.parentNode).animate({
                            width: ["toggle", "swing"],
                            height: ["toggle", "swing"],
                            opacity: "toggle"
                        }, 1000, "linear")
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
                    }
                })
            })
        })
    }

    $(forms.formAddVersion).on('submit', e => {
        e.preventDefault()
        tinymce.triggerSave()
        let form = $(forms.formAddVersion)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La version ${data.name} à été créer avec succès`, `Version`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
            }
        })
    })
    $(forms.formEditVersion).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditVersion)
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La version ${data.name} à été edité avec succès`, `Version`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
            }
        })
    })

    elements.elementTags.forEach(tags => {
        $.ajax({
            url: '/api/core/version/types',
            success: data => {
                tagify(tags, data)
            }
        })
    })


</script>
