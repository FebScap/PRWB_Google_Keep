<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Checklist</title>
        <?php include('head.html');
        include 'view_openNote.php';?>
    </head>
    <body class="m-3">
        <p class="font-italic">Created <?= Note::elapsedDate($textnote->getCreatedAt()) ?></p>
        <?php if (!is_null($textnote->getEditedAt())) : ?>
                <p class="font-italic">Edited <?= Note::elapsedDate($textnote->getEditedAt()) ?></p>
        <?php endif ?>
        <div class="form-group">
            <label for="title" class ="fw-bold">Title</label>
            <input type="title" class="form-control" id="exampleInputTitle" disabled="disabled" value="<?= $textnote->getTitle() ?>">
        </div>
        <div class="fw-bold" >Items</div>
        <div class="main">
            <?php foreach($items as $item): ?>
              <form class='input-group input-group-lg w-100 flex-nowrap h-30 mt-2' method='post' action='OpenNote/checkUncheck'>
                    <?php if ($item->getChecked() == 1) : ?>
                      <button class="btn btn-primary bi bi-check-square" type="submit" name="itemid" value="<?= $item->getId() ?>" <?= $user->isAllowedToEdit($textnote->getId()) ? '' : 'disabled' ?>></button>
                      <input type="hidden" name="idnote" value="<?= $textnote->getId() ?>">
                      <span class="input-group-text w-100 text-decoration-line-through"><?= $item->getContent() ?></span>
                    <?php else : ?>
                      <button class="btn btn-primary bi bi-square" type="submit" name="itemid" value="<?= $item->getId() ?>" <?= $user->isAllowedToEdit($textnote->getId()) ? '' : 'disabled' ?>></button>
                      <input type="hidden" name="idnote" value="<?= $textnote->getId() ?>">
                      <span class="input-group-text w-100"><?= $item->getContent() ?></span>
                    <?php endif ?>
              </form>
            <?php endforeach; ?>
        <?php include('footer.html'); ?>
    </body>
</html>
