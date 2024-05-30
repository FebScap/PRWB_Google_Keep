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
            <form class='notJS' method='post' action='OpenNote/deleteItem' id='formdelete'></form>
            <div id='labeldiv'>
                <?php for ($i=0; $i<count($labelList); $i++) : ?>
                    <div>
                        <div class='input-group flex-nowrap mt-2'>
                            <input disabled id='checklist' name='label[<?= $i ?>]' type='text' class='form-control' value='<?= $labelList[$i] ?>' placeholder='Item title' aria-describedby='basic-addon1'>
                            <button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' name='itemid' value='<?= $labelList[$i] ?>'><i class='bi bi-dash-lg' form='formdelete'></i></button>
                        </div>
                    </div>
                    
                <?php endfor ?>
            </div>

            <h2 class="h2 fs-6 mt-4 ms-2">Add a new label</h2>
            <div id="newItemDiv">
                <form class='input-group flex-nowrap mt-2' method='post' action='OpenNote/addItem' id='formaddlabel'>
                    <input id='addlabel' form='formaddlabel' type='text' class='form-control' list="existingLabels" placeholder='Type to search or create' aria-describedby='basic-addon1'>  
                    <button id="addbutton" class='btn btn-primary text-white' type='submit' form='formaddlabel' name='id' value='<?= $note->getId() ?>'><i class="bi bi-plus-lg"></i></button>
                </form>
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
