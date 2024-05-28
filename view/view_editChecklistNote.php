<!DOCTYPE html>
<html>
<head>
    <title>My notes - Editer une ChecklistNote</title>
    <?php include('head.html'); ?>

    <script>
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
    </script>
</head>
<body data-bs-theme="dark">
    <form class="container-fluid d-flex flex-column" method="post" action="OpenNote/saveChecklistNote" id="save" oninput='return checkAll();'>
        <div class="container-fluid d-flex justify-content-between">
            <a id="backButton" class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
            <button id="saveButton" type="submit" form="save" class="btn"><i class="bi bi-floppy"></i></button>
        </div>
        <div class="mt-3">
            <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
            <?php if (!is_null($textnote->getEditedAt())) : ?>
                <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
            <?php endif ?>
            <label for="noteTitle" class="form-label h2 fs-5 mt-4 ms-2">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $textnote->getTitle() ?>" oninput="checkTitle();">
            <label class="errors" id="errorTitle"></label>
            <?php if (count($errorsTitle) != 0) : ?>
                <label for="noteTitle" class="form-label">
                    <?php foreach ($errorsTitle as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?></label>
            <?php endif ?>
        </div>
        <div>
            <h2 class="h2 fs-5 ms-2">Items</h2>

            <?php for ($i=0; $i<count($itemList); $i++) {
                echo"
                <div class='input-group flex-nowrap mt-2'>
                    <button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-square'></i></button>
                    <input id='checklist' name='content[$i]' type='text' class='form-control' value='" . $itemList[$i]->getContent() . "' placeholder='Nouvel item' aria-describedby='basic-addon1'>
                    <form class='m-0 p-0 btn btn-danger text-white' method='post' action='OpenNote/deleteItem' id='formdelete'>
                        <button class='btn btn-danger text-white' type='submit' form='formdelete' name='itemid' value='" . $itemList[$i]->getId() . "'><i class='bi bi-dash-lg' form='formdelete'></i></button>
                    </form>
                </div>";
            }
            ?>  

            <h2 class="h2 fs-5 mt-4 ms-2">New Item</h2>
            <form class='input-group flex-nowrap mt-2' method='post' action='OpenNote/addItem' id='formadd'>
                <input id='additem' name='itemtitle' form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                <button class='btn btn-primary text-white' type='submit' form='formadd' name='id' value='<?= $textnote->getId() ?>'><i class="bi bi-plus-lg"></i></button>
            </form>

            <?php if (count($errorsContent) != 0) : ?>
                <label for="noteTitle" class="form-label">
                    <ul class="mt-1">
                        <?php foreach ($errorsContent as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </label>
            <?php endif ?>
        </div>
        <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" form="save" value="<?= $textnote->getId() ?>">
    </form>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Unsaved Changes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You have unsaved changes. Are you sure you want to leave this page without saving?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmLeave">Leave</button>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.html'); ?>
</body>
</html>
