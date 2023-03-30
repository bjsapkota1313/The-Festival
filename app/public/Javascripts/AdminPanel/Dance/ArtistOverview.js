async function deleteButtonClicked(artistId) {
    if (await displayModalForDelete()) {
        deleteArtistRequest(artistId);
    }
}
function deleteArtistRequest(artistId) {
    fetch('http://localhost/api/danceApi/artists?id=' + artistId, {
        method: 'DELETE'
    }).then(response => {
        response.json().then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert("Error: " + data.message);
            }
        });
    });
}