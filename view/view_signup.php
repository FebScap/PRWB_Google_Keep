<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Signup</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark" class="h-full">
        <div class="container h-100">
            <div class="row align-items-center h-full">
                <div class="col-12">
                    <div class="card h-100 justify-content-center" style="border-radius: 1rem;">
                    <div class="card-body p-3 text-center">
                    <h3 class="mb-2">Sign up</h3>

                    <hr class="my-4">

                    <div class="input-group flex-nowrap mt-2 w-100">
                        <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-person"></i></button>
                        <input type="email" class="form-control" placeholder="exemple@domaine.ect" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group flex-nowrap mt-2 w-100">
                        <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-person"></i></button>
                        <input type="text" class="form-control" placeholder="Full name" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group flex-nowrap mt-2 w-100">
                        <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-key"></i></button>
                        <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group flex-nowrap mt-2 w-100">
                        <button class="btn btn-outline-secondary text-white" type="button"><i class="bi bi-key"></i></button>
                        <input type="password" class="form-control" placeholder="Confirm your password" aria-describedby="basic-addon1">
                    </div>

                    <button class="btn btn-primary btn-lg btn-block mt-3 w-100" type="submit">Sign Up</button>

                    <button class="btn btn-danger btn-lg btn-block mt-2 w-100" type="submit">Cancel</button>
                </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.html'); ?>
    </body>
</html> 