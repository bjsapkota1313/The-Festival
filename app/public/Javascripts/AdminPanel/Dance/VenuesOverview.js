async function deleteButtonClicked(venueId) {
    if (await displayModalForDelete()) {
        deleteVenueRequest(venueId);
    }
}
function deleteVenueRequest(venueId) {
    fetch('http://localhost/api/danceApi/venues?id=' + venueId, {
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