export async function fetchData(url) {
    const fetchUrl = url+'&fetch=true';
    const response = await fetch(fetchUrl);

    if (!response.ok) {
        throw new Error('Error while fetching: ' + fetchUrl + ' (code: ' + response.status + ')');
    }

    return (await response).text();
}
