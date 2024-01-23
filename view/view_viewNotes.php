<!DOCTYPE html>
<html>
    <head>
        <title>My notes</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid bg-dark text-white d-flex flex-column">
            <?php include('menu.html'); ?>
            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-outline-light d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex">My notes</h1>
            </div>
            <!-- CARDS -->
            <div class="d-flex flex-column m-3">
                <div class="card w-50" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>

                <div class="card w-50" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>

                <div class="card w-50" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>

                <div class="card w-50" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 