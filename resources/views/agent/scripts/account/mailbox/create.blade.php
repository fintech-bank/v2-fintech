<script type="text/javascript">
    let tables = {}
    let elements = {
        tagify: document.querySelector('[data-kt-inbox-form="tagify"]'),
        remap: document.querySelector('[data-content="remap-subject"]'),
        inputSubject: document.querySelector('[name="subject"]'),
        inputBody: document.querySelector('[name="body"]'),
        btnAttachments: document.querySelector("#btn_attachments"),
        inputAttachments: document.querySelector(".inputAttachments"),
        attachmentZone: document.querySelector('.attachmentsZone')
    }
    let modals = {}
    let forms = {
        formComposer: document.querySelector("#kt_inbox_compose_form"),
    }

    tinymce.init({
        selector: '#kt_inbox_form_editor',
        height: '480',
        toolbar: ["styleselect fontselect fontsizeselect",
            "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify",
            "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"],
        plugins : "advlist autolink link image lists charmap preview code"
    })

    function tagTemplate(tagData) {
        return `
        <tag title="${(tagData.title || tagData.email)}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div class="d-flex align-items-center">
                <div class='tagify__tag__avatar-wrap ps-0 me-3'>
                    <div class="symbol symbol-25px symbol-circle">
                        ${tagData.avatar}
                    </div>
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
        </tag>
    `
    }

    function suggestionItemTemplate(tagData) {
        return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">

            ${tagData.avatar ? `
                    <div class='tagify__dropdown__item__avatar-wrap me-2'>
                        <div class="symbol symbol-25px symbol-circle">
                            ${tagData.avatar}
                        </div>
                    </div>` : ''
        }

            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
                <span>${tagData.email}</span>
            </div>
        </div>
    `
    }

    function onDropdownShow(e) {
        let dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

        if (tagify.suggestedListItems.length > 1) {
            addAllSuggestionsElm = getAddAllSuggestionsElm();

            // insert "addAllSuggestionsElm" as the first element in the suggestions list
            dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
        }
    }

    function onSelectSuggestion(e) {
        if (e.detail.elm === getAddAllSuggestionsElm)
            tagify.dropdown.selectAll.call(tagify);
    }

    function getAddAllSuggestionsElm() {
        // suggestions items should be based on "dropdownItem" template
        return tagify.parseTemplate('dropdownItem', [{
                class: "addAll",
                name: "Add all",
                email: tagify.settings.whitelist.reduce(function (remainingSuggestions, item) {
                    return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
                }, 0) + " Members"
            }]
        )
    }

    if(elements.inputSubject) {
        elements.inputSubject.addEventListener('keyup', e => {
            if(e.target.value.length === 0) {
                elements.remap.innerHTML = "Nouveau Message"
            } else {
                elements.remap.innerHTML = e.target.value
            }
        })
    }
    if(elements.inputAttachments) {
        elements.inputAttachments.addEventListener('change', () => {
            let inputInfos = document.querySelector("input[type=file]").files

            inputInfos.forEach(info => {
                console.log(info)
                elements.attachmentZone.querySelector('.contentZone').innerHTML += `<li>${info.name} (${formatBytes(info.size, 2)})</li>`
            })
        })
    }


    $.ajax({
        url: '/api/user/list',
        data: {'action': 'suggest', 'user_id': {{ auth()->user()->id }}},
        success: data => {
            let tags = new Tagify(elements.tagify, {
                tagTextProp: 'name', // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
                enforceWhitelist: true,
                skipInvalid: true, // do not remporarily add invalid tags
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: data
            })

            tags.on('dropdown:show dropdown:updated', onDropdownShow)
            tags.on('dropdown:select', onSelectSuggestion)
        }
    })
window.onbeforeunload = () => {
    elements.attachmentZone.querySelector('.contentZone').innerHTML = ''
}
</script>
