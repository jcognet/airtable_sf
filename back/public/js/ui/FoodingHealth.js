import {fetchData} from "../data/FoodingHealth.js";
import {hideLoader, showLoader} from "./loader.js";


export async function addMonthNavigation() {
    const navigationLinks = document.getElementsByClassName('lnk_month_navigation');

    if (navigationLinks) {
        for (let link of navigationLinks) {
            link.addEventListener('click', (e) => onLinkClicked(e, link));
        }
    }
}

async function onLinkClicked(e, link) {
    e.preventDefault();
    showLoader('container_data');
    document.getElementById('content').innerHTML = await fetchData(link.href);
    addMonthNavigation(); // Links are in the content created by the server
    hideLoader('container_data');
}
