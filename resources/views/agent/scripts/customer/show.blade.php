<script type="text/javascript">
    let tables = {
        tableWallet: document.querySelector("#kt_wallet_table"),
    }
    let elements = {
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
        btnShowFiles: document.querySelectorAll('.showFiles'),
        outstanding: document.querySelector('#outstanding'),
        epargnePlanInfo: document.querySelector("#epargne_plan_info"),
        pretPlanInfo: document.querySelector("#pret_plan_info"),
        filterType: $('[data-kt-wallet-table-filter="type"]'),
        filterStatus: $('[data-kt-wallet-table-filter="status"]'),
        cardShowFiles: document.querySelector("#showFiles"),
        previous: document.querySelector('.previous'),
        next: document.querySelector('.previous'),
        btnSignate: document.querySelector("#signateDocument"),
        businessResultat: document.querySelector('.business_resultat'),
        businessFinance: document.querySelector('.business_finance'),
        businessIndicator: document.querySelector('.business_indicator'),
        btnNotifyPassword: document.querySelector('.btnNotifyPassword'),
        btnVerifyIdentity: document.querySelector('.btnVerifyIdentity'),
        btnVerifyAddress: document.querySelector('.btnVerifyAddress'),
        btnVerifyIncome: document.querySelector('.btnVerifyIncome'),
        chartEndet: document.querySelector('#chart_endettement'),
    }
    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus'),
        modalUpdateTypeAccount: document.querySelector('#updateAccount'),
        modalWriteSms: document.querySelector('#write-sms'),
        modalWriteMail: document.querySelector('#write-mail'),
        modalCreateWallet: document.querySelector('#createWallet'),
        modalCreateEpargne: document.querySelector('#createEpargne'),
        modalCreatePret: document.querySelector('#createPret'),
        modalContentFile: document.querySelector("#content_file"),
    }
    let forms = {}
    let dataTable = {
        datatableWallet: $(tables.tableWallet).DataTable({
            info: !1,
            order: [],
            columnDefs: [{
                orderable: !1,
                targets: 4
            }]
        })
    }
    let block = {
        blockShowFiles: messageBlock(elements.cardShowFiles, "Chargement des fichiers")
    }

    let pdf = (url) => {
        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.worker.min.js';

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 0.8,
            canvas = document.getElementById("contentPdf"),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({scale: scale});
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
            console.log(document.querySelector("#page_num").innerHTML)
            if(pageNum === pdfDoc.numPages) {
                btnSignate.removeAttribute('disabled')
            } else {
                btnSignate.setAttribute('disabled', '')
            }
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('previous').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;
            // Initial/first page rendering
            renderPage(pageNum);
        });
    }
    let verifSoldesAllWallets = () => {
        $.ajax({
            url: `/api/customer/{{ $customer->id }}/verifAllSolde`,
            success: data => {
                let arr = Array.from(data)

                arr.forEach(item => {
                    if (item.status === 'outdated') {
                        toastr.error(`Le compte ${item.compte} est débiteur, veuillez contacter le client`, 'Compte Débiteur')
                    }
                })
            }
        })
    }
    let citiesFromPostal = (select) => {
        let contentCities = document.querySelector('#divCity')
        let block = new KTBlockUI(contentCities, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
        block.block();

        $.ajax({
            url: '/api/core/geo/cities/' + select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }

    let countryOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let cardsOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-card-img');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let getInfoEpargnePlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/core/epargne/' + item.value,
            success: data => {
                block.release()
                block.destroy()
                console.log(data)
                modals.modalCreateEpargne.querySelector(".profit_percent").innerHTML = data.profit_percent + ' %'
                modals.modalCreateEpargne.querySelector(".lock_days").innerHTML = data.lock_days + ' jours'
                modals.modalCreateEpargne.querySelector(".profit_days").innerHTML = "Montant des interet remis à zero tous les " + data.profit_days + " jours"
                modals.modalCreateEpargne.querySelector(".init").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.init)
                modals.modalCreateEpargne.querySelector(".limit").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.limit)
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getInfoPretPlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/core/pret/' + item.value,
            success: data => {
                block.release()
                block.destroy()
                console.log(data)
                modals.modalCreatePret.querySelector(".min").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.minimum)
                modals.modalCreatePret.querySelector(".max").innerHTML = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(data.maximum)
                modals.modalCreatePret.querySelector(".duration").innerHTML = data.duration + ' mois'
                modals.modalCreatePret.querySelector(".interest").innerHTML = data.tarif.interest + ' %'
                modals.modalCreatePret.querySelector(".instruction").innerHTML = data.instruction
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getFileFromCategory = (item) => {
        console.log(item.dataset)
        let block = new KTBlockUI(document.querySelector('.showFiles'), {message: messageOverlay})
        block.block()

        $.ajax({
            url: `/agence/customers/${item.dataset.customer}/files/${item.dataset.category}`,
            success: data => {
                block.release()
                console.log(data)
            },
            error: err => {
                block.release()
                console.log(err)
            }
        })
    }

    let getFile = (file) => {
        let modal = new bootstrap.Modal(modals.modalContentFile)
        $.ajax({
            url: `/api/manager/files/${file.dataset.documentReference}`,
            success: data => {
                console.log(data)
                data.signable === 0 ? modals.modalContentFile.querySelector('.modal-footer').classList.add('d-none') : modals.modalContentFile.querySelector('.modal-footer').classList.remove('d-none');
                modal.show()
                pdf(data.url_folder)

            }
        })
    }

    let templateShowFiles = (data) => {
        console.log(data)
        elements.cardShowFiles.querySelector('.card-title').innerHTML = `Categorie: ${data.category.name}`
        elements.cardShowFiles.querySelector('.folderPath').innerHTML = `
        <!--begin::Folder path-->
        <div class="badge badge-lg badge-light-primary">
            <div class="d-flex align-items-center flex-wrap">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs039.svg-->
                <span class="svg-icon svg-icon-2x svg-icon-primary me-3">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.3" d="M14.1 15.013C14.6 16.313 14.5 17.813 13.7 19.113C12.3 21.513 9.29999 22.313 6.89999 20.913C5.29999 20.013 4.39999 18.313 4.39999 16.613C5.09999 17.013 5.99999 17.313 6.89999 17.313C8.39999 17.313 9.69998 16.613 10.7 15.613C11.1 15.713 11.5 15.813 11.9 15.813C12.7 15.813 13.5 15.513 14.1 15.013ZM8.5 12.913C8.5 12.713 8.39999 12.513 8.39999 12.313C8.39999 11.213 8.89998 10.213 9.69998 9.613C9.19998 8.313 9.30001 6.813 10.1 5.513C10.6 4.713 11.2 4.11299 11.9 3.71299C10.4 2.81299 8.49999 2.71299 6.89999 3.71299C4.49999 5.11299 3.70001 8.113 5.10001 10.513C5.80001 11.813 7.1 12.613 8.5 12.913ZM16.9 7.313C15.4 7.313 14.1 8.013 13.1 9.013C14.3 9.413 15.1 10.513 15.3 11.713C16.7 12.013 17.9 12.813 18.7 14.113C19.2 14.913 19.3 15.713 19.3 16.613C20.8 15.713 21.8 14.113 21.8 12.313C21.9 9.513 19.7 7.313 16.9 7.313Z" fill="currentColor"></path>
						<path d="M9.69998 9.61307C9.19998 8.31307 9.30001 6.81306 10.1 5.51306C11.5 3.11306 14.5 2.31306 16.9 3.71306C18.5 4.61306 19.4 6.31306 19.4 8.01306C18.7 7.61306 17.8 7.31306 16.9 7.31306C15.4 7.31306 14.1 8.01306 13.1 9.01306C12.7 8.91306 12.3 8.81306 11.9 8.81306C11.1 8.81306 10.3 9.11307 9.69998 9.61307ZM8.5 12.9131C7.1 12.6131 5.90001 11.8131 5.10001 10.5131C4.60001 9.71306 4.5 8.91306 4.5 8.01306C3 8.91306 2 10.5131 2 12.3131C2 15.1131 4.2 17.3131 7 17.3131C8.5 17.3131 9.79999 16.6131 10.8 15.6131C9.49999 15.1131 8.7 14.1131 8.5 12.9131ZM18.7 14.1131C17.9 12.8131 16.7 12.0131 15.3 11.7131C15.3 11.9131 15.4 12.1131 15.4 12.3131C15.4 13.4131 14.9 14.4131 14.1 15.0131C14.6 16.3131 14.5 17.8131 13.7 19.1131C13.2 19.9131 12.6 20.5131 11.9 20.9131C13.4 21.8131 15.3 21.9131 16.9 20.9131C19.3 19.6131 20.1 16.5131 18.7 14.1131Z" fill="currentColor"></path>
					</svg>
				</span>
                <!--end::Svg Icon-->
                <a href="/metronic8/demo1/../demo1/apps/file-manager/folders.html">Documents</a>
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                <span class="svg-icon svg-icon-2x svg-icon-primary mx-1">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
					</svg>
				</span>
                <!--end::Svg Icon-->

                <!--end::Svg Icon-->${data.category.name}</div>
        </div>
        <!--end::Folder path-->
        <!--begin::Folder Stats-->
        <div class="badge badge-lg badge-primary">
            <span id="kt_file_manager_items_counter">${data.count} ${ data.count <= 1 ? 'Fichier' : 'Fichiers' }</span>
        </div>
        <!--end::Folder Stats-->
        `

        elements.cardShowFiles.querySelector("#table_files_content").innerHTML = ''

        Array.from(data.files).forEach(file => {
            let templateSign = (data) => {
                console.log(data)
                return `
                    <div class="d-flex flex-row">
                        <strong>Signé par le client:</strong>
                        ${data.signed_by_client_label}
                    </div>
                `
            }

            let signate = {
                0: {'fn': 'Pas de signature'},
                1: {'fn': templateSign(file)}
            }
            elements.cardShowFiles.querySelector("#table_files_content").innerHTML += `
            <tr>
                <td>
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row align-items-center">
                            <i class="fa-solid fa-file-pdf-o fs-2tx me-2"></i>
                            <div class="d-flex flex-column">
                                <a href="" data-url="${file.url_folder}" class="text-gray-800 text-hover-primary">${file.name}</a>
                                <div class="text-muted">${file.reference}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    ${signate[file.signable].fn}
                </td>
                <td class="text-end">
                    <button class="btn btn-icon btn-sm btn-secondary" data-document-reference="${file.reference}" onclick="getFile(this)"><i class="fa-solid fa-eye"></i> </button>
                </td>
            </tr>
            `
        })
    }

    let chartEnd = () => {
        let chart = new ApexCharts(elements.chartEndet, {
            series: [76],
            chart: {
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 0,
                            color: '#999',
                            opacity: 1,
                            blur: 2
                        }
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: -2,
                            fontSize: '22px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    shadeIntensity: 0.4,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 53, 91]
                },
            },
            labels: ['Average Results'],
        })
        chart.render()

    }

    @if($customer->info->type != 'part')
    let updateBusiness = (field) => {
        if(document.querySelector('[name="'+field+'"]')) {
            document.querySelector('[name="'+field+'"]').addEventListener('blur', e => {
                e.preventDefault()
                let data = $('[name="'+field+'"]').serializeArray()
                $.ajax({
                    url: '/api/customer/{{ $customer->id }}/business',
                    method: 'PUT',
                    data: data,
                    success: data => {
                        elements.businessResultat.innerHTML = data.business.result_format;
                        elements.businessFinance.innerHTML = data.business.result_finance_format;
                        elements.businessIndicator.innerHTML = data.business.indicator_format;
                    }
                })
            })
        }
    }

    updateBusiness('ca')
    updateBusiness('achat')
    updateBusiness('frais')
    updateBusiness('salaire')
    updateBusiness('impot')
    updateBusiness('other_product')
    updateBusiness('other_charge')
    updateBusiness('apport_personnel')
    updateBusiness('finance')
    @endif

    verifSoldesAllWallets();
    citiesFromPostal(document.querySelector("#postal"))

    modals.modalUpdateStatusAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateStatus")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'put',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le compte du client est maintenant <strong>${data.status}</strong>`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
    modals.modalUpdateTypeAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateAccount")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'put',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le type de compte du client à été mis à jours`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
    modals.modalWriteSms.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteSms")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Sms à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du sms au client", "Erreur Système")
            }
        })
    })
    modals.modalWriteMail.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteMail")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Mail à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du mail au client", "Erreur Système")
            }
        })
    })
    elements.btnPass.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitPass`,
            method: 'put',
            success: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le mot de passe du client à été réinitialiser", "Réinitialisation du mot de passe")
            },
            error: () => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du mot de passe", "Erreur système")
            }
        })
    })
    elements.btnCode.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/api/customer/${elements.btnCode.dataset.customer}/reinitCode`,
            method: 'put',
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le Code SECURPASS du client à été réinitialiser", "Réinitialisation du code SECURPASS")
            },
            error: err => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
            }
        })
    })
    if (elements.btnAuth) {
        elements.btnAuth.addEventListener('click', e => {
            e.preventDefault()

            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/api/customer/${elements.btnCode.dataset.customer}/reinitAuth`,
                method: 'put',
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.success("L'authentification double facteur du client à été réinitialiser", "Réinitialisation de l'authentificateur")
                },
                error: err => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
                }
            })
        })
    }
    if(elements.btnShowFiles) {
        elements.btnShowFiles.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                block.blockShowFiles.block()
                $.ajax({
                    url: '/api/manager/files',
                    data: {'folder': btn.dataset.folder, 'customer': {{ $customer->id }}},
                    success: data => {
                        block.blockShowFiles.release()
                        block.blockShowFiles.destroy()
                        templateShowFiles(data)
                    }
                })
            })
        })
    }
    if(elements.btnNotifyPassword) {
        elements.btnNotifyPassword.addEventListener('click', e => {
            $.ajax({
                url: '/api/customer/{{ $customer->id }}/alert',
                method: 'POST',
                data: {"action": "password"},
                success: () => {
                    toastr.success(`Une notification va être envoyer au client`, ``)
                }
            })
        })
    }
    if(elements.btnVerifyIdentity) {
        elements.btnVerifyIdentity.addEventListener('click', e => {
            e.preventDefault()
            if(!e.target.dataset.status) {
                $.ajax({
                    url: '/api/customer/{{ $customer->id }}/verify',
                    method: 'POST',
                    data: {"verify": "identity"},
                    success: () => {
                        toastr.success(`Une notification à été envoyé au client`, ``)
                    }
                })
            }
        })
    }
    if(elements.btnVerifyAddress) {
        elements.btnVerifyAddress.addEventListener('click', e => {
            e.preventDefault()
            if(!e.target.dataset.status) {
                $.ajax({
                    url: '/api/customer/{{ $customer->id }}/verify',
                    method: 'POST',
                    data: {"verify": "address"},
                    success: () => {
                        toastr.success(`Une notification à été envoyé au client`, ``)
                    }
                })
            }
        })
    }
    if(elements.btnVerifyIncome) {
        elements.btnVerifyIncome.addEventListener('click', e => {
            e.preventDefault()
            if(!e.target.dataset.status) {
                $.ajax({
                    url: '/api/customer/{{ $customer->id }}/verify',
                    method: 'POST',
                    data: {"verify": "income"},
                    success: () => {
                        toastr.success(`Une notification à été envoyé au client`, ``)
                    }
                })
            }
        })
    }
    document.querySelectorAll('.callCategory').forEach(call => {
        call.addEventListener('click', e => {
            e.preventDefault();
            let showFile = document.querySelector('.showFiles')

            $.ajax({
                url: `/agence/customers/${call.dataset.customer}/files/${call.dataset.category}`,
                method: 'POST',
                success: data => {
                    showFile.querySelector('.content').innerHTML = ``
                    if (data.count === 0) {
                        showFile.querySelector(".empty").classList.remove('d-none')
                    } else {
                        showFile.querySelector(".empty").classList.add('d-none')
                        showFile.querySelector('.content').innerHTML = data.html
                    }
                    console.log(data)
                },
                error: err => {
                    console.log(err)
                }
            })
        })
    })
    document.querySelector('[data-kt-wallet-table-filter="search"]').addEventListener('keyup', e => {
        dataTable.datatableWallet
            .search(e.target.value)
            .draw()
    })
    document.querySelector('[data-kt-wallet-table-filter="filter"]').addEventListener("click", () => {
        const n = elements.filterStatus.val()
        const c = elements.filterType.val()

        const r = `${n} ${c}`
        dataTable.datatableWallet.search(r).draw()
    })


    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })
    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    $("#formCreateWallet").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateWallet")
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
                toastr.success(`Le nouveau compte épargne à été créer avec succès`, `Compte épargne`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
    $("#formCreateEpargne").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateEpargne")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le nouveau compte épargne à été créer avec succès`, `Compte épargne`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
    $("#formCreatePret").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreatePret")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le nouveau prêt bancaire à été créer avec succès`, `Prêt bancaire`)

                setTimeout(() => {
                    window.location.reload()
                }, 1200)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })
</script>
