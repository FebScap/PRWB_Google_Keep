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
                    <div class="container-fluid input-group p-1">
                            <!-- PARTAGE READER -->
                            <?php if ($shares[$i]->isEditor()): ?>
                                <span class="form-control"><?= User::getByID($shares[$i]->getUser())->full_name ?> <i>(reader)</i></span>
                            <!-- PARTAGE EDITOR -->
                            <?php else: ?>
                                <span class="form-control"><?= User::getByID($shares[$i]->getUser())->full_name ?> <i>(editor)</i></span>
                            <?php endif; ?>
                            <form class="button" action="viewshares/swapRole/<?= $_GET["param1"] ?>" method="post">
                                <button class="btn btn-primary rounded-0" type="submit" name="iduser" value="<?= $shares[$i]->getUser() ?>" class="btn btn-dark"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                            <form class="button" action="viewshares/delete/<?= $_GET["param1"] ?>" method="post">
                                <button class="btn btn-danger rounded-0 rounded-end" type="submit" name="iduser" value="<?= $shares[$i]->getUser() ?>" class="btn btn-dark"><i class="bi bi-dash"></i></button>
                            </form>
                        
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

            <!-- NOUVEAU PARTAGE -->
            <form class="container-fluid p-1" action="viewshares/add/<?= $_GET["param1"] ?>" method="post">
                <div class="container-fluid input-group flex-nowrap p-0">
                    <select class="form-select" name="user">
                        <option selected>-User-</option>
                        <?php for ($i = 0; $i < sizeof($users); $i++): ?>
                            <?php if (!Shares::isSharedBy($_GET["param1"], $users[$i]->getId())): ?>
                                <option value="<?= $users[$i]->getId() ?>"><?= $users[$i]->full_name ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-select" name="permission">
                        <option selected>-Permission-</option>
                        <option value="0">Reader</option>
                        <option value="1">Editor</option>
                    </select>
                    <button class="btn btn-primary" type="submit" id="button-addon1"><i class="bi bi-plus align-center"></i></button>
                </div>
            </form>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 