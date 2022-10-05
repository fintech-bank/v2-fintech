<script type="text/javascript">
    let tables = {}
    let elements = {
        divUploadDomicile: "#upload_domicile",
        dropUploadDomicile: document.querySelector("#upload_domicile"),
        divUploadRentOne: "#upload_rent_one",
        dropUploadRentOne: document.querySelector("#upload_rent_one"),
        divUploadRentTwo: "#upload_rent_two",
        dropUploadRentTwo: document.querySelector("#upload_rent_two"),
        buttonBtnVerify: document.querySelector(".btnVerify")
    }
    let modals = {}
    let forms = {}

    function choiceCard() {
        let type_debit = ""
        document.querySelectorAll('[name="support"]').forEach((input => {
            input.checked && (type_debit = input.value)
        }))

        if(type_debit === 'classic') {
            document.querySelector("#typeDebit").classList.add('d-none')
        } else {
            document.querySelector("#typeDebit").classList.remove('d-none')
        }
    }

    let dropzoneUploadDomicile = () => {
        let previewUploadDomicile = elements.dropUploadDomicile.querySelector('.dropzone-item')
        previewUploadDomicile.id = ''
        let templateUploadDomicile = previewUploadDomicile.parentNode.innerHTML
        previewUploadDomicile.parentNode.removeChild(previewUploadDomicile)

        let dropzoneUploadDomicile = new Dropzone(elements.divUploadDomicile, {
            url: '/api/core/document?customer_id={{ isset($customer->id) ? $customer->id : null }}&name=domicile',
            parallelUploads: 1,
            maxFilesize: 10, // Max filesize in MB
            maxFile: 1,
            previewTemplate: templateUploadDomicile,
            previewsContainer: elements.divUploadDomicile + " .dropzone-items", // Define the container to display the previews
            clickable: elements.divUploadDomicile + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            uploadMultiple: false
        })

        dropzoneUploadDomicile.on('addedfile', () => {
            const dropzoneItems = elements.dropUploadDomicile.querySelectorAll('.dropzone-item');
            dropzoneItems.forEach(dropzoneItem => {
                dropzoneItem.style.display = '';
            });
        })

        dropzoneUploadDomicile.on("totaluploadprogress", function (progress) {
            const progressBars = elements.dropUploadDomicile.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.width = progress + "%";
            });
        });

        dropzoneUploadDomicile.on("sending", function () {
            // Show the total progress bar when upload starts
            const progressBars = elements.dropUploadDomicile.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.opacity = "1";
            });
        });

        dropzoneUploadDomicile.on("complete", function () {
            const progressBars = elements.dropUploadDomicile.querySelectorAll('.dz-complete');

            setTimeout(function () {
                progressBars.forEach(progressBar => {
                    progressBar.querySelector('.progress-bar').style.opacity = "0";
                    progressBar.querySelector('.progress').style.opacity = "0";
                });
            }, 300);
        });
    }
    let dropzoneUploadRentOne = () => {
        let previewUploadRentOne = elements.dropUploadRentOne.querySelector('.dropzone-item')
        previewUploadRentOne.id = ''
        let templateUploadRentOne = previewUploadRentOne.parentNode.innerHTML
        previewUploadRentOne.parentNode.removeChild(previewUploadRentOne)

        let dropzoneUploadRentOne = new Dropzone(elements.divUploadRentOne, {
            url: '/api/core/document?customer_id={{ isset($customer->id) ? $customer->id : null }}&name=rent_one',
            parallelUploads: 1,
            maxFilesize: 10, // Max filesize in MB
            maxFile: 1,
            previewTemplate: templateUploadRentOne,
            previewsContainer: elements.divUploadRentOne + " .dropzone-items", // Define the container to display the previews
            clickable: elements.divUploadRentOne + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            uploadMultiple: false
        })

        dropzoneUploadRentOne.on('addedfile', () => {
            const dropzoneItems = elements.dropUploadRentOne.querySelectorAll('.dropzone-item');
            dropzoneItems.forEach(dropzoneItem => {
                dropzoneItem.style.display = '';
            });
        })

        dropzoneUploadRentOne.on("totaluploadprogress", function (progress) {
            const progressBars = elements.dropUploadRentOne.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.width = progress + "%";
            });
        });

        dropzoneUploadRentOne.on("sending", function () {
            // Show the total progress bar when upload starts
            const progressBars = elements.dropUploadRentOne.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.opacity = "1";
            });
        });

        dropzoneUploadRentOne.on("complete", function () {
            const progressBars = elements.dropUploadRentOne.querySelectorAll('.dz-complete');

            setTimeout(function () {
                progressBars.forEach(progressBar => {
                    progressBar.querySelector('.progress-bar').style.opacity = "0";
                    progressBar.querySelector('.progress').style.opacity = "0";
                });
            }, 300);
        });
    }
    let dropzoneUploadRentTwo = () => {
        let previewUploadRentTwo = elements.dropUploadRentTwo.querySelector('.dropzone-item')
        previewUploadRentTwo.id = ''
        let templateUploadRentTwo = previewUploadRentTwo.parentNode.innerHTML
        previewUploadRentTwo.parentNode.removeChild(previewUploadRentTwo)

        let dropzoneUploadRentTwo = new Dropzone(elements.divUploadRentTwo, {
            url: '/api/core/document?customer_id={{ isset($customer->id) ? $customer->id : null }}&name=rent_two',
            parallelUploads: 1,
            maxFilesize: 10, // Max filesize in MB
            maxFile: 1,
            previewTemplate: templateUploadRentTwo,
            previewsContainer: elements.divUploadRentTwo + " .dropzone-items", // Define the container to display the previews
            clickable: elements.divUploadRentTwo + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            uploadMultiple: false
        })

        dropzoneUploadRentTwo.on('addedfile', () => {
            const dropzoneItems = elements.dropUploadRentTwo.querySelectorAll('.dropzone-item');
            dropzoneItems.forEach(dropzoneItem => {
                dropzoneItem.style.display = '';
            });
        })

        dropzoneUploadRentTwo.on("totaluploadprogress", function (progress) {
            const progressBars = elements.dropUploadRentTwo.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.width = progress + "%";
            });
        });

        dropzoneUploadRentTwo.on("sending", function () {
            // Show the total progress bar when upload starts
            const progressBars = elements.dropUploadRentTwo.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.opacity = "1";
            });
        });

        dropzoneUploadRentTwo.on("complete", function () {
            const progressBars = elements.dropUploadRentTwo.querySelectorAll('.dz-complete');

            setTimeout(function () {
                progressBars.forEach(progressBar => {
                    progressBar.querySelector('.progress-bar').style.opacity = "0";
                    progressBar.querySelector('.progress').style.opacity = "0";
                });
            }, 300);
        });
    }

    let countryBirthOptions = (item) => {
        if ( !item.id ) {
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
        if ( !item.id ) {
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

    let countryOptions = (item) => {
        if ( !item.id ) {
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

    let citiesFromCountry = (select) => {
        console.log(select.value)
        let contentCities = document.querySelector('#divCities')
        $.ajax({
            url: '/api/core/geo/cities',
            method: 'post',
            data: {"country": select.value},
            success: data => {
                console.log(data)
                contentCities.innerHTML = data
                $("#citybirth").select2()
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
            url: '/api/core/geo/cities/'+select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }

    document.querySelectorAll('[name="postal"]').forEach(input => {
        input.addEventListener('keyup', e => {
            console.log(e.target.value.length)
            if(e.target.value.length === 5) {
                citiesFromPostal(e.target)
            }
        })
    })

    if(elements.buttonBtnVerify) {
        elements.buttonBtnVerify.addEventListener('click', e => {
            e.preventDefault()
            const persona = new Persona.Client({
                templateId: 'itmpl_dtC4KRK6GMLCzXtRcRZ68gVv',
                environment: 'sandbox',
                onReady: () => persona.open(),
                onComplete: ({ inquiryId, status, fields }) => {
                    console.log(`Completed inquiry ${inquiryId} with status ${status}`);
                    if(status === 'completed') {
                        window.location.href='{{ route('auth.register.personnal.identity', ['action' => 'verifyIdentity', 'status' => 'success', "customer_id" => isset($customer->id) ? $customer->id : null]) }}'
                    } else {
                        window.location.href='{{ route('auth.register.personnal.identity', ['action' => 'verifyIdentity', 'status' => 'error', "customer_id" => isset($customer->id) ? $customer->id : null]) }}'
                    }
                }
            })
        })
    }

    $("#countrybirth").select2({
        templateSelection: countryBirthOptions,
        templateResult: countryBirthOptions
    })

    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })

    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    if(elements.dropUploadDomicile) {
        dropzoneUploadDomicile()
    }

    if(elements.dropUploadRentOne) {
        dropzoneUploadRentOne()
    }

    if(elements.dropUploadRentTwo) {
        dropzoneUploadRentTwo()
    }

</script>
