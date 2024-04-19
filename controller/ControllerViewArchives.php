<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';
require_once 'model/ChecklistItem.php';
require_once 'model/User.php';

class ControllerViewArchives extends Controller {
    //accueil du controlleur.
    public function index() : void {
        $user = $this->get_user_or_redirect()->getId();

        $notes = Note::getAllArchivedNotesByUser($user);
        $sharedBy = Note::getAllSharedBy($user);
        $nameSharedBy = [];
        foreach ($sharedBy as $id) {
            $nameSharedBy[] = User::getByID($id)->getFullName();
        }

        (new View("viewarchives"))->show(["notes" => $notes,
                                                "sharedBy" => $sharedBy,
                                                "nameSharedBy" => $nameSharedBy,
                                                "user" => $user]);
    }
}