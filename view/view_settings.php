<!DOCTYPE html>
<html>
    <head>
        <title>Settings</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column">
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <h1 class="fs-4 d-flex me-3">Settings</h1>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Hey <?php echo $user->getFullName(); ?></label>
            </div>
            <div class="mt-3">
            <i class="bi bi-person-gear"></i>    
            <label for="noteTitle" class="form-label">Edit profile</label>
            </div>
            <div class="mt-3">
            <i class="bi bi-three-dots"></i>
            <label for="noteTitle" class="form-label">Change password</label>
            </div>
            <div class="mt-3">
            <i class="bi bi-box-arrow-right"></i>    
            <label for="noteTitle" class="form-label">Logout</label>
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html> 