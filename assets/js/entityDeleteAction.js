
import { Modal } from "bootstrap";

const deleteBtnAction = document.querySelectorAll('.delete-btn-action');
const modalOfDeleteElement = document.getElementById("modalOfDelete");
const modalOfDelete = new Modal(modalOfDeleteElement);

modalOfDeleteElement
    .getElementsByClassName('closeBtn')
    .item(0)
    .addEventListener('click', function () { modalOfDelete.hide() });

deleteBtnAction.forEach(function(e) {
    e.addEventListener('click', function() {
        if(!entityDeletionData(e) != null) {
            const {url, _token, text} = entityDeletionData(e);
            let form = modalOfDeleteElement.getElementsByTagName('form').item(0);
            let tokenInput = modalOfDeleteElement.getElementsByClassName('tokenInput').item(0);
            let textMessage = modalOfDeleteElement.getElementsByClassName('textMessage').item(0);
            form.attributes.getNamedItem('action').value = url;
            tokenInput.value = _token;
            textMessage.textContent = text;
            modalOfDelete.show();
        }
    });
});

/**
 * Extract the data for delete a entity or return null
 * @param e
 * @returns {null|{_token: string, url: string}}
 */
function entityDeletionData(e)
{
    if (e.attributes.getNamedItem('data-url') == null) {
        return null;
    }

    if (e.attributes.getNamedItem('data-token') == null) {
        return null;
    }

    return {
        url: e.attributes.getNamedItem('data-url').value,
        _token: e.attributes.getNamedItem('data-token').value,
        text: e.attributes.getNamedItem('data-text') != null ? e.attributes.getNamedItem('data-text').value : ''
    };
}

