<script type="text/javascript">
    let tables = {
        tableCategories: document.querySelector('#kt_category_table')
    }
    let elements = {
        btnEdit: document.querySelectorAll('.btnEdit'),
        btnDelete: document.querySelectorAll('.btnDelete'),
    }
    let modals = {
        modalEditCategory: document.querySelector("#EditCategory")
    }
    let forms = {
        formAddCategory: document.querySelector('#formAddCategory'),
        formEditCategory: document.querySelector('#formEditCategory'),
    }

    let datatableCategories = $(tables.tableCategories).DataTable({
        info: !1,
        order: [],
        pageLength: 10,
    })

    if(document.querySelector('[data-kt-category-filter="search"]')) {
        document.querySelector('[data-kt-category-filter="search"]').addEventListener("keyup", (function(t) {
            datatableCategories.search(t.target.value).draw()
        }))
    }

    if(elements.btnEdit) {
        elements.btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/category/'+e.target.dataset.category,
                    success: data => {
                        let modal = new bootstrap.Modal(modals.modalEditCategory)

                        forms.formEditCategory.setAttribute('action', '/admin/configuration/category'+data.id)
                        forms.formEditCategory.querySelector('[name="name"]').value = data.name

                        modal.show()
                    },
                    error: () => {
                        toastr.error(`Erreur lors de l'exécution du script, veuillez consulter les logs ou contacter un administrateur !`, `Erreur Système`)
                    }
                })
            })
        })
    }
    if(elements.btnDelete) {
        elements.btnDelete.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                $.ajax({
                    url: '/api/core/category/'+e.target.dataset.category,
                    method: "DELETE",
                    success: () => {
                        toastr.success(`Une catégorie de document à été supprimé avec succès`, `Catégorie de document`)

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

    $(forms.formAddCategory).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddCategory)
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
                toastr.success(`La catégorie ${data.name} à été créer avec succès`, `Catégorie de document`)

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
    $(forms.formEditCategory).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formEditCategory)
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
                toastr.success(`La catégorie ${data.name} à été edité avec succès`, `Catégorie de document`)

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
</script>
