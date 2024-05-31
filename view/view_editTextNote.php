<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My notes - Editer une note</title>
        <?php include('head.html'); ?>
        <script>
            let title, initialTitle, errorTitle, content, initialContent, errorContent, saveButton, backButton;

            document.onreadystatechange = function(){
                if(document.readyState === 'complete') {
                    title = $("#title");
                    initialTitle = title.val();
                    errorTitle = $("#errorTitle");

                    content = $("#content");
                    initialContent = content.val();
                    errorContent = $("#errorContent");

                    saveButton = $("#saveButton");
                    backButton = $("#backButton");

                    backButton.on("click", function(event) {
                        if (hasChanges()) {
                            event.preventDefault();
                            $('#confirmationModal').modal('show');
                        }
                    });

                    $("#confirmLeave").on("click", function() {
                        window.location.href = backButton.attr("href");
                    });
                }
            };

            function hasChanges() {
                return title.val() !== initialTitle || content.val() !== initialContent;
            }

            function checkTitle(){
                let ok = true;
                errorTitle.html("");
                if (!(/^.{3,25}$/).test(title.val())) {
                    errorTitle.append("<p class='text-danger'>Title length must be between 3 and 25.</p>");
                    title.addClass("is-invalid");
                    ok = false;
                } else {
                    title.removeClass("is-invalid");
                    title.addClass("is-valid");
                }
                return ok;
            }

            async function checkTitleUnicity() {
                let ok = true;
                errorTitle.html("");
                const titleValue = title.val();
                
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
                        errorTitle.append("<p class='text-danger'>Title must be unique per user.</p>");
                        title.addClass("is-invalid");
                        ok = false;
                    } else {
                        title.removeClass("is-invalid");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    ok = false;
                }

                return ok;
            }

            function CheckContent(){
                let ok = true;
                errorContent.html("");
                let contentValue = content.val().trim();

                if (!(contentValue.length >= 3 || contentValue === "")) {
                    errorContent.append("<p class='text-danger'>Content must be empty or contain at least 3 characters.</p>");
                    content.addClass("is-invalid");
                    ok = false;
                } else {
                    content.removeClass("is-invalid");
                }
                return ok;
            }

            async function checkAll(){
                let titleValid = checkTitle();
                if (!titleValid) {
                    saveButton.prop('disabled', true);
                    return false;
                }
                let titleUnique = await checkTitleUnicity();
                let contentValid = CheckContent();
                let ok = titleValid && titleUnique && contentValid;
                saveButton.prop('disabled', !ok);
                return ok;
            }
        </script>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" action="OpenNote/saveNote" method="post" oninput="checkAll();">
            <div class="container-fluid d-flex justify-content-between">
                <a id="backButton" class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                <button type="submit" class="btn" id="saveButton" disabled><i class="bi bi-floppy"></i></button>
            </div>
            <div class="m-3">
                <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
                <?php if (!is_null($textnote->getEditedAt())) : ?>
                    <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
                <?php endif ?>
                <label for="noteTitle" class="form-label">Title</label>
                <label class="errors" id="errorTitle"></label>
                <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="<?= $textnote->getTitle() ?>">
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
                <textarea id="content" name="content" oninput="checkContent();" class="form-control bg-dark text-start" style="height: 550px" rows="8"><?= $textnote->getContent() ?></textarea>
            </div>
            <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" value="<?= $textnote->getId() ?>">
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
