<!DOCTYPE html>
<html>
    <head>
        <title>OpenNote</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="d-flex bd-highlight mb-3">
            
            
            <?php if ($textnote->isArchived()) : ?>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewArchives" class="btn btn-dark"><i class="bi bi-chevron-left"></i></a>
                </div>
                <div class="p-2 bd-highlight">
                    <form action="deletenote/index/<?= $textnote->getId() ?>" method="get"> 
                        <button type="submit" class="btn btn-dark"><i class="bi bi-trash"></i></button>
                    </form>
                </div>

                <div class="p-2 bd-highlight">
                    <form action="opennote/unarchive" method="post"> 
                        <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-box-arrow-in-up"></i></button>
                    </form>
                </div>
            
            <?php elseif ($textnote->isEditable() && !$user->isOwner($textnote->getId())) : ?>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewSharedNotes/sharedby/<?= $textnote->getOwner() ?>" class="btn btn-dark"><i class="bi bi-chevron-left"></i></a>
                </div>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewSharedNotes" class="btn btn-dark"><i class="bi bi-pencil"></i></a>
                </div>
            
            <?php elseif ($textnote->isShared() && !$user->isOwner($textnote->getId())) : ?>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewSharedNotes/sharedby/<?= $textnote->getOwner() ?>" class="btn btn-dark"><i class="bi bi-chevron-left"></i></a>
                </div>

            <?php else : ?>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewnotes" class="btn btn-dark"><i class="bi bi-chevron-left"></i></a>
                </div>
                    <div class="p-2 bd-highlight">
                        <form action="viewshares/index/<?= $textnote->getId() ?>" method="get">
                            <button type="submit" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-share"></i></button>
                        </form>
                    </div>
                <?php if (!$textnote->isPinned()) : ?>  
                    <div class="p-2 bd-highlight">
                        <form action="opennote/pin" method="post">
                            <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-pin"></i></button>
                        </form>
                    </div>
                <?php else : ?>
                    <div class="p-2 bd-highlight">
                        <form action="opennote/unpin" method="post">
                            <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-pin-fill"></i></button>
                        </form>
                    </div>
                <?php endif ?>

                <div class="p-2 bd-highlight">
                    <form action="opennote/archive" method="post">
                        <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-box-arrow-in-down"></i></button>
                    </form>
                </div>
                <div class="p-2 bd-highlight">
                    <form action="opennote/editnote/<?= $textnote->getId() ?>" method="get"> 
                        <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-pencil"></i></button>
                    </form>
                </div>
            <?php endif ?> 
        </div>
          <?php include('footer.html'); ?>
    </body>
</html>