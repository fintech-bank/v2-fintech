const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;



let tagify = (element, data) => {
    let ds = []
    data.forEach(d => {
        ds.push(d.name)
    })
    return new Tagify(element, {
        whitelist: ds,
        maxTags: 10,
        dropdown: {
            maxItems: 20,           // <- mixumum allowed rendered suggestions
            classname: "tagify__inline__suggestions", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
        }
    })
}

document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
    }
})

let editor = (div) => {
    return tinymce.init({
        selector: div,
        height: '480',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        importcss_append: true,
        file_picker_callback: (callback, value, meta) => {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', {text: 'My text'});
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', {alt: 'My alt text'});
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', {source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg'});
            }
        },
        templates: [
            {
                title: 'New Table',
                description: 'creates a new table',
                content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
            },
            {title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...'},
            {
                title: 'New list with dates',
                description: 'New List with dates',
                content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
            }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    })
}

let getHeaderBadger = () => {
    let badgeNotify = document.querySelector('.unreadNotifyBadge')
    let badgeMail = document.querySelector('.unreadMailBadge')

    fetch(`/api/user/${badgeNotify.dataset.user}/info`)
        .then(r => {
            return r.json()
        }).then(response => {

        if (response.notifications.unread !== 0) {
            badgeNotify.innerHTML = response.notifications.unread
        } else {
            $(badgeNotify).hide()
        }

        if (response.mailer.unread_count !== 0) {
            badgeMail.innerHTML = response.mailer.unread_count
        } else {
            $(badgeMail).hide()
        }
    }).catch(err => {
        console.error(err)
    })
}

let formatBytes = (bytes,decimals) => {
    if(bytes == 0) return '0 Bytes';
    var k = 1024,
        dm = decimals || 2,
        sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

/**
 * @param {*} blockDiv
 * @param {string} message
 */
let messageBlock = (blockDiv, message = 'Veuillez PAtienter...') => {
    return new KTBlockUI(blockDiv, {
        message: `<div class="blockui-message"><span class="spinner-border text-primary"></span> ${message}</div>`,
        overlayClass: "bg-gray-600",
    })
}

const showPdf = (urlFile, divContentId) => {
    let pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.worker.min.js';

    let pdfFunction = () => {
        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 0.8,
            canvas = document.getElementById(divContentId),
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
}

getHeaderBadger()

if(document.querySelectorAll('.datepick')) {
    document.querySelectorAll('.datepick').forEach(element => {
        $(element).flatpickr()
    })
}
if(document.querySelectorAll('.datetime')) {
    document.querySelectorAll('.datetime').forEach(element => {
        $(element).flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minuteIncrement: 30
        })
    })
}

/**
 *
 * @param type_swal // password,secure
 * @param customer_id
 * @param forminfo
 * @param agent //Device-software-version-name
 */
let executeVerifiedAjax = (type_swal, customer_id, forminfo, event = null, agent = null) => {
    event.preventDefault()
    let text = type_swal === 'password' ? 'Veuillez saisir votre mot de passe' : "Veuillez valider votre action avec votre téléphone"
    if(type_swal === 'password') {
        Swal.fire({
            title: text,
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: false,
            confirmButtonText: 'Valider',
            showLoaderOnConfirm: true,
            backdrop: true,
            preConfirm: (password) => {
                return fetch('/api/user/verify/pass', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                    },
                    body: JSON.stringify({
                        "verify": "pass",
                        "customer_id": customer_id,
                        "pass": password
                    })
                }).then(response => {
                    if(!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                }).catch(error => {
                    Swal.fire({
                        title: 'Mot de passe Invalide',
                        text: error,
                        icon: 'error'
                    })
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.isConfirmed) {
                forminfo.btn.attr('data-kt-indicator', 'on')

                $.ajax({
                    url: forminfo.url,
                    method: forminfo.method,
                    data: forminfo.data,
                    success: data => {
                        forminfo.btn.removeAttr('data-kt-indicator')

                        if(data.state === 'warning') {
                            toastr.success(`${data.message}`, ``)
                        } else {
                            toastr.success(`${data.message}`, ``)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    },
                    error: () => {
                        forminfo.btn.removeAttr('data-kt-indicator')
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            }
        })
    } else {
        Swal.fire({
            title: text,
            showCancelButton: false,
            confirmButtonText: 'Authentifier',
            showLoaderOnConfirm: true,
            backdrop: true,
            preConfirm: () => {
                return fetch('/api/user/verify/secure', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                    },
                    body: JSON.stringify({
                        "verify": "secure",
                        "customer_id": customer_id,
                        "agent": agent
                    })
                }).then(response => {
                    if(!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                }).catch(error => {
                    Swal.fire({
                        title: 'Secure Pass Invalide',
                        text: error,
                        icon: 'error'
                    })
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.isConfirmed) {
                forminfo.btn.attr('data-kt-indicator', 'on')

                $.ajax({
                    url: forminfo.url,
                    method: forminfo.method,
                    data: forminfo.data,
                    success: data => {
                        forminfo.btn.removeAttr('data-kt-indicator')

                        if(data.state === 'warning') {
                            toastr.success(`${data.message}`, ``)
                        } else {
                            toastr.success(`${data.message}`, ``)

                            setTimeout(() => {
                                window.location.reload()
                            }, 1200)
                        }
                    },
                    error: () => {
                        forminfo.btn.removeAttr('data-kt-indicator')
                        toastr.error(`Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur`, `Erreur Système`)
                    }
                })
            }
        })
    }
}
