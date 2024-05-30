<!DOCTYPE html>
<html>
<head>
    <title>My notes - Editer les labels</title>
    <?php include('head.html'); ?>
    <script src="js/ViewLabels.js"></script>
    <script src="js/RemoveNotJS.js"></script>
</head>
<body id="<?= $note->getId() ?>" data-bs-theme="dark" >
    <div class="container-fluid d-flex flex-column"> 
            <div class="container-fluid d-flex justify-content-start">
                <a id="backButton" class="nav-link me-4 fs-2 mt-2" href="opennote/index/<?= $note->getId() ?>"><i class="bi bi-chevron-left fw-bold"></i></a>
            </div>
            <h2 class="h2 fs-5 ms-2 mt-3">Labels :</h2>
            <div id='labeldiv'>
                <?php for ($i=0; $i<count($labelList); $i++) : ?> 
                    <form class='input-group flex-nowrap mt-2' method='post' action='OpenNote/deleteLabel' id='formdelete'>
                        <input disabled id='checklist' form="formdelete" type='text' class='form-control' value='<?= $labelList[$i] ?>' aria-describedby='basic-addon1'>
                        <input type="hidden" name="noteId" value="<?= $note->getId() ?>"/>
                        <button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' name='label' value='<?= $labelList[$i] ?>'><i class='bi bi-dash-lg'></i></button>
                    </form>
                <?php endfor ?>
            </div>

            <h2 class="h2 fs-6 mt-4 ms-2">Add a new label</h2>
            <div id="newItemDiv">
                <form class='input-group flex-nowrap mt-2' method='post' action='OpenNote/addLabel' id='formaddlabel'>
                    <input id='addlabel' name="labeltitle" form='formaddlabel' type='text' class='form-control' list="existingLabels" placeholder='Type to search or create' aria-describedby='basic-addon1'>  
                    <button id="addbutton" class='btn btn-primary text-white' type='submit' form='formaddlabel' name='id' value='<?= $note->getId() ?>'><i class="bi bi-plus-lg"></i></button>
                </form>
                <?php if (count($errors) != 0) : ?>
                    <ul class="mt-1">
                        <?php foreach ($errors as $error): ?>
                            <li class="text-danger"><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif ?>

                <datalist id="existingLabels">
                    <?php foreach ($existingLabels as $label) : ?>
                        <option value="<?= $label ?>"></option>
                    <?php endforeach ?>    
                </datalist>
            </div>
        </div>
        <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" form="save" value="<?= $note->getId() ?>">
    </div>
    <?php include('footer.html'); ?>
</body>
</html>
