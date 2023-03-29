function displayModalForDelete(){
// Create the modal
    let modal = document.createElement("div");
    modal.classList.add("modal", "fade");
    modal.id = "myModal";
    modal.setAttribute("tabindex", "-1");
    modal.setAttribute("role", "dialog");
    modal.setAttribute("aria-labelledby", "myModalLabel");
    modal.setAttribute("aria-hidden", "true");
    document.body.appendChild(modal);

// Create the modal dialog
    let modalDialog = document.createElement("div");
    modalDialog.classList.add("modal-dialog");
    modalDialog.setAttribute("role", "document");
    modal.appendChild(modalDialog);

// Create the modal content
    let modalContent = document.createElement("div");
    modalContent.classList.add("modal-content");
    modalDialog.appendChild(modalContent);

// Create the modal header
    let modalHeader = document.createElement("div");
    modalHeader.classList.add("modal-header");
    modalContent.appendChild(modalHeader);

// Create the modal title
    let modalTitle = document.createElement("h5");
    modalTitle.classList.add("modal-title");
    modalTitle.innerText = "Confirmation";
    modalTitle.id = "myModalLabel";
    modalHeader.appendChild(modalTitle);

// Create the modal close button
    let modalCloseBtn = document.createElement("button");
    modalCloseBtn.type = "button";
    modalCloseBtn.classList.add("btn-close");
    modalCloseBtn.setAttribute("data-bs-dismiss", "modal");
    modalCloseBtn.setAttribute("aria-label", "Close");
    modalHeader.appendChild(modalCloseBtn);

// Create the modal body
    let modalBody = document.createElement("div");
    modalBody.classList.add("modal-body");
    modalBody.innerText = 'Are you sure you want to Delete??';
    modalContent.appendChild(modalBody);

// Create the modal footer
    let modalFooter = document.createElement("div");
    modalFooter.classList.add("modal-footer");
    modalContent.appendChild(modalFooter);

// Create the modal close button
    let modalCloseBtn2 = document.createElement("button");
    modalCloseBtn2.type = "button";
    modalCloseBtn2.classList.add("btn", "btn-secondary");
    modalCloseBtn2.innerText = 'No';
    modalCloseBtn2.setAttribute("data-bs-dismiss", "modal");
    modalFooter.appendChild(modalCloseBtn2);

    let modalYesBtn = document.createElement("button");
    modalYesBtn.type = "button";
    modalYesBtn.classList.add("btn", "btn-danger");
    modalYesBtn.innerText = 'Yes';
    modalFooter.appendChild(modalYesBtn);
    modalYesBtn.addEventListener("click", function() {
        modalCloseBtn.click(); // first closing the modal
        return true;
    });

    let modalBtn = document.createElement("button");
    modalBtn.type = "button";
    modalBtn.hidden=true;
    modalBtn.setAttribute("data-bs-toggle", "modal");
    modalBtn.setAttribute("data-bs-target", "#myModal");
    document.body.appendChild(modalBtn);
    modalBtn.click();
}
export { displayModalForDelete };