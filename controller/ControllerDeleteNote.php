<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';

class ControllerDeleteNote extends Controller {
    public function index() : void {
        //verif si note existe et isnumeric et si a le droit de supp

        $user = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"]) && Note::isANote($_GET["param1"])) {
        
            $note = Note::getNoteById($_GET["param1"]);
            if ($user->isOwner($note->getId()) && $note->isArchived()) {
                (new View("deleteNote"))->show(["noteid" => $_GET["param1"]]);
            }
            
            (new View("error"))->show(["error" => $error = "Oops, looks like you don't have the rights to do that"]);
        
        }
        (new View("error"))->show(["error" => $error = "Oops, looks like there's nothing here"]);
    }

    public function delete() : void {
        Note::delete($_GET["param1"]);
        
        $this->redirect("viewnotes");
    }
}
