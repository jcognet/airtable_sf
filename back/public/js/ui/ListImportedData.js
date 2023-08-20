import {fetchImportedData} from "../data/ListImportedData.js";

export async function addListImportedDataEvent() {
    const form = document.getElementById('frmResearch');

    if (form) {
        form.addEventListener('submit', onFrmResearchSubmit);
    }
}

function onFrmResearchSubmit(e) {
    disableForm();
    filterData(document.getElementById('inputKeyword').value);
    e.preventDefault();
}

async function filterData(keyword) {
    const html = await fetchImportedData(keyword);
    document.getElementById('list_imported_data').innerHTML = html;
    document.getElementById('span_nb_imported_data').innerText = (html.split('<tr>').length - 2);
    enableForm();
}

function enableForm() {
    enableDisableForm(false);
}

function disableForm() {
    enableDisableForm(true);
}

function enableDisableForm(disable) {
    const form = document.getElementById('frmResearch');

    for (let input of form.getElementsByTagName('input')) {
        input.disabled = disable;
    }

    for (let button of form.getElementsByTagName('button')) {
        button.disabled = disable;
    }
}
