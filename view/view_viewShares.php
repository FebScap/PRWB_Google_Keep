<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Shares</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="container-fluid d-flex flex-column">
            <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
            <h1 class="fs-4 d-flex mt-3">Shares</h1>

            <!-- SI AUCUNES NOTES PARTAGEES LA FOR NE SE LANCE PAS -->
            <?php if (sizeof($shares) == 0): ?>
                <p>This note is not shared yet.</p>

            <!-- FOR POUR CHAQUES PARTAGES DE LA NOTES -->
            <?php else: ?>
                <?php for ($i = 0; $i < sizeof($shares); $i++): ?>
                    <form class="container-fluid p-0 pt-1">
                        <div class="container-fluid input-group flex-nowrap p-0">
                            <!-- PARTAGE READER -->
                            <?php if ($shares[$i]->isEditor()): ?>
                                <span class="form-control"><?= User::getByID($shares[$i]->getUser())->full_name ?> <i>(reader)</i></span>
                            <!-- PARTAGE EDITOR -->
                            <?php else: ?>
                                <span class="form-control"><?= User::getByID($shares[$i]->getUser())->full_name ?> <i>(editor)</i></span>
                            <?php endif; ?>
                            <button class="btn btn-primary" type="button"><i class="bi bi-arrow-repeat"></i></button>
                            <button class="btn btn-danger" type="button"><i class="bi bi-dash"></i></button>
                        </div>
                    </form>
                <?php endfor; ?>
            <?php endif; ?>

            <!-- NOUVEAU PARTAGE -->
            <form class="container-fluid p-0 pt-2">
                <div class="container-fluid input-group flex-nowrap p-0">
                    <select class="form-select" id="inlineFormCustomSelect">
                        <option selected>-User-</option>
                        <?php for ($i = 0; $i < sizeof($users); $i++): ?>
                            <?php if (Shares::isSharedBy($_GET["param1"], $users[$i]->getId())): ?>
                                <option value="<?= $i+1 ?>"><?= $users[$i]->full_name ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-select" id="inlineFormCustomSelect">
                        <option selected>-Permission-</option>
                        <option value="1">Editor</option>
                        <option value="2">Reader</option>
                    </select>
                    <button class="btn btn-primary" type="submit" id="button-addon1"><i class="bi bi-plus align-center"></i></button>
                </div>
            </form>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 