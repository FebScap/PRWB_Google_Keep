<!DOCTYPE html>
<html>
    <head>
        <title>Checklist</title>
        <?php include('head.html');
        include 'view_openNote.php';?>
    </head>
    <body>
        <p class="font-italic">Created <?= $textnote->getCreatedAt() ?></p>
        <?php if (!is_null($textnote->getEditedAt())) : ?>
                <p class="font-italic">Edited <?= $textnote->getEditedAt() ?></p>
        <?php endif ?>
        <div class="form-group">
            <label for="title" class ="fw-bold">Title</label>
            <input type="title" class="form-control" id="exampleInputTitle" disabled="disabled" value="<?= $textnote->getTitle() ?>">
        </div>
        <div class="fw-bold" >Items</div>
        <div class="main">
        <ul class="list-group">
              <?php foreach($items as $item): ?>
                <li class="list-group-item">
                  <div>
                    <form action="opennote/checkUncheck" method="post">
                      <?php if ($item->getChecked() == 1) : ?>
                        <button class="btn btn-dark bi bi-check-square" type="submit" name="itemid" value="<?= $item->getId() ?>" <?= $user->isAllowedToEdit($textnote->getId()) ? '' : 'disabled' ?>></button>
                        <input type="hidden" name="idnote" value="<?= $textnote->getId() ?>">
                        <label class="form-check-label text-decoration-line-through"><?= $item->getContent() ?></label>
                      <?php else : ?>
                        <button class="btn btn-dark bi bi-square" type="submit" name="itemid" value="<?= $item->getId() ?>" <?= $user->isAllowedToEdit($textnote->getId()) ? '' : 'disabled' ?>></button>
                        <input type="hidden" name="idnote" value="<?= $textnote->getId() ?>">
                        <label class="form-check-label"><?= $item->getContent() ?></label>
                      <?php endif ?>
                    </form>
                  </div>
                </li>
              <?php endforeach; ?>
        </ul>
        <?php include('footer.html'); ?>
    </body>
</html>
