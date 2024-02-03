<?php
require_once "framework/Controller.php";
require_once "model/Note.php";

class ControllerOpenNote extends Controller { //Should be abstract
    //accueil du controlleur.
    public function index() : void {

        //$user = $this->get_user_or_redirect()->getId();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"])) {
            if (Note::isCheckListNote($_GET["param1"])) {
                //instance de note
                
                (new View("openchecklistNote"))->show();
            } else {
                
                (new View("openTextNote"))->show();
            }
        } else {
            //echo isset($_GET["note"]);
            //echo is_numeric($_GET["note"]);
            (new View("error"))->show(["error" => $error = "pas le droit"]);
        }
    }
}
