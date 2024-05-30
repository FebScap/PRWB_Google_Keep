<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My notes - Créer une nouvelle ChecklistNote</title>
        <?php include('head.html'); ?>
        <script>

            let title, errorTitle, saveButton;

            document.onreadystatechange = function(){

                if(document.readyState === 'complete') {

                    title = document.getElementById("title");

                    errorTitle = document.getElementById("errorTitle");

                    saveButton = document.getElementById("saveButton");

                }

            };

            function checkTitle(){
                let ok = true;
                errorTitle.innerHTML = "";
                if (!(/^.{3,25}$/).test(title.value)) {
                    errorTitle.innerHTML += "<p class='pt-1 text-danger'>Title length must be between 3 and 25.</p>";
                    title.classList.add("is-invalid");
                    ok = false;
                } else {
                    title.classList.remove("is-invalid");
                }
                return ok;
            }

            function checkAll(){

                let ok = checkTitle();
                console.log(ok);
                saveButton.disabled = !ok; // Désactiver le bouton si ok est faux

                return ok;

                }


        </script>
    </head>
    <body data-bs-theme="dark">
        <form class="container-fluid d-flex flex-column" method="post" action="addchecklistnote" oninput='return checkAll();'>
            <div class="container-fluid d-flex justify-content-between">
                <a class="nav-link me-4 fs-2 mt-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
                <button id="saveButton" type="submit" class="btn mt-2"><i class="bi bi-floppy"></i></button>
            </div>
            <div class="mt-3">
                <label for="noteTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>" oninput="checkTitle();">
                <label class="errors" id="errorTitle"></label>
                <?php if (count($errorsTitle) != 0) : ?>
                    <label for="noteTitle" class="form-label">
                        <?php foreach ($errorsTitle as $error): ?>
                            <li class="pt-1 text-danger"><?= $error ?></li>
                        <?php endforeach; ?></label>
                <?php endif ?>
            </div>
            <div class="mt-3">
                <label class="form-label">Items</label>
                <ul>
                    <?php for ($i=0; $i<6; $i++) {
                        echo"
                        <li class='mb-2'>
                            <input type='text' class='form-control";
                        
                        if (count($errorsContent) != 0 ) {
                            if (array_key_exists($i, $errorsContent)) {
                                echo " is-invalid";
                            } else if ($content[$i] != '') {
                                echo " is-valid";
                            }
                        } else if ($content[$i] != '') {
                            echo " is-valid";
                        }

                        echo"' id='checklist' name='content[$i]' value='" . $content[$i] . "'>
                        </li>";
                        if (count($errorsContent) != 0 ) {
                            if (array_key_exists($i, $errorsContent)) {
                                echo "
                                    <li class='ms-4 pb-1 fs-6 text-danger' style='font-size: 0.8rem !important;'> $errorsContent[$i]</li>
                                ";
                            } 
                        }
                    }
                    ?>
                </ul>
            </div>
        </form>
        <?php include('footer.html'); ?>
    </body>
</html>
