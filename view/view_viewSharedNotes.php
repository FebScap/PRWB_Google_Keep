<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Shared by <?= $from->full_name ?></title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <?php include('menu.php'); ?>
            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-outline-light d-flex ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex me-3">Shared by <?= $from->full_name ?></h1>
            </div>
            <!-- CARDS -->
            <h2 class="d-flex h2 fs-6 mt-4 ms-2">Notes shared to you by <?= $from->full_name ?> as editor</h2>
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($notesEdit); $i++): ?>

                    <a class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $notesEdit[$i]->getId() ?>">
                        <div class="card h-100">
                                <ul class="list-group list-group-flush h-100">
                                    <!-- TITRE -->
                                    <li class="list-group-item"><?= $notesEdit[$i]->title ?></li>

                                    <li class="list-group-item list-group-item-secondary h-100 truncate-after">
                                        <!-- CONTENU TEXT NOTE -->
                                        <?php if(!$notesEdit[$i]->isCheckListNote($notesEdit[$i]->getId())): ?>
                                        <?= $notesEdit[$i]->getContentById($notesEdit[$i]->getId()) ?>
                                        <!-- CONTENU CHECKLIST NOTE -->
                                        <?php else: ?> gestion des checklistnotes à faire ici
                                        <?php endif; ?>
                                    </li>
                                </ul>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
            <h2 class="d-flex h2 fs-6 mt-1 ms-2">Notes shared to you by <?= $from->full_name ?> as reader</h2>
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($notesRead); $i++): ?>
                    <a class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $notesRead[$i]->getId() ?>">
                        <div class="card h-100">
                                <ul class="list-group list-group-flush h-100">
                                    <!-- TITRE -->
                                    <li class="list-group-item"><?= $notesRead[$i]->title ?></li>

                                    <li class="list-group-item list-group-item-secondary h-100 truncate-after">
                                        <!-- CONTENU TEXT NOTE -->
                                        <?php if(!$notesRead[$i]->isCheckListNote($notesRead[$i]->getId())): ?>
                                        <?= $notesRead[$i]->getContentById($notesRead[$i]->getId()) ?>
                                        <!-- CONTENU CHECKLIST NOTE -->
                                        <?php else: ?> gestion des checklistnotes à faire ici
                                        <?php endif; ?>
                                    </li>
                                </ul>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
        <?php include('footer.html'); ?>
    </body>
</html> 