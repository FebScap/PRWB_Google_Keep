<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Editer une note</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
            <form class="container-fluid d-flex flex-column" action="OpenNote/saveNote" method="post">
                <div class="container-fluid d-flex justify-content-between">
                    <a class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
                    <button type="submit" class="btn"><i class="bi bi-floppy"></i></button>
                </div>
                <div class="m-3">
                    <label for="noteTitle" class="form-label">Title</label>
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title" aria-describedby="emailHelp" value="<?= $textnote->getTitle() ?>">
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
                    <input id="content" name="content" type="text" placeholder="Write something here" class="w-100 input-field input-group-text bg-dark text-start" value="<?= $textnote->getContent() ?>">
                </div>
                <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" aria-describedby="emailHelp" value="<?= $textnote->getId() ?>">
            </form>
            <?php include('footer.html'); ?>
    </body>
</html>