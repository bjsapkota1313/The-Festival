function onInputChange(input) {
    let searchInput = input.value;
    let uri = "http://localhost/api/ManageUsers/searchUsers?SearchTerm=" + searchInput;
    let searchSortingCondition = getSortingConditionForSearch();
    if (searchSortingCondition !== null) {
        uri = "http://localhost/api/ManageUsers/searchUsers?SearchTerm=" + searchInput + "&sortSelectedOption=" + searchSortingCondition;
    }
    fetch(uri)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status + ' ' + response.statusText);
            }
           return  response.json();
        })
        .then(users => {
            clearTableRow();
            if (users && Object.keys(users).length !== 0) {
                users.forEach(user => {
                    makeTableBody(user);
                })
            } else {
                noSearchResultFoundForSearch();
            }
        }).catch(error => {
            console.log(error);
        });
}

function clearTableRow() {
 document.getElementById('tableDataDisplay').innerHTML = '';
}

function getSortingConditionForSearch() {
    let sortSelectedOption = document.getElementById('filter-select').value;
    if (sortSelectedOption === 'Employee' || sortSelectedOption === 'Administrator' || sortSelectedOption === 'Customer') {
        return sortSelectedOption;
    }
    return null;
}

function noSearchResultFoundForSearch() {
    const tbody = document.getElementById('tableDataDisplay');
    const tr = document.createElement('tr');
    const td = document.createElement('td');
    td.textContent = 'No results found';
    td.colSpan = 8;
    tr.appendChild(td);
    tbody.appendChild(tr);
}

function makeTableBody(user) {
    const tbody = document.getElementById('tableDataDisplay');
    const tr = document.createElement('tr');
    const td1 = document.createElement('td');
    const img = document.createElement('img');
    img.src = user.picture;
    img.alt = 'Profile Picture';
    img.classList.add('round-image');
    td1.appendChild(img);
    tr.appendChild(td1);

    const td2 = document.createElement('td');
    td2.textContent = user.firstName;
    tr.appendChild(td2);

    const td3 = document.createElement('td');
    td3.textContent = user.lastName;
    tr.appendChild(td3);

    const td4 = document.createElement('td');
    td4.textContent = user.email;
    tr.appendChild(td4);

    const td5 = document.createElement('td');
    td5.textContent = user.role;
    tr.appendChild(td5);

    const td6 = document.createElement('td');
    td6.textContent = getFormattedDate(user.dateOfBirth);
    tr.appendChild(td6);

    const td7 = document.createElement('td');
    td7.textContent = getFormattedDate(user.registrationDate);
    tr.appendChild(td7);

    const td8 = document.createElement('td');
    const editLink = document.createElement('a');
    editLink.href = `editUser.php?id=${user.id}`;
    editLink.classList.add('btn', 'btn-primary');
    const editIcon = document.createElement('i');
    editIcon.classList.add('fa-solid', 'fa-file-pen');
    editLink.appendChild(editIcon);
    td8.appendChild(editLink);

    const deleteLink = document.createElement('a');
    deleteLink.href = `deleteUser.php?id=${user.id}`;
    deleteLink.classList.add('btn', 'btn-danger');
    const deleteIcon = document.createElement('i');
    deleteIcon.classList.add('fa-solid', 'fa-trash');
    deleteLink.appendChild(deleteIcon);
    td8.appendChild(deleteLink);

    tr.appendChild(td8);
    tbody.appendChild(tr);

}

function getFormattedDate(dateObj) {
    const date = new Date(dateObj.date);
    return date.toLocaleDateString('en-GB', {day: '2-digit', month: '2-digit', year: 'numeric'}).replace(/\//g, '-');
}

function sortValueChanged(selectElement) {
    let selectedOption = selectElement.value;
    fetch("http://localhost/api/ManageUsers/sortUsers?selectedOption=" + selectedOption)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status + ' ' + response.statusText);
            }
            return  response.json();
        })
        .then(users => {
            clearTableRow()
            if (users && Object.keys(users).length !== 0) {
                users.forEach(user => {
                    makeTableBody(user);
                })
            } else {
                noSearchResultFoundForSearch();
            }
        }).catch(error => {
            console.log(error);
        });
}
function editUserButtonClicked(){

}