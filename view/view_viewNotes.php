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
                <button class="btn btn-outline-light d-flex ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex me-3">My notes</h1>
            </div>
            <!-- CARDS -->
            <h2 class="h2 fs-6 mt-4 ms-2">Pinned</h2>
            <div class="d-flex flex-row flex-wrap justify-content-evenly align-items-start">
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
            </div>
            <h2 class="h2 fs-6 mt-1 ms-2">Other</h2>
            <div class="d-flex flex-row flex-wrap justify-content-evenly">
            <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
                <div class="card m-1" style="max-width: 48%;" data-bs-theme="dark">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Titre</li>
                        <li class="list-group-item list-group-item-secondary">Contenu contenu contenu contenu</li>
                        <li class="list-group-item"><<         >></li>
                    </ul>
                </div>
            </div>
            <!-- BUTTONS BAS DE PAGE -->
            <nav class="navbar fixed-bottom bg-transparent">
                <div class="container-fluid d-flex justify-content-end">
                    <a class="nav-link me-4 fs-2" href="#"><i class="bi bi-file-earmark text-warning"></i></a>
                    <a class="nav-link me-4 fs-2" href="#"><i class="bi bi-card-checklist text-warning"></i></a>
                </div>
            </nav>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 