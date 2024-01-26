<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Archived</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <?php include('menu.php'); ?>
            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-outline-light d-flex ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex me-3">My archives</h1>
            </div>
            <!-- CARDS -->
            <h2 class="h2 fs-6 mt-4 ms-2">Archives</h2>
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($notes); $i++): ?>
                    <a class="link-underline link-underline-opacity-0" style="max-width: 48%;" href="opennote/">
                        <div class="card m-1" data-bs-theme="dark">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?= $notes[$i]->title ?></li>
                                <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                            </ul>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 