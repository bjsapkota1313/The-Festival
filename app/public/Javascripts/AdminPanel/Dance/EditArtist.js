function btnSaveChangesClicked(artistId)
{
    let artistName = document.getElementById("artistName").value;
    let artistDescription = document.getElementById("artistDescription").value;
    let artistLogo= document.getElementById("artistLogo").files[0];
    let selectedArtistStyles=getArtistStyles();

}
function getArtistStyles()
{
    let selectedStyleIds = [];
    let styleCheckboxes  = document.querySelectorAll('.artist-style-checkbox');
    styleCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            selectedStyleIds.push(checkbox.value);
        }
    });
    return selectedStyleIds;
}