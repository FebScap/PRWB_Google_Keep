<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My notes - Créer une nouvelle note</title>
        <?php include('head.html'); ?>
        <script>
            let title, errorTitle, content, errorContent, saveButton;

            document.onreadystatechange = function() {
                if (document.readyState === 'complete') {
                    title = $("#title");
                    errorTitle = $("#errorTitle");
                    content = $("#content");
                    errorContent = $("#errorContent");
                    saveButton = $("#saveButton");
                }
            };

            function checkTitle() {
                let ok = true;
                errorTitle.html("");
                if (!(/^.{3,25}$/).test(title.val())) {
                    errorTitle.append("<p>Title length must be between 3 and 25.</p>");
                    title.addClass("is-invalid");
                    ok = false;
                } else {
                    title.removeClass("is-invalid");
                }
                return ok;
            }

            async function checkTitleUnicity() {
                let ok = true;
                errorTitle.html("");
                const titleValue = title.val();
                
                try {
                    const response = await $.ajax({
                        url: "addtextnote/check_title_unicity_service",
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ title: titleValue }),
                        dataType: "json"
                    });

                    if (!response) {
                        errorTitle.append("<p>Title must be unique per user.</p>");
                        title.addClass("is-invalid");
                        ok = false;
                    } else {
                        title.removeClass("is-invalid");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    // Gérer les erreurs en conséquence
                    ok = false;
                }

                return ok;
            }


            function checkContent() {
                let ok = true;
                errorContent.html("");
                let contentValue = content.val().trim();

                if (!(contentValue.length >= 3 || contentValue === "")) {
                    errorContent.append("<p>Content must be empty or contain at least 3 characters.</p>");
                    content.addClass("is-invalid");
                    ok = false;
                } else {
                    content.removeClass("is-invalid");
                }
                return ok;
            }

            async function checkAll() {
                let titleValid = checkTitle();
                if (!titleValid) {
                    saveButton.prop('disabled', true);
                    return false;
                }
                let titleUnique = await checkTitleUnicity();
                let contentValid = checkContent();
                let ok = titleValid && titleUnique && contentValid;
                saveButton.prop('disabled', !ok);
                return ok;
            }

        </script>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" action="addTextNote" method="post" oninput='checkAll();'>
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <button id="saveButton" type="submit" class="btn" disabled><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="<?= $title ?>">
                <label class="errors" id="errorTitle"></label>
                <?php if (count($errors) != 0): ?>
                    <div class='errors'>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-3">
                <label for="noteContent" class="form-label">Text</label>
                <label class="errors" id="errorContent"></label>
                <input id="content" name="content" type="text" style="height:600px" placeholder="Write something here" class="form-control" value="<?= $content ?>">
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html>
