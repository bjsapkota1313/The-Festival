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
            return response.json();
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
    // Create the container element
    const container = document.createElement('div');
    container.classList.add('d-inline-flex');

// Create the form element
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/manageUsers/editUser';

// Create the hidden input element
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'hiddenUserId';
    hiddenInput.id = 'hiddenUserId';
    hiddenInput.value = user.id;

// Create the edit button element
    const editButton = document.createElement('button');
    editButton.name = 'btnEditUser';
    editButton.classList.add('btn', 'btn-primary');
    editButton.innerHTML = '<i class="fa-solid fa-file-pen"></i>';

// Add the hidden input and edit button to the form
    form.appendChild(hiddenInput);
    form.appendChild(editButton);

// Create the delete button element
    const deleteButton = document.createElement('button');
    deleteButton.classList.add('btn', 'btn-danger', 'ms-2');
    deleteButton.addEventListener('click', function () {
        btnDeleteUserClicked(user.id);
    });
    deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';

// Add the form and delete button to the container
    container.appendChild(form);
    container.appendChild(deleteButton);
    td8.appendChild(container);


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
            return response.json();
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

function btnDeleteUserClicked(id) {
    const confirmation = confirm("Are you sure you want to delete this user?");
    if (confirmation) {
        let sortingCondition = document.getElementById('filter-select').value;
        data = {'userID': id, 'SortingCondition': sortingCondition};
        fetch('http://localhost/api/ManageUsers/deleteUser', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error(response.status + ' ' + response.statusText);
            }
            return response.json();
        }).then(data => {
            if (data.Success) {
                clearTableRow();
                // Update user interface with updated user list
                let users = JSON.parse(data.users);
                if (users && Object.keys(users).length !== 0) {
                    users.forEach(function (user) {
                        makeTableBody(user);
                    })
                } else {
                    noSearchResultFoundForSearch();
                }
            } else {
                // Handle unsuccessful response
                console.error(data.message);
            }
        })
    }
}
function onChangePasswordBox(){
    document.getElementById('password-fields').classList.toggle('d-none');
}