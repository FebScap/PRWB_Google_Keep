<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle note</title>
        <?php include('head.html'); ?>
        <script>
            let title, errorTitle, content, errorContent, saveButton;

            document.onreadystatechange = function(){
                if(document.readyState === 'complete') {
                    title = document.getElementById("title");
                    errorTitle = document.getElementById("errorTitle");
                    content = document.getElementById("content");
                    errorContent = document.getElementById("errorContent");
                    saveButton = document.getElementById("saveButton");
                }
            };

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
        <form class="container-fluid d-flex flex-column" action="addTextNote" method="post" oninput='return checkAll();'>
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <button id="saveButton" type="submit" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="<?= $title ?>" oninput='checkTitle();'>
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
                <input id="content" name="content" type="text" style="height:600px" placeholder="Write something here" class="form-control" id="noteContent" value="<?= $content ?>" oninput='CheckContent();'>
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html>
