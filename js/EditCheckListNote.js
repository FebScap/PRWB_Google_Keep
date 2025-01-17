let title, initialTitle, errorTitle, saveButton, backButton, initialContent, addButton;

        document.onreadystatechange = function() {
            if (document.readyState === 'complete') {
                title = document.getElementById("title");
                initialTitle = title.value;
                errorTitle = document.getElementById("errorTitle");
                
                saveButton = document.getElementById("saveButton");
                backButton = document.getElementById("backButton");
                addButton = document.getElementById('addbutton');

                createFormAdd();
                
                saveContent = getContentValues();
                initialContent = getContentValues();
                initialContent.pop();

                // FONCTIONNALITE DELETEITEM
                let itemDiv = document.getElementById('itemDiv');
                itemDiv.addEventListener("click", (event) => {
                    let isDeleted = false;
                    let button;
                    if (event.target.nodeName === 'BUTTON') {
                        button = event.target;
                        event.target.parentElement.parentElement.remove();
                        isDeleted = true;
                    } else if (event.target.parentElement.nodeName === 'BUTTON') {
                        button = event.target.parentElement;
                        event.target.parentElement.parentElement.parentElement.remove();
                        isDeleted = true;
                    }

                    if (isDeleted) {
                        $.ajax({
                            type: "POST",
                            url: "OpenNote/deleteItemRaw",
                            data: {
                                itemid: button.value
                            },
                            success: function (data) {
                                initialContent = initialContent.filter(e => e !== button.parentElement.children[1].value);
                                console.log("Removed " + data + " to database with title : '" + button.parentElement.children[1].value + "'");
                            }
                        });
                    }
                });       

                // FONCTIONNALITE ADDITEM
                addButton.addEventListener("click", () => {
                    let itemToAdd = document.getElementById('addinput');
                    if ((/^.{1,60}$/).test(itemToAdd.value)) {
                        const contentElements = document.querySelectorAll('[name^="content"]');
                        let dontExist = true;
                      
                        contentElements.forEach(element => {
                            if (element.value == itemToAdd.value && element.id != 'addinput') {
                                dontExist = false;
                            }
                        });

                        if (dontExist) {
                            $.ajax({
                                type: "POST",
                                url: "OpenNote/addItemRaw",
                                data: {
                                    noteId: document.body.id,
                                    value: itemToAdd.value
                                },
                                success: function (data) {
                                    itemDiv.insertAdjacentHTML("beforeend", "<div><div class='input-group flex-nowrap mt-2'><button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-square'></i></button><input id='checklist' oninput='checkAll();' form='save' name='content[" + data + "]' type='text' class='form-control' value='" + itemToAdd.value + "' placeholder='Nouvel item' ><button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' name='itemid' value='" + data + "'><i class='bi bi-dash-lg' form='formdelete'></i></button></div></div>");
                                    itemToAdd.classList.remove("is-valid");
                                    console.log("Added " + data + " to database with title : '" + itemToAdd.value + "'");
                                    initialContent.push(itemToAdd.value);
                                    itemToAdd.value = '';
                                }
                            });
                        }
                    }
                });

                // BOUTON RETOUR VERIFICATION SI LE FICHIER EST MODIF
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
            newItemDiv.innerHTML += "<div class='input-group flex-nowrap mt-2'><input id='addinput' oninput='checkAll();' name='content[itemtitle]' type='text' class='form-control' placeholder='Item title' ><button id='addbutton' class='btn btn-primary text-white' type='submit' name='id' value='<?= $textnote->getId() ?>'><i class='bi bi-plus-lg'></i></button></div>";
            newItemDiv.innerHTML += "<span></span>"
            addButton = document.getElementById("addbutton");
        }

        function getContentValues() {
            const contentElements = document.querySelectorAll('[name^="content"]');
            return Array.from(contentElements).map(element => element.value);
        }

        function hasChanges() {
            const currentContent = getContentValues();
            return title.value !== initialTitle || !arraysEqual(saveContent, currentContent);
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
                title.classList.remove("is-valid");
                title.classList.add("is-invalid");
                ok = false;
            } else {
                title.classList.add("is-valid");
                title.classList.remove("is-invalid");
            }
            return ok;
        }

        async function checkTitleUnicity() {
            let ok = true;
            errorTitle.innerHTML = "";
            const titleValue = title.value;

            if (titleValue === initialTitle) {
                return ok;
            }

            try {
                const response = await $.ajax({
                    url: "addtextnote/check_title_unicity_service",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ title: titleValue }),
                    dataType: "json"
                });

                if (!response) {
                    errorTitle.innerHTML += "<p>Title must be unique per user.</p>";
                    title.classList.add("is-invalid");
                    ok = false;
                } else {
                    title.classList.remove("is-invalid");
                }
            } catch (error) {
                console.error("Error:", error);
                ok = false;
            }

            return ok;
        }

        function checkContent() {
            let ok = true;

            const contentElements = document.querySelectorAll('[name^="content"]');

            for (let i = 0; i < contentElements.length; i++) {
                const element = contentElements[i];
                
                //Suppression des anciennes erreurs
                if (element.parentElement.nextElementSibling != null && element.parentElement.nextElementSibling.tagName == 'LI') {
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
                    if (element.id != 'addinput') {
                        element.parentElement.insertAdjacentHTML("afterend", "<li class='ms-2 text-danger error'>Item length must be between 1 and 60.</li>");
                        element.classList.remove("is-valid");
                        element.classList.add("is-invalid");
                        ok = false;
                    }
                } else if (!isUnique) {
                    element.parentElement.insertAdjacentHTML("afterend", "<li class='ms-2 text-danger error'>Item must be unique.</li>");
                    element.classList.remove("is-valid");
                    element.classList.add("is-invalid");
                    ok = false;
                } else {
                    element.classList.remove("is-invalid");
                    if (initialContent[i] != element.value) {
                        element.classList.add("is-valid");
                    }
                }
            }
            return ok;
        }

        async function checkAll() {
            let titleValid = checkTitle();
            if (!titleValid) {
                saveButton.disabled = true;
                return false;
            }

            let titleUnique = await checkTitleUnicity();
            if (!titleUnique) {
                saveButton.disabled = true;
                return false;
            }

            let contentValid = checkContent();
            let ok = titleValid && titleUnique && contentValid;
            saveButton.disabled = !ok;
            return ok;
        }