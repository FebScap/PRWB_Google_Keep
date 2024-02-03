<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Note</title>
    <base href="<?= $web_root ?>"/>
    <?php include('head.html'); ?>
</head>

<body data-bs-theme="dark" class="h-full">
    <div class="container h-100">
        <div class="row align-items-center h-full">
            <div class="col-12">
                <div class="card h-100 justify-content-center" style="border-radius: 1rem;">
                    <div class="card-body p-3 text-center">
                        <h3 class="mb-2">Delete Note</h3>

                        <hr class="my-4">

                        <p class="confirmation-text">Are you sure you want to delete ' <?= Note::getNoteById($noteid)->getTitle() ?>' ? This is irreversible.</p>

                        <div class="d-grid gap-2 mt-4">


                            <form action="deletenote/delete/<?= $noteid ?>" method="get">
                            <button class="btn btn-danger" type="submit">Delete</button>
                            </form>


                            <form action="opennote/index/<?= $noteid ?>" method="get">
                            <button class="btn btn-success" type="submit" >Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.html'); ?>
</body>

</html>
