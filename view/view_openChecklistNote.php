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
            <input type="title" class="form-control" id="exampleInputTitle" aria-describedby="emailHelp" placeholder="Enter title">
        </div>
        <div class="fw-bold" >Items</div>
        <div class="main">
        <ul class="list-group">
            <li class="list-group-item">
              <div><input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">

              </div>
            </li>
            <li class="list-group-item">
              <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
              Second checkbox
            </li>
            
          </ul>
          <?php include('footer.html'); ?>
    </body>
</html>

