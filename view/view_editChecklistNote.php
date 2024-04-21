<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Editer une ChecklistNote</title>
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

            function checkAll(){

                let ok = checkTitle();

                saveButton.disabled = !ok; // Désactiver le bouton si ok est faux

                return ok;

                }

        </script>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" method="post" action="OpenNote/saveChecklistNote" id="save" oninput='return checkAll();'>
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                <button  id="saveButton" type="submit" form="save" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
                <?php if (!is_null($textnote->getEditedAt())) : ?>
                    <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
                <?php endif ?>
                <label for="noteTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $textnote->getTitle() ?>" oninput="checkTitle();">
                <label class="errors" id="errorTitle"></label>
                <?php if (count($errorsTitle) != 0) : ?>
                    <label for="noteTitle" class="form-label">
                        <?php foreach ($errorsTitle as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?></label>
                <?php endif ?>
            </div>
            <div class="mt-3">
                <label class="form-label">Items</label>
                <ul>
                    <?php for ($i=0; $i<count($itemList); $i++) {
                        echo"
                        <li class='mb-2'>
                        <div class='container-fluid input-group flex-nowrap p-0'>
                            <input type='text' class='form-control' id='checklist' name='content[$i]' value='" . $itemList[$i]->getContent() . "'>
                            <form method='post' action='OpenNote/deleteItem' id='formdelete'>
                                <button type='submit' form='formdelete' name='itemid' value='" . $itemList[$i]->getId() . "' class='btn btn-danger'><i class='bi bi-dash-square-fill'></i></button>
                            </form>
                        </div>
                        </li>";
                    }
                    ?>
                    <?php if (count($errorsContent) != 0) : ?>
                        <label for="noteTitle" class="form-label">
                            <?php foreach ($errorsContent as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </label>
                    <?php endif ?>
                </ul>
                <form method='post' action='OpenNote/addItem' id='formadd'>
                    <button type='submit' form='formadd' name='id' value='<?= $textnote->getId() ?>' class='btn btn-primary'><i class="bi bi-plus-square"></i></button>
                </form>
            </div>
            <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" form="save" value="<?= $textnote->getId() ?>">
        </form>
        <?php include('footer.html'); ?>
    </body>
</html>
