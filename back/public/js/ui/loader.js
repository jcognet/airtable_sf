export function showLoader(divId) {
    const loader = document.getElementById('loader');
    const parent = document.getElementById(divId);
    loader.classList.add("loader_show");
    parent.classList.add("loader_content_hide");
    const rect = parent.getBoundingClientRect();
    loader.style.top = (rect.y + parent.scrollTop ) + 'px';
    loader.style.left = (rect.x + parent.offsetLeft) + 'px';
}

export function hideLoader(divId) {
    const loader = document.getElementById('loader');
    const parent = document.getElementById(divId);
    loader.classList.remove("loader_show");
    parent.classList.remove("loader_content_hide");
    loader.style.top = 0;
    loader.style.left = 0;
}
