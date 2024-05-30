<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit profile</title>
        <?php include('head.html'); ?>
        <base href="<?= $web_root ?>"/>
    </head>
    <body data-bs-theme="dark" class="h-full">
        <div class="container h-100">
            <div class="row align-items-center h-full">
                <div class="col-12">
                    <div class="card h-100 justify-content-center" style="border-radius: 1rem;">
                    <div class="card-body p-3 text-center">
                    <h3 class="mb-2">Edit profile</h3>

                    <hr class="my-4">

                    <form id="signupForm" action="settings/editProfile" method="post">

                        <div class="input-group flex-nowrap mt-2 w-100">
                            <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-person"></i></button>
                            <input id="fullname" name="fullname" type="text" class="form-control" value="<?= $fullname ?>" placeholder="Fullname" >
                        </div>

                        <?php if (count($errorsFullname) != 0): ?>
                            <div class='errorsFullname'>
                                <ul>
                                    <?php foreach ($errorsFullname as $error): ?>
                                        <li class="pt-1"><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>


                        <div class="input-group flex-nowrap mt-2 w-100">
                            <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-person"></i></button>
                            <input id="mail" name="mail" type="text" class="form-control" value="<?= $mail ?>" placeholder="Mail" >
                        </div>

                        <?php if (count($errorsMail) != 0): ?>
                            <div class='errorsMail'>
                                <ul>
                                    <?php foreach ($errorsMail as $error): ?>
                                        <li class="pt-1"><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <button class="btn btn-primary btn-lg btn-block mt-3 w-100" type="submit">Save</button>

                        <a class="btn btn-danger btn-lg btn-block mt-2 w-100" href="settings" role="button" type="submit">Cancel</a>

                    </form>

                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 