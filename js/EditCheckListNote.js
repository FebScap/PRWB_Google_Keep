let title, initialTitle, errorTitle, saveButton, backButton;
let initialContent;
let addButton;

document.onreadystatechange = function() {
    if(document.readyState === 'complete') {
        title = document.getElementById("title");
        initialTitle = title.value;
        errorTitle = document.getElementById("errorTitle");
        
        saveButton = document.getElementById("saveButton");
        backButton = document.getElementById("backButton");

        createFormAdd();
        
        initialContent = getContentValues();

        backButton.addEventListener("click", (event) => {
            if (hasChanges()) {
                event.preventDefault();
                $('#confirmationModal').modal('show');
            }
        });

        document.getElementById("confirmLeave").addEventListener("click", () => {
            window.location.href = backButton.href;
        });
    }
};

function createFormAdd() {
    newItemDiv = document.getElementById("newItemDiv");
    newItemDiv.innerHTML += "<div class='input-group flex-nowrap mt-2'><input id='additem' name='itemtitle' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'><button id='addbutton' class='btn btn-primary text-white' type='submit' name='id' value='<?= $textnote->getId() ?>'><i class='bi bi-plus-lg'></i></button></div>";
    addButton = document.getElementById("addbutton");
}

function getContentValues() {
    const contentElements = document.querySelectorAll('[name^="content"]');
    return Array.from(contentElements).map(element => element.value);
}

function hasChanges() {
    const currentContent = getContentValues();
    return title.value !== initialTitle || !arraysEqual(initialContent, currentContent);
}

function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;
    for (let i = 0; i < arr1.length; i++) {
        if (arr1[i] !== arr2[i]) return false;
    }
    return true;
}

function checkTitle() {
    let ok = true;
    errorTitle.innerHTML = "";
    if (!(/^.{3,25}$/).test(title.value)) {
        errorTitle.innerHTML += "<p>Title length must be between 3 and 25.</p>";
        title.classList.add("is-invalid");
        ok = false;
    } else {
        title.classList.remove("is-invalid");
    }
    return ok;
}

function checkContent() {
    let ok = true;

    const contentElements = document.querySelectorAll('[name^="content"]');

    for (let i = 0; i < contentElements.length; i++) {
        const element = contentElements[i];
        
        //Suppression des anciennes erreurs
        if (element.parentElement.nextElementSibling.tagName == 'LI') {
            element.parentElement.nextElementSibling.remove();
        }

        var isUnique = true;
        for (let j = 0; j < contentElements.length; j++) {
            const other = contentElements[j].value;
            if (other != '' && other == element.value && j != i) {
                isUnique = false;
            }
        }

        if (!(/^.{1,60}$/).test(element.value)) {
            element.parentElement.insertAdjacentHTML("afterend", "<li class='ms-2 text-danger error'>Item length must be between 1 and 60.</li>");
            element.classList.add("is-invalid");
            ok = false;
        } else if (!isUnique) {
            element.parentElement.insertAdjacentHTML("afterend", "<li class='ms-2 text-danger error'>Item must be unique.</li>");
            element.classList.add("is-invalid");
            ok = false;
        } else {
            element.classList.remove("is-invalid");
        }

    }
    return ok;
}

function checkAll() {
    let ok = checkTitle() && checkContent();
    saveButton.disabled = !ok; // Désactiver le bouton si ok est faux
    return ok;
}