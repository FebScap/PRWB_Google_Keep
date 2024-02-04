<!DOCTYPE html>
<html>
    <head>
        <title>My notes</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <?php include('menu.php'); ?>
            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-outline-light d-flex ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex me-3">My notes</h1>
            </div>
            <!-- CARDS -->
            <h2 class="h2 fs-6 mt-4 ms-2">Pinned</h2>
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($pinnedNotes); $i++): ?>
                    <a class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $pinnedNotes[$i]->getId() ?>">
                        <div class="card h-100">
                                <ul class="list-group list-group-flush h-100">
                                    <!-- TITRE -->
                                    <li class="list-group-item"><?= $pinnedNotes[$i]->title ?></li>

                                    <li class="list-group-item list-group-item-secondary h-100 truncate-after">
                                        <!-- CONTENU TEXT NOTE -->
                                        <?php if(!$pinnedNotes[$i]->isCheckListNote($pinnedNotes[$i]->getId())): ?>
                                        <?= $pinnedNotes[$i]->getContentById($pinnedNotes[$i]->getId()) ?>
                                        <!-- CONTENU CHECKLIST NOTE -->
                                        <?php else: ?>
                                            <?php foreach($pinnedNotes[$i]->getItemListById($pinnedNotes[$i]->getId()) as $item): ?>
                                                <div>
                                                    <?php if($item->getChecked() == 1): ?>
                                                        <input class="form-check-input me-1" disabled="disabled" type="checkbox" checked>
                                                    <?php else: ?>
                                                        <input class="form-check-input me-1" disabled="disabled" type="checkbox">
                                                    <?php endif ?>
                                                    <label class="form-check-label"><?= $item->getContent() ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </li>
                                    
                                    <!-- Chevrons -->
                                    <?php if ($i == 0): ?>
                                        <li class="list-group-item d-flex justify-content-end">
                                            <i class="bi bi-chevron-double-right text-primary-emphasis"></i>
                                        </li>
                                    <?php elseif ($i == sizeof($pinnedNotes)-1): ?>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <i class="bi bi-chevron-double-left text-primary-emphasis"></i>
                                        </li>
                                    <?php else: ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <i class="bi bi-chevron-double-left text-primary-emphasis"></i>
                                            <i class="bi bi-chevron-double-right text-primary-emphasis"></i>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
            <h2 class="h2 fs-6 mt-1 ms-2">Other</h2>
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($notPinnedNotes); $i++): ?>
                    <a class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $notPinnedNotes[$i]->getId() ?>">
                        <div class="card h-100">
                                <ul class="list-group list-group-flush h-100">
                                    <!-- TITRE -->
                                    <li class="list-group-item"><?= $notPinnedNotes[$i]->title ?></li>

                                    <li class="list-group-item list-group-item-secondary h-100 truncate-after">
                                        <!-- CONTENU TEXT NOTE -->
                                        <?php if(!$notPinnedNotes[$i]->isCheckListNote($notPinnedNotes[$i]->getId())): ?>
                                        <?= $notPinnedNotes[$i]->getContentById($notPinnedNotes[$i]->getId()) ?>
                                        <!-- CONTENU CHECKLIST NOTE -->
                                        <?php else: ?> gestion des checklistnotes à faire ici
                                        <?php endif; ?>
                                    </li>
                                    
                                    <!-- Chevrons -->
                                    <?php if ($i == 0): ?>
                                        <li class="list-group-item d-flex justify-content-end">
                                            <i class="bi bi-chevron-double-right text-primary-emphasis"></i>
                                        </li>
                                    <?php elseif ($i == sizeof($notPinnedNotes)-1): ?>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <i class="bi bi-chevron-double-left text-primary-emphasis"></i>
                                        </li>
                                    <?php else: ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <i class="bi bi-chevron-double-left text-primary-emphasis"></i>
                                            <i class="bi bi-chevron-double-right text-primary-emphasis"></i>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>

            <!-- BUTTONS BAS DE PAGE -->
            <nav class="navbar fixed-bottom bg-transparent d-block">
                <div class="container-fluid d-flex justify-content-end">
                    <a class="nav-link me-4 fs-2" href="viewnotes/add_text_note/"><i class="bi bi-file-earmark text-warning"></i></a>
                    <a class="nav-link me-4 fs-2" href="viewnotes/add_checklist_note/"><i class="bi bi-card-checklist text-warning"></i></a>
                </div>
            </nav>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 