<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/User.php";
require_once "model/TextNote.php";

class ControllerOpenNote extends Controller { //Should be abstract
    //accueil du controlleur.
    public function index() : void {

        $user = $this->get_user_or_redirect()->getId();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToSee($_GET["param1"])) {
            if (Note::isCheckListNote($_GET["param1"])) {
                $textnote = TextNote::getTextNoteById($_GET["param1"]);
                (new View("openchecklistNote"))->show(["textnote" => $textnote]);
            } else {
                $textnote = TextNote::getTextNoteById($_GET["param1"]);
                (new View("opentextNote"))->show(["textnote" => $textnote, "user" => $this->get_user_or_false()]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not be here"]);
        }
    }

    public function archive() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setArchived(1);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function unarchive() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setArchived(0);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function pin() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setPinned(1);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function unpin() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setPinned(0);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function editnote() : void {
        $user = $this->get_user_or_redirect()->getId();
        $errors = [];
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToEdit($_GET["param1"])) {
            
            $textnote = TextNote::getTextNoteById($_GET["param1"]); 
            (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
            //$this->redirect("opennote", "saveNote", $textnote);
        }

        (new View("error"))->show(["error" => $error = "Oops, looks like you may not edit this note"]);        
    }

    public function saveNote() : void {
        
        //$title = $_POST['title'];
        $errors = [];
        $textnote = TextNote::getTextNoteById($_POST["id"]);

        if (isset($_POST['title'])){
            
            $title = $_POST['title'];
            echo $title;

            if (!Note::validateTitle($_POST['title'])){
                echo $title;

                $errors = ["Title length must be at least 3 and maximum 25."];
            }
            
            if (count($errors) == 0) {
                $textnote->setTitle($_POST["title"]);
                $textnote->setContent($_POST["content"]); //Je ne sais pas pq il me dit que la méthode est undefined alors qu'elle l'est
                $textnote->persist();
                $this->redirect("opennote", "index", $textnote->getId());
            }
            (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
        }
        (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
    }
}
