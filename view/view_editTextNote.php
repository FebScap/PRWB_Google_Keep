<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Editer une note</title>
        <?php include('head.html'); ?>

        <script>
            let title, errorTitle, content, errorContent;

            document.onreadystatechange = function(){
                if(document.readyState === 'complete') {
                    title = document.getElementById("title");
                    errorTitle = document.getElementById("errorTitle");
                    content = document.getElementById("content");
                    errorContent = document.getElementById("errorContent");
                }
            };

            function checkTitle(){
                let ok = true;
                errorTitle.innerHTML = "";
                if (!(/^.{3,25}$/).test(title.value)) {
                    errorTitle.innerHTML += "<p>Title length must be between 3 and 25.</p>";
                    ok = false;
                }
                return ok;
            }

            function CheckContent(){
                let ok = true;
                errorContent.innerHTML = "";
                let contentValue = content.value.trim(); // Supprimer les espaces inutiles

                if (!(contentValue.length >= 3 || contentValue === "")) {
                    errorContent.innerHTML += "<p>Content must be empty or contain at least 3 characters.</p>";
                    ok = false;
                }
                return ok;
            }

        </script>

    </head>
    <body data-bs-theme="dark">
            <form class="container-fluid d-flex flex-column" action="OpenNote/saveNote" method="post">
                <div class="container-fluid d-flex justify-content-between">
                    <a class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                    <button type="submit" class="btn"><i class="bi bi-floppy"></i></button>
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
                    <input id="content" name="content" type="text" placeholder="Write something here" class="w-100 input-field input-group-text bg-dark text-start" value="<?= $textnote->getContent() ?>" oninput='CheckContent();'>
                </div>
                <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" aria-describedby="emailHelp" value="<?= $textnote->getId() ?>">
            </form>
            <?php include('footer.html'); ?>
    </body>
</html>