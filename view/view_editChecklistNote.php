<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Editer une ChecklistNote</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" method="post" action="OpenNote/saveChecklistNote" id="save">
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                <button type="submit" form="save" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $textnote->getTitle() ?>">
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
