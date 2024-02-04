<!DOCTYPE html>
<html>
    <head>
        <title>Checklist</title>
        <?php include('head.html');
        include 'view_openNote.php';
         ?>
    </head>
    <body>
        <p>Created 1 month ago...</p>
        <div class="form-group">
            <label for="title" class ="fw-bold">Title</label>
            <input type="title" class="form-control" id="exampleInputTitle" value="<?= $textnote->getTitle() ?>">
        </div>
        <div class="fw-bold" >Items</div>
        <div class="main">
        <ul class="list-group">
            <li class="list-group-item">
              <?php foreach($items as $item): ?>
                  <div>
                      <?php if($item->getChecked() == 1): ?>
                          <input class="form-check-input me-1" disabled="disabled" type="checkbox" checked>
                      <?php else: ?>
                          <input class="form-check-input me-1" disabled="disabled" type="checkbox">
                      <?php endif ?>
                      <label class="form-check-label"><?= $item->getContent() ?></label>
                  </div>
              <?php endforeach; ?>
              <div><input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">

              </div>
            </li>
          </ul>
          <?php include('footer.html'); ?>
    </body>
</html>
