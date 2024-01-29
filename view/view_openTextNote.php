<!DOCTYPE html>
<html>
    <head>
        <title>My notes - Créer une nouvelle note</title>
        <?php include('head.html');
        include 'view_openNote.php';
         ?>
        
    </head>
    <body data-bs-theme="dark">
        <form>
            <fieldset disabled>
                <p class="font-italic">Created 1mounth ago...</p>
                <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Title</label>
                <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled title">
                </div>
                <div class="mb-3">
                <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Text</label>
                <input type="text"  style="height:600px" id="disabledTextInput" class="form-control" placeholder="Disabled text">
                </div>
                <div class="mb-3">
            </fieldset>
        </form>
        
        <?php include('footer.html'); ?>
    </body>
</html> 