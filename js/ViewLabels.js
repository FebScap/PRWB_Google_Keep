let newLabel, errorUL, addButton;

document.onreadystatechange = function() {
    if(document.readyState === 'complete') {
        newLabel = document.getElementById("addlabel");

        errorUL = document.getElementById('errorsUL');
        addButton = document.getElementById('addbutton');

        // FONCTIONNALITE DELETE LABEL
        let labelDiv = document.getElementById('labelDiv');
        labelDiv.addEventListener("click", (event) => {
            let isDeleted = false;
            let button;
            if (event.target.nodeName === 'BUTTON') {
                button = event.target;
                event.target.parentElement.remove();
                isDeleted = true;
            } else if (event.target.parentElement.nodeName === 'BUTTON') {
                button = event.target.parentElement;
                event.target.parentElement.parentElement.remove();
                isDeleted = true;
            }

            if (isDeleted) {
                $.ajax({
                    type: "POST",
                    url: "OpenNote/deleteLabelNoRedirect",
                    data: {
                        noteId: button.getAttribute('noteId'),
                        label: button.value
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        });    
        
        // FONCTIONNALITE ADD LABEL
        addButton.addEventListener("click", () => {
            if (checkLabel()) {
                $.ajax({
                    type: "POST",
                    url: "OpenNote/addLabelNoRedirect",
                    data: {
                        noteId: document.body.id,
                        label: newLabel.value
                    },
                    success: function (data) {
                        labelDiv.insertAdjacentHTML("beforeend", "<div class='input-group flex-nowrap mt-2'><input disabled id='checklist' form='formdelete' type='text' class='form-control labelname' value='" + newLabel.value + "' aria-describedby='basic-addon1'><input type='hidden' class='hidden-input' form='formdelete' name='noteId' value='" + document.body.id + "'/><button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' noteId='" + document.body.id + "' name='label' value='" + newLabel.value + "'><i class='bi bi-dash-lg'></i></button></div>");
                        newLabel.classList.remove("is-valid");
                        console.log(data);
                        newLabel.value = '';
                    }
                });
            }
        });
    }
}

function checkLabel() {
    let ok = true;
    errorUL.innerHTML = "";

    let labels = document.getElementsByClassName('labelname');
    var isUnique = true;
    for (let index = 0; index < labels.length; index++) {
        const element = labels[index];
        if (newLabel.value == element.value) isUnique = false;
    }


    if (!(/^.{2,10}$/).test(newLabel.value)) {
        errorUL.innerHTML += "<li class='text-danger'>Label length must be between 2 and 10.</li>";
        newLabel.classList.remove("is-valid");
        newLabel.classList.add("is-invalid");
        ok = false;
    } else if (!isUnique) {
        errorUL.innerHTML += "<li class='text-danger'>A note cannot contain the same label twice.</li>";
        newLabel.classList.remove("is-valid");
        newLabel.classList.add("is-invalid");
        ok = false;
    } else {
        newLabel.classList.add("is-valid");
        newLabel.classList.remove("is-invalid");
    }
    return ok;
}