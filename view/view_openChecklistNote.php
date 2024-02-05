<!DOCTYPE html>
<html>
    <head>
        <title>Checklist</title>
        <?php include('head.html');
        include 'view_openNote.php';?>
    </head>
    <body>
        <p>Created 1 month ago...</p>
        <div class="form-group">
            <label for="title" class ="fw-bold">Title</label>
            <input type="title" class="form-control" id="exampleInputTitle" disabled="disabled" value="<?= $textnote->getTitle() ?>">
        </div>
        <div class="fw-bold" >Items</div>
        <div class="main">
        <ul class="list-group">
            <form action="opennote/checkUncheck" method="post">
              <?php foreach($items as $item): ?>
                <li class="list-group-item">
                  <div>
                      <?php if($item->getChecked() == 1): ?>
                          <input class="form-check-input me-1" type="checkbox" checked>
                      <?php else: ?>
                          <input class="form-check-input me-1" type="checkbox">
                      <?php endif ?>
                      <label class="form-check-label"><?= $item->getContent() ?></label>
                  </div>
                </li>
              <?php endforeach; ?>
            </form>
        </ul>
        <?php include('footer.html'); ?>
    </body>
</html>
