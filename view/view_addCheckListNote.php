<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle ChecklistNote</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" method="post" action="addchecklistnote">
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <button type="submit" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
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
                    <?php for ($i=0; $i<6; $i++) {
                        echo"
                        <li class='mb-2'>
                            <input type='text' class='form-control' id='checklist' name='content[$i]'>
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
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html>
