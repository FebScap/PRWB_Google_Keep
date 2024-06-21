<!DOCTYPE html>
<html lang="en">
<head>
    <title>Session 1</title>
    <?php include('head.html'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const moveButton = document.getElementById("moveButton");
            const radioButtons = document.querySelectorAll('input[type="radio"][name="note"]');
            const sourceNotesDiv = document.querySelector(".source-notes");
            const targetNotesDiv = document.querySelector(".target-notes");

            // Désactive le bouton initialement
            moveButton.disabled = true;

            // Ajoute un écouteur d'événement sur chaque bouton radio
            radioButtons.forEach(radio => {
                radio.addEventListener("change", function() {
                    // Active le bouton si un bouton radio est sélectionné
                    moveButton.disabled = !document.querySelector('input[type="radio"][name="note"]:checked');
                });
            });

            // Ajoute un écouteur d'événement sur le bouton move
            moveButton.addEventListener("click", function() {
                const selectedNote = document.querySelector('input[type="radio"][name="note"]:checked');
                if (selectedNote) {
                    const noteId = selectedNote.value;

                    // Envoie la requête AJAX
                    $.ajax({
                        type: "POST",
                        url: "session1/swapNote",
                        data: {
                            noteId: noteId,
                            target_user: <?= $_GET["param2"] ?>
                        },
                        success: function (data) {
                            console.log(data);
                            // Supprime la note de la colonne source
                            const noteElement = selectedNote.parentElement;
                            noteElement.remove();
                            
                            // Ajoute la note à la colonne cible
                            const targetNoteElement = document.createElement("div");
                            targetNoteElement.innerHTML = `<label>${noteElement.textContent.trim()}</label>`;
                            targetNotesDiv.appendChild(targetNoteElement);
                    } 
                    })
                }
            });
        });
    </script>
</head>
<body data-bs-theme="dark">
    <form method="post" action="session1/sess1">
        <h2>Users</h2>
        <select name="source_user">
            <option value="0">-- Select a Source User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->getId() ?>"><?= $user->getFullName() ?></option>
            <?php endforeach; ?>
        </select>
        <select name="target_user">
            <option value="0">-- Select a Target User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->getId() ?>"><?= $user->getFullName() ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">OK</button>
    </form>
    
    <div class='errors'>
        <p><?php echo $error ?></p>
    </div>

    <?php if ($error == ""): ?>
        <h3>Notes for Users:</h3>
        <div>
            <div class="source-notes" style="display:inline-block; width:45%">
                <?php foreach ($source_notes as $note): ?>
                    <div>
                        <input type="radio" name="note" value="<?= $note->getId() ?>"> <label><?= $note->getTitle() ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="target-notes" style="display:inline-block; width:45%">
                <?php foreach ($target_notes as $note): ?>
                    <div>
                        <label><?= $note->getTitle() ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif ?>
    
    <br>
    <div>
        <button id="moveButton">Move selected note to target User</button>
    </div>
</body>
</html>
