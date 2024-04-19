<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle note</title>
        <?php include('head.html');
        include 'view_openNote.php';
         ?>
        
    </head>
    <body data-bs-theme="dark">
        <form class="m-3">
            <fieldset disabled>
                <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
                <?php if (!is_null($textnote->getEditedAt())) : ?>
                    <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
                <?php endif ?>
                <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Title</label>
                <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled title" value="<?= $textnote->getTitle() ?>">
                </div>
                <div class="mb-3">
                <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Text</label>
                <textarea type="text"  style="height:550px" id="disabledTextInput" class="form-control"><?= $textnote->getContent() ?></textarea>
                </div>
                <div class="mb-3">
            </fieldset>
        </form>
        
        <?php include('footer.html'); ?>
    </body>
</html> 