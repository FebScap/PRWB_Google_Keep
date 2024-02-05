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
            <a href="settings/editProfile" for="noteTitle" class="form-label link-light link-underline link-underline-opacity-0">Edit profile</a>
            </div>
            <div class="mt-3">
            <i class="bi bi-three-dots"></i>
            <a href="settings/changePassword" for="noteTitle" class="form-label link-light link-underline link-underline-opacity-0">Change password</a>
            </div>
            <div class="mt-3">
            <i class="bi bi-box-arrow-right"></i>    
            <a href="settings/logout" for="noteTitle" class="form-label link-light link-underline link-underline-opacity-0">Logout</a>
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html> 