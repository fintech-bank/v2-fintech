<script type="text/javascript">
    let tables = {
        tableTransaction: document.querySelector("#kt_transaction_table"),
        tableClaims: document.querySelector("#liste_claims"),
        tableCaution: document.querySelector("#liste_caution"),
    }
    let elements = {
        cniField: document.querySelector('[name="cni_number"]'),
        btnDeleteCaution: document.querySelectorAll('.btnDeleteCaution')
    }
    let modals = {}
    let forms = {
        formAddClaim: document.querySelector("#formAddClaim")
    }
    let dataTable = {
        datatableTransaction: $(tables.tableTransaction).DataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>",
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableClaims: $(tables.tableClaims).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
        datatableCaution: $(tables.tableCaution).DataTable({
            info: !1,
            order: [],
            pageLength: 10,
        }),
    }
    let block = {}

    if(elements.cniField) {
        elements.cniField.addEventListener('blur', e => {
            verifyCni(e)
        })
    }
    if(elements.btnDeleteCaution) {
        elements.btnDeleteCaution.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                btn.setAttribute('data-kt-indicator', 'on')

                $.ajax({
                    url: '/api/customer/{{ $wallet->customer->id }}/'
                })
            })
        })
    }

    let verifyCni = (fie) => {
        $.ajax({
            url: '/api/customer/{{ $wallet->customer->id }}/verify',
            method: 'POST',
            data: {
                "verify": "cni",
                "name": document.querySelector('[name="name"]').value,
                "dep_nai": document.querySelector('[name="dep_nai"]').value,
                "genre": document.querySelector('[name="genre"]').value,
                "birthdate": document.querySelector('[name="birthdate"]').value,
                "cni_number": fie.target.value,
                "pays_nai": document.querySelector('[name="pays_nai"]').value,
                "cni_version": document.querySelector('[name="cni_version"]').value,
            },
            success: data => {
                console.log(data)
                if(!data) {
                    elements.cniField.classList.add('is-valid')
                    elements.cniField.classList.add('is-invalid')
                    let p = document.createElement('p')
                    elements.cniField.after(p)
                    p.classList.add('text-danger')
                    p.innerHTML = 'Numéro de carte erroné !'
                } else {
                    elements.cniField.classList.remove('is-invalid')
                    elements.cniField.classList.add('is-valid')
                }
            }
        })
    }

    $(forms.formAddClaim).on('submit', e => {
        e.preventDefault()
        let form = $(forms.formAddClaim)
        let url = '/api/insurance/{{ $wallet->loan->insurance->reference }}/claim'
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La déclaration de sinitre à bien été enregistré`, `Déclaration de sinistre`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
            }
        })
    })
</script>
