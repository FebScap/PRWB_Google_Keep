<!DOCTYPE html>
<html>
<head>
    <title>My notes - Editer les labels</title>
    <?php include('head.html'); ?>
    <script src="js/ViewLabels.js"></script>
    <script src="js/RemoveNotJS.js"></script>
</head>
<body id="<?= $textnote->getId() ?> data-bs-theme="dark">
    <div class="container-fluid d-flex flex-column"> 
            <div class="container-fluid d-flex justify-content-start">
                <a id="backButton" class="nav-link me-4 fs-2" href="opennote/index/<?= $textnote->getId() ?>"><i class="bi bi-chevron-left"></i></a>
            </div>
                <h2 class="h2 fs-5 ms-2">Labels</h2>
                <form class='notJS' method='post' action='OpenNote/deleteItem' id='formdelete'></form>
                    <div id='itemDiv'>
                        <?php for ($i=0; $i<count($labelList); $i++) : ?>
                            <div>
                                <div class='input-group flex-nowrap mt-2'>
                                    <?php if ( $labelList[$i]->getChecked() == 1) : ?>
                                        <button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-check-square'></i></button>
                                    <?php else : ?>
                                        echo"<button class='btn btn-outline-secondary text-white' type='button' disabled><i class='bi bi-square'></i></button>";
                                    <?php endif ?>
                                        <input id='checklist' oninput='checkAll();' form='save' name='content[<?= $i ?>]' type='text' class='form-control' value='<?= $labelList[$i]->getContent() ?>' placeholder='Item title' aria-describedby='basic-addon1'>
                                        <button class='btn btn-danger text-white buttondelete' type='submit' form='formdelete' name='itemid' value='<?= $labelList[$i]->getId() ?>'><i class='bi bi-dash-lg' form='formdelete'></i></button>
                                </div>
                            </div>
                            
                        <?php endfor ?>
            </div>

            <h2 class="h2 fs-5 mt-4 ms-2">New Label</h2>
            <div id="newItemDiv">
                <form class='notJS input-group flex-nowrap mt-2' method='post' action='OpenNote/addItem' id='formadd'>
                    <?php if (isset($itemtitle)) : ?>
                        <input id='additem' name='itemtitle' value="<?= $itemtitle ?>" form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                    <?php else : ?>
                        <input id='additem' name='itemtitle' form='formadd' type='text' class='form-control' placeholder='New item name' aria-describedby='basic-addon1'>  
                    <?php endif ?>
                    <button id="addbutton" class='btn btn-primary text-white' type='submit' form='formadd' name='id' value='<?= $textnote->getId() ?>'><i class="bi bi-plus-lg"></i></button>
                </form>
            </div>
        </div>
        <input id="id" name="id" type="hidden" class="form-control" placeholder="Title" form="save" value="<?= $textnote->getId() ?>">
    </div>



    <?php include('footer.html'); ?>
</body>
</html>
