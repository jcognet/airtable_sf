export async function fetchImportedData(keyword) {
    const addOnUrl = 'fetch=true';
    const paramRoute = window.location.href.includes('?') ? '&' : '?';
    const filter = window.location.href.includes('&filter=') ? '' : `&filter=${keyword}`;
    const fetchUrl = window.location.href + paramRoute + addOnUrl + filter;
    const response = await fetch(fetchUrl);

    if (!response.ok) {
        throw new Error('Error while fetching: ' + fetchUrl + ' (code: ' + response.status + ')');
    }

    return (await response).text();
}
