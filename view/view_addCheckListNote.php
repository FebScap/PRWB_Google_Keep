<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle checklist</title>
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
                <label class="form-label">Items</label>
                <ul>
                    <li class="mb-2">
                        <input type="text" class="form-control" id="checklist1">
                    </li>
                    <li class="mb-2">
                        <input type="text" class="form-control" id="checklist2">
                    </li>
                    <li class="mb-2">
                        <input type="text" class="form-control" id="checklist3">
                    </li>
                    <li class="mb-2">
                        <input type="text" class="form-control" id="checklist4">
                    </li>
                    <li class="mb-2">
                        <input type="text" class="form-control" id="checklist5">
                    </li>
                </ul>
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html> 