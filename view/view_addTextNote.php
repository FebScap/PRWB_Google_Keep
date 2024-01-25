<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle note</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column">
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <button type="submit" class="btn"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="noteTitle" aria-describedby="emailHelp">
            </div>
            <div class="mt-3">
                <label for="noteContent" class="form-label">Text</label>
                <input type="text" style="height:600px" class="form-control" id="noteContent">
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html> 