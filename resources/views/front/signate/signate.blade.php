@extends("front.layouts.app")

@section("content")
    <div class="d-flex flex-row justify-content-between align-items-center w-100 bg-white p-5 shadow-lg">
        <div class="fw-bolder fs-2tx">{{ $document->name }}</div>
        <div class="">
            <x-base.button
                text="<i class='fa-solid fa-check-circle'></i> Accepter"
                class="btn btn-success"
            />
            <x-base.button
                text="<i class='fa-solid fa-xmark-circle'></i> Refuser"
                class="btn btn-danger"
            />
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <button class="btn btn-circle btn-light btn-sm me-2" id="previous"><i class="fa-solid fa-arrow-left"></i> </button>
                <button class="btn btn-circle btn-light btn-sm me-5" id="next"><i class="fa-solid fa-arrow-right"></i> </button>
                <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-circle btn-light btn-sm me-2" id="zoomin"><i class="fa-solid fa-plus-circle"></i> </button>
                <button class="btn btn-circle btn-light btn-sm" id="zoomout"><i class="fa-solid fa-minus-circle"></i> </button>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-center">
                <canvas id="pdfcontent"></canvas>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button id="signateDocument" class="btn btn-bank btn-circle" disabled>
                    <span class="indicator-label">
                        <i class="fa-solid fa-signature me-2"></i> Signer le document
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        let btn = {
            previous: document.querySelector('.previous'),
            next: document.querySelector('.previous'),
            zoomin: document.querySelector('.zoomin'),
            zoomout: document.querySelector('.zoomout'),
        }
        let pdfContent = document.querySelector('.pdfcontent')
        let btnSignate = document.querySelector("#signateDocument")
        let url = `/storage/gdd/{{ $document->customer->user->id }}/documents/Contrats/{{ $document->name }}.pdf`
        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.worker.min.js';

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.1,
            canvas = document.getElementById('pdfcontent'),
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

    </script>
@endsection
