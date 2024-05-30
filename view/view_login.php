<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My notes - Login</title>
        <base href="<?= $web_root ?>"/>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark" class="h-full">
        <div class="container h-100">
            <div class="row align-items-center h-full">
                <div class="col-12">
                    <div class="card h-100 justify-content-center" style="border-radius: 1rem;">
                    <div class="card-body p-3 text-center">
                    <h3 class="mb-2">Sign in</h3>

                    <hr class="my-4">

                    <form action="main/login" method="post">

                        <div class="input-group flex-nowrap mt-4 w-100">
                            <button class="btn btn-outline-secondary text-white" type="button" disabled><i class="bi bi-person"></i></button>
                            <input id="mail" name="mail" type="email" class="form-control" value="<?= $mail ?>" placeholder="exemple@domaine.ect" >
                        </div>

                        <div class="input-group flex-nowrap mt-4 w-100">
                            <button class="btn btn-outline-secondary text-white" type="button" disabled><i class="bi bi-key"></i></button>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" >
                        </div>

                        <button class="btn btn-primary btn-lg btn-block mt-4 mb-4 w-100" type="submit">Login</button>

                    </form>

                    <span class="w-100"><a class="link-underline-primary" href="main/signup">New here ? Click here to subscribe !</a></span>
                    <?php if (count($errors) != 0): ?>
                        <div class='errors'>
                            <p>Please correct the following error(s) :</p>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 