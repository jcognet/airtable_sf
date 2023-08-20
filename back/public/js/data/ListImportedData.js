export async function fetchImportedData(keyword) {
    const addOnUrl = 'table=true';
    const paramRoute = window.location.href.includes('?') ? '&' : '?';
    const filter = window.location.href.includes('&filter=') ? '' : `&filter=${keyword}`;
    const fetchUrl = window.location.href + paramRoute + addOnUrl + filter;
    const response = await fetch(fetchUrl);

    return (await response).text();
}
