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
        <form method="post" action="OpenNote/saveChecklistNote" id="save" oninput='return checkAll();'></form>
        <div class="container-fluid d-flex flex-column"> 
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                <button  id="saveButton" type="submit" form="save" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
                <?php if (!is_null($textnote->getEditedAt())) : ?>
                    <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
                <?php endif ?>
                <label for="noteTitle" class="form-label h2 fs-5 mt-4 ms-2">Title</label>
                <input type="text" class="form-control" id="title" form="save" name="title" value="<?= $textnote->getTitle() ?>" oninput="checkTitle();">
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
                        echo"<div class='input-group flex-nowrap mt-2'>";

                        if ( $itemList[$i]->getChecked() == 1) {
                            echo"<button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-check-square'></i></button>";
                        } else {
                            echo"<button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-square'></i></button>";
                        }
                            echo"
                                <input id='checklist'  form='save' name='content[$i]' type='text' class='form-control' value='" . $itemList[$i]->getContent() . "' placeholder='Nouvel item' aria-describedby='basic-addon1'>
                                <form class='m-0 p-0 btn btn-danger text-white' method='post' action='OpenNote/deleteItem' id='formdelete'>
                                    <button class='btn btn-danger text-white' type='submit' form='formdelete' name='itemid' value='" . $itemList[$i]->getId() . "'><i class='bi bi-dash-lg' form='formdelete'></i></button>
                                </form>
                                </div>
                            ";
                    }
                    ?>  

                <h2 class="h2 fs-5 mt-4 ms-2">New Item</h2>
                <form class='input-group flex-nowrap mt-2' method='post' action='OpenNote/addItem' id='formadd'>
                    <?php if (isset($itemtitle)) : ?>
                        <input id='additem' name='itemtitle' value="<?= $itemtitle ?>" form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                    <?php else : ?>
                        <input id='additem' name='itemtitle' form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                    <?php endif ?>
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
        </div>
        <?php include('footer.html'); ?>
    </body>
</html>
