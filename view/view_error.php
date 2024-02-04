<!DOCTYPE html>
<html lang="en">

<head>
    <title>Error</title>
    <base href="<?= $web_root ?>"/>
    <?php include('head.html'); ?>
</head>

<body data-bs-theme="dark" class="h-full">
    <div class="container h-100">
        <div class="row align-items-center h-full">
            <div class="col-12">
                <div class="card h-100 justify-content-center" style="border-radius: 1rem;">
                    <div class="card-body p-3 text-center">
                        <h3 class="mb-2 text-danger">Error</h3>

                        <hr class="my-4">

                        <div class="main text-danger">
                            <?= $error ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>