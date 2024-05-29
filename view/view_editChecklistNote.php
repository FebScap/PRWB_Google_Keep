<!DOCTYPE html>
<html>
<head>
    <title>My notes - Editer une ChecklistNote</title>
    <?php include('head.html'); ?>
    <script src="js/EditCheckListNote.js"></script>
    <script src="js/RemoveNotJS.js"></script>
</head>
<body id="<?= $textnote->getId() ?>" data-bs-theme="dark">
    <form method="post" action="OpenNote/saveChecklistNote" id="save" oninput='return checkAll();'></form>
        <div class="container-fluid d-flex flex-column"> 
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
                <input type="text" class="form-control" id="title" form="save" name="title" value="<?= $textnote->getTitle() ?>" oninput="checkAll();">
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
                <form class='notJS' method='post' action='OpenNote/deleteItem' id='formdelete'></form>
                    <div id='itemDiv'>
                        <?php for ($i=0; $i<count($itemList); $i++) {
                            echo"<div><div class='input-group flex-nowrap mt-2'>";

                            if ( $itemList[$i]->getChecked() == 1) {
                                echo"<button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-check-square'></i></button>";
                            } else {
                                echo"<button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-square'></i></button>";
                            }
                                echo"
                                    <input id='checklist' oninput='checkAll();' form='save' name='content[$i]' type='text' class='form-control' value='" . $itemList[$i]->getContent() . "' placeholder='Item title' aria-describedby='basic-addon1'>
                                    <button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' name='itemid' value='" . $itemList[$i]->getId() . "'><i class='bi bi-dash-lg' form='formdelete'></i></button>
                                    </div></div>
                                ";
                        }
                        ?>  
            </div>

                <h2 class="h2 fs-5 mt-4 ms-2">New Item</h2>
                <div id="newItemDiv">
                    <form class='notJS input-group flex-nowrap mt-2' method='post' action='OpenNote/addItem' id='formadd'>
                        <?php if (isset($itemtitle)) : ?>
                            <input id='additem' name='itemtitle' value="<?= $itemtitle ?>" form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                        <?php else : ?>
                            <input id='additem' name='itemtitle' form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                        <?php endif ?>
                        <button id="addbutton" class='btn btn-primary text-white' type='submit' form='formadd' name='id' value='<?= $textnote->getId() ?>'><i class="bi bi-plus-lg"></i></button>
                    </form>
                </div>

            <?php if (count($errorsContent) != 0) : ?>
                <label for="noteTitle" class="form-label notJS">
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

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
