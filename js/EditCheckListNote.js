let title, initialTitle, errorTitle, saveButton, backButton;
let initialContent;

document.onreadystatechange = function() {
    if(document.readyState === 'complete') {
        title = document.getElementById("title");
        initialTitle = title.value;
        errorTitle = document.getElementById("errorTitle");
        
        saveButton = document.getElementById("saveButton");
        backButton = document.getElementById("backButton");
        
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

function checkAll() {
    let ok = checkTitle();
    saveButton.disabled = !ok; // Désactiver le bouton si ok est faux
    return ok;
}