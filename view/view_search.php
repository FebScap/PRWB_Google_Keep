<!DOCTYPE html>
<html>
    <head>
        <title>My notes</title>
        <?php include('head.html'); ?>
        <script src="js/RemoveNotJS.js"></script>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <?php include('menu.php'); ?>
            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-outline-light d-flex ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="fs-4 d-flex me-3">Search my notes</h1>
            </div>
            <!-- Affichage des tags pour la recherche -->
            <h2 class="h2 fs-6 mt-4 ms-2">Search notes by tags : </h2>
            <div id="divTagList" class="d-flex flex-row flex-wrap justify-content-start">
            <?php foreach($labels as $label): ?>
                <div class="form-check fs-7 ms-3">
                    <input class="form-check-input" type="checkbox" value="<?= $label ?>" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault"><?= $label ?></label>
                </div>
            <?php endforeach ?>
            </div>
            <!-- CARDS -->

            <!-- NOTES DE L'UTILISATEUR COURANT -->
            <h2 class="h2 fs-6 mt-4 ms-2">Your notes :</h2>
            <div id="userNotes" class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($userNotes); $i++): ?>
                        <a id="<?= $userNotes[$i]->getId() ?>" class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $userNotes[$i]->getId() ?>">
                            <div class="card h-100">
                                    <ul class="list-group list-group-flush h-100">
                                        <!-- TITRE -->
                                        <li class="list-group-item"><?= $userNotes[$i]->title ?></li>

                                        <li class="list-group-item list-group-item-secondary h-100 d-flex flex-column justify-content-between truncate-after">
                                            <div class="truncate-after">
                                                <!-- CONTENU TEXT NOTE -->
                                                <?php if(!$userNotes[$i]->isCheckListNote($userNotes[$i]->getId())): ?>
                                                <?= $userNotes[$i]->getContentById($userNotes[$i]->getId()) ?>
                                                <!-- CONTENU CHECKLIST NOTE -->
                                                <?php else: ?>
                                                    <?php foreach($userNotes[$i]->getItemListById($userNotes[$i]->getId()) as $item): ?>
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
                                            </div>
                                            <div class="mt-2 align-bottom">
                                                <?php foreach (Label::getNoteLabels($userNotes[$i]->getId()) as $label) : ?>
                                                    <span class="badge rounded-pill text-bg-secondary" style="font-size: 0.60rem !important;"><?= $label ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    </ul>
                            </div>
                        </a>
                <?php endfor; ?>
            </div>

            <!-- NOTES PARTAGEE -->
            <?php for ($u = 0; $u < sizeof($sharedBy); $u++) : ?>
            <h2 class="h2 fs-6 mt-4 ms-2">Notes shared by <?= $nameSharedBy[$u] ?> : </h2>
            <div id="sharedBy<?= $nameSharedBy[$u] ?>" class="d-flex flex-row flex-wrap justify-content-start">
                <?php for ($i = 0; $i < sizeof($notesShared); $i++): ?>
                <?php if ($notesShared[$i]->getOwner() == $sharedBy[$u] ) : ?>
                    <a id="<?= $notesShared[$i]->getId() ?>" class="link-underline link-underline-opacity-0 m-1" style="width: 46%;" href="opennote/index/<?= $notesShared[$i]->getId() ?>">
                        <div class="card h-100">
                                <ul class="list-group list-group-flush h-100">
                                    <!-- TITRE -->
                                    <li class="list-group-item"><?= $notesShared[$i]->title ?></li>

                                    <li class="list-group-item list-group-item-secondary h-100 d-flex flex-column justify-content-between truncate-after">
                                        <div class="truncate-after">
                                            <!-- CONTENU TEXT NOTE -->
                                            <?php if(!$notesShared[$i]->isCheckListNote($notesShared[$i]->getId())): ?>
                                            <?= $notesShared[$i]->getContentById($notesShared[$i]->getId()) ?>
                                            <!-- CONTENU CHECKLIST NOTE -->
                                            <?php else: ?>
                                                <?php foreach($notesShared[$i]->getItemListById($notesShared[$i]->getId()) as $item): ?>
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
                                        </div>
                                        <div class="mt-2 align-bottom">
                                            <?php foreach (Label::getNoteLabels($notesShared[$i]->getId()) as $label) : ?>
                                                <span class="badge rounded-pill text-bg-secondary" style="font-size: 0.60rem !important;"><?= $label ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                </ul>
                        </div>
                    </a>
                <?php endif ?>
                <?php endfor; ?>
            </div>
            <?php endfor ?>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 