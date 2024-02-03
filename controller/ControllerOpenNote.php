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
                //instance de note à completer
                
                (new View("openchecklistNote"))->show();
            } else {
                $textnote = TextNote::getTextNoteById($_GET["param1"]);
                (new View("opentextNote"))->show(["textnote" => $textnote]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not be here"]);
        }
    }

    
}
