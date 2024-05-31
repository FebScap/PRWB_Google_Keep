<!DOCTYPE html>
<html lang="en">
<head>
    <title>My notes - Créer une nouvelle ChecklistNote</title>
    <?php include('head.html'); ?>
    <script>
        let title, errorTitle, saveButton;

        document.onreadystatechange = function() {
            if (document.readyState === 'complete') {
                title = $("#title");
                errorTitle = $("#errorTitle");
                saveButton = $("#saveButton");
            }
        };

        function checkTitle() {
            let ok = true;
            errorTitle.html("");
            if (!(/^.{3,25}$/).test(title.val())) {
                errorTitle.append("<p class='text-danger'>Title length must be between 3 and 25.</p>");
                title.addClass("is-invalid");
                ok = false;
            } else {
                title.removeClass("is-invalid");
                title.addClass("is-valid");
            }
            return ok;
        }

        async function checkTitleUnicity() {
            let ok = true;
            errorTitle.html("");
            const titleValue = title.val();

            try {
                const response = await $.ajax({
                    url: "addtextnote/check_title_unicity_service",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ title: titleValue }),
                    dataType: "json"
                });

                if (!response) {
                    errorTitle.append("<p class='text-danger'>Title must be unique per user.</p>");
                    title.addClass("is-invalid");
                    ok = false;
                } else {
                    title.removeClass("is-invalid");
                }
            } catch (error) {
                console.error("Error:", error);
                // Gérer les erreurs en conséquence
                ok = false;
            }

            return ok;
        }

        function checkContent() {
            let ok = true;
            let itemValues = {};
            let inputs = $("input[name^='content']");
            let errorContent = $(".errorContent");
            inputs.removeClass("is-invalid is-valid");
            errorContent.html("");

            inputs.each(function() {
                let value = $(this).val().trim();
                let index = $(this).index("input[name^='content']");
                let errorLabel = errorContent.eq(index);

                if (value !== "" && (value.length < 2 || value.length > 60)) {
                    $(this).addClass("is-invalid");
                    errorLabel.append("<p class='text-danger'>Item length must be between 2 and 60 characters.</p>");
                    ok = false;
                } else if (value !== "" && itemValues[value]) {
                    $(this).addClass("is-invalid");
                    errorLabel.append("<p class='text-danger'>Item must be unique.</p>");
                    itemValues[value].addClass("is-invalid");
                    errorContent.eq(itemValues[value].index("input[name^='content']")).append("<p class='text-danger'>Item must be unique.</p>");
                    ok = false;
                } else if (value !== "") {
                    itemValues[value] = $(this);
                    $(this).addClass("is-valid");
                }
            });

            return ok;
        }

        async function checkAll() {
            let titleValid = checkTitle();
            if (!titleValid) {
                saveButton.prop('disabled', true);
                return false;
            }
            let titleUnique = await checkTitleUnicity();
            let contentValid = checkContent();
            let ok = titleValid && titleUnique && contentValid;
            saveButton.prop('disabled', !ok);
            return ok;
        }
    </script>
</head>
<body data-bs-theme="dark">
    <form class="container-fluid d-flex flex-column" method="post" action="addchecklistnote" oninput='checkAll();'>
        <div class="container-fluid d-flex justify-content-between">
            <a class="nav-link me-4 fs-2 mt-2" href="viewnotes"><i class="bi bi-chevron-left"></i></a>
            <button id="saveButton" type="submit" class="btn mt-2"><i class="bi bi-floppy"></i></button>
        </div>
        <div class="mt-3">
            <label for="noteTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>">
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
                    echo "
                    <li class='mb-2'>
                        <input type='text' class='form-control";

                    if (count($errorsContent) != 0) {
                        if (array_key_exists($i, $errorsContent)) {
                            echo " is-invalid";
                        } else if ($content[$i] != '') {
                            echo " is-valid";
                        }
                    } else if ($content[$i] != '') {
                        echo " is-valid";
                    }

                    echo "' id='checklist' oninput='checkContent();' name='content[$i]' value='" . $content[$i] . "'>
                        <label class='errorContent' id='errorContent$i'></label>
                    </li>";
                    if (count($errorsContent) != 0) {
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
