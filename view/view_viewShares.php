<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Shares</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <?php include('menu.php'); ?>
            <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
            <h1 class="fs-4 d-flex mt-3">Shares</h1>

            <p>This note is not shared yet.</p>

            <form class="container-fluid p-0 pt-1">
                <div class="container-fluid input-group flex-nowrap p-0">
                    <span class="form-control">Benoît (reader)</span>
                    <button class="btn btn-primary" type="button"><i class="bi bi-arrow-repeat"></i></button>
                    <button class="btn btn-danger" type="button"><i class="bi bi-dash"></i></button>
                </div>
            </form>

            <form class="container-fluid p-0 pt-1">
                <div class="container-fluid input-group flex-nowrap p-0">
                    <span class="form-control">Marc (editor)</span>
                    <button class="btn btn-primary" type="button"><i class="bi bi-arrow-repeat"></i></button>
                    <button class="btn btn-danger" type="button"><i class="bi bi-dash"></i></button>
                </div>
            </form>

            <form class="container-fluid p-0 pt-2">
                <div class="container-fluid input-group flex-nowrap p-0">
                    <select class="form-select" id="inlineFormCustomSelect">
                        <option selected>-User-</option>
                        <option value="1">xxx</option>
                        <option value="2">xxx</option>
                        <option value="3">xxx</option>
                    </select>
                    <select class="form-select" id="inlineFormCustomSelect">
                        <option selected>-Permission-</option>
                        <option value="1">xxx</option>
                        <option value="2">xxx</option>
                        <option value="3">xxx</option>
                    </select>
                    <button class="btn btn-primary" type="submit" id="button-addon1"><i class="bi bi-plus align-center"></i></button>
                </div>
            </form>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 