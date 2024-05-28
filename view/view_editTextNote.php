<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Editer une note</title>
        <?php include('head.html'); ?>

        <script>
            let title, initialTitle, errorTitle, content, initialContent, errorContent, saveButton, backButton;

            document.onreadystatechange = function(){
                if(document.readyState === 'complete') {
                    title = document.getElementById("title");
                    initialTitle = title.value;
                    errorTitle = document.getElementById("errorTitle");

                    content = document.getElementById("content");
                    initialContent = content.value;
                    errorContent = document.getElementById("errorContent");

                    saveButton = document.getElementById("saveButton");
                    backButton = document.getElementById("backButton");

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

            function hasChanges() {
                return title.value !== initialTitle || content.value !== initialContent;
            }

            function checkTitle(){
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

            function CheckContent(){
                let ok = true;
                errorContent.innerHTML = "";
                let contentValue = content.value.trim(); // Supprimer les espaces inutiles

                if (!(contentValue.length >= 3 || contentValue === "")) {
                    errorContent.innerHTML += "<p>Content must be empty or contain at least 3 characters.</p>";
                    content.classList.add("is-invalid");
                    ok = false;
                } else {
                    content.classList.remove("is-invalid");
                }
                return ok;
            }

            function checkAll(){
                let ok = checkTitle() && CheckContent();
                saveButton.disabled = !ok; // Désactiver le bouton si ok est faux
                return ok;
            }
        </script>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" action="OpenNote/saveNote" method="post" oninput='return checkAll();'>
            <div class="container-fluid d-flex justify-content-between">
                <a id="backButton" class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                <button type="submit" class="btn" id="saveButton"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="m-3">
                <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
                <?php if (!is_null($textnote->getEditedAt())) : ?>
                    <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
                <?php endif ?>
                <label for="noteTitle" class="form-label">Title</label>
                <label class="errors" id="errorTitle"></label>
                <input id="title" name="title" type="text" class="form-control" placeholder="Title" aria-describedby="emailHelp" value="<?= $textnote->getTitle() ?>" oninput='checkTitle();'>
                <?php if (count($errors) != 0): ?>
                        <div class='errors'>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                <?php endif; ?>
                <label class="form-label mt-3">Text</label>
                <label class="errors" id="errorContent"></label>
                <textarea id="content" name="content" class="form-control w-100 bg-dark text-start" rows="8" oninput="CheckContent();"><?= $textnote->getContent() ?></textarea>
            </div>
            <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" aria-describedby="emailHelp" value="<?= $textnote->getId() ?>">
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
