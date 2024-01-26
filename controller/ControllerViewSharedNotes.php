<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';
require_once 'model/User.php';

class ControllerViewSharedNotes extends Controller {
    public function index() : void {
        $this->sharedby();
    }

    //profil de l'utilisateur connecté ou donné
    public function sharedby() : void {
        //$user = $this->get_user_or_redirect();
        $user = 1;

        $notes = Note::getAllArchivedNotesByUser($user);

        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $userFrom = User::getById($_GET["param1"]);
        }
        (new View("viewsharednotes"))->show(["notes" => $notes,
                                                "from" => $userFrom]);                                       
    }

}