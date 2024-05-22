<!DOCTYPE html>
<html>
    <head>
        <title>OpenNote</title>
        <?php include('head.html'); ?>
        <script src="jquery-3.6.3.min.js" type="text/javascript"></script>
        <script>
        $(document).ready(() => {
            $("#deleteButton").click(async () => {
                const noteId = <?= $textnote->getId() ?>;
                
                try {
                    const response = await fetch(`deletenote/delete/${noteId}`, {
                        method: 'DELETE'
                    });
                    if (!response.ok) {
                        throw new Error('Failed to delete note');
                    }
                    const responseData = await response.text();
                    $("#confirmationModal").modal('show');
                } catch (error) {
                    console.error('Error deleting note:', error);
                }
            });

            $("#closeButton").click(async () => {
                window.location.href = "viewArchives";
            });

            


        });
        </script>
    </head>
    <body data-bs-theme="dark">
        <div class="d-flex bd-highlight mb-3">
            
            
            <?php if ($textnote->isArchived()) : ?>
                <div class="me-auto p-2 bd-highlight">
                    <a type="button" href="viewArchives" class="btn btn-dark"><i class="bi bi-chevron-left"></i></a>
                </div>
                <div class="p-2 bd-highlight">
                    <!--<form action="deletenote/index/<?= $textnote->getId() ?>" method="get">-->
                        <button type="submit" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
                    <!--</form>-->
                </div>


                <!-- Delete Modal -->
                <div class="modal" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Do you really want to delete <?= $textnote->getTitle() ?> and all his dependencies ? 
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="deleteButton">Delete</button>
                        <button type="button" class="btn btn" data-bs-dismiss="modal">Cancel</button>
                    </div>

                    </div>
                </div>
                </div>

                <!-- Confirmation Modal -->

                <div class="modal" id="confirmationModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Note Deleted</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            The note <?= $textnote->getTitle() ?> and its dependencies have been successfully deleted.
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn" data-bs-dismiss="modal" id="closeButton">Close</button>
                        </div>
                    </div>
                </div>
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
                <div class="p-2 bd-highlight">
                    <?php if (Note::isCheckListNote($textnote->getId())) : ?>
                        <form action="opennote/editChecklistNote/<?= $textnote->getId() ?>" method="post">
                    <?php else : ?>
                        <form action="opennote/editnote/<?= $textnote->getId() ?>" method="post"> 
                    <?php endif; ?>
                    <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-pencil"></i></button>
                    </form>
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
                    <?php if (Note::isCheckListNote($textnote->getId())) : ?>
                        <form action="opennote/editChecklistNote/<?= $textnote->getId() ?>" method="post">
                    <?php else : ?>
                        <form action="opennote/editnote/<?= $textnote->getId() ?>" method="post"> 
                    <?php endif; ?>
                    <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-pencil"></i></button>
                    </form>
                </div>
            <?php endif ?> 
        </div>
          <?php include('footer.html'); ?>
    </body>
</html>