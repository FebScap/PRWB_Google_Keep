<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';
require_once 'model/TextNote.php';

class ControllerAddTextNote extends Controller{
    public function index() : void {
        $user = $this->get_user_or_redirect();
        $title = '';
        $content = '';
        $errors = [];
        
        if (isset($_POST['title'])) {
            $note = new TextNote(0, $_POST['title'], $user->getId(), "", null, 0, 0, 1, $_POST['content']);
            $title = $_POST['title'];
            $content = $_POST['content'];
            $errors = $note->validate();
            if (!Note::isUniqueTitlePerOwner($title, $user->getId())) {
                $errors = array_merge($errors, ["Title must be unique per User"]);
            }
            if (count($errors) == 0){
                TextNote::increaseAllWeightBy1($user->getId());
                $note->persist();
                $this->redirect("viewnotes");
            }

        }
        (new View("addTextNote"))->show(["title" => $title, "content" => $content, "errors" => $errors]);
    }

    public function check_title_unicity_service() : void {
        $res = "false";
    
        // Vérifie si des données POST ont été envoyées
        $post_data = json_decode(file_get_contents("php://input"), true);
    
        // Vérifie si les données POST contiennent un titre
        if (isset($post_data["title"]) && $post_data["title"] !== "") {
            // Vérifie l'unicité du titre
            $res = Note::isUniqueTitlePerOwner($post_data["title"], $this->get_user_or_redirect()->getId());
        }
    
        // Retourne la réponse au format JSON
        echo json_encode($res);
    }
    
}
