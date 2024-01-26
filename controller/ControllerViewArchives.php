<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';

class ControllerViewArchives extends Controller {
    //accueil du controlleur.
    public function index() : void {
        //$user = $this->get_user_or_redirect();
        $user = 1;

        $notes = Note::getAllArchivedNotesByUser($user);
        (new View("viewarchives"))->show(["notes" => $notes,
                                                "user" => $user]);
    }
}