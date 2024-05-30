<!DOCTYPE html>
<html>
<head>
    <title>OpenNote</title>
    <?php include('head.html'); ?>
    <script src="jquery-3.6.3.min.js" type="text/javascript"></script>
    <style>
        .withJS { display: none; } /* Caché par défaut, affiché par JavaScript */
        .noJS { display: block; } /* Visible par défaut, caché par JavaScript */
    </style>
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
                    $("#deleteModal").modal('hide');
                    $("#confirmationModal").modal('show');
                } catch (error) {
                    console.error('Error deleting note:', error);
                }
            });

            $("#closeButton").click(() => {
                window.location.href = "viewArchives";
            });
        });

        // Ensure noJS elements are removed if JavaScript is enabled
        $(document).ready(function() {
            $(".noJS").hide();
            $(".withJS").show();
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
                <button type="button" class="btn btn-dark withJS" data-bs-toggle="modal" data-bs-target="#deleteModal" id="withJS"><i class="bi bi-trash"></i></button>
                <form action="deletenote/index/<?= $textnote->getId() ?>" method="get" class="noJS">
                    <button type="submit" class="btn btn-dark" id="noJS"><i class="bi bi-trash"></i></button>
                </form>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="deleteModalLabel">Are you sure?</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            Do you really want to delete <?= $textnote->getTitle() ?> and all its dependencies?
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="confirmationModalLabel">Note Deleted</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            The note <?= $textnote->getTitle() ?> and its dependencies have been successfully deleted.
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="closeButton">Close</button>
                        </div>
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
                    <form action="opennote/editlabels/<?= $textnote->getId() ?>" method="post">
                            <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-tags"></i></button>
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
                    <form action="opennote/editlabels/<?= $textnote->getId() ?>" method="post">
                            <button type="submit" name="idnote" value="<?= $textnote->getId() ?>" class="btn btn-dark"><i class="bi bi-tags"></i></button>
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