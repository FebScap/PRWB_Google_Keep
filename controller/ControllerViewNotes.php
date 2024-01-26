<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';

class ControllerViewNotes extends Controller {
    //accueil du controlleur.
    public function index() : void {
        //$user = $this->get_user_or_redirect();
        $user = 1;

        $pinnedNotes = Note::getAllPinnedNotesByUser($user);
        $notPinnedNotes = Note::getAllUnpinnedNotesByUser($user);
        (new View("viewnotes"))->show(["pinnedNotes" => $pinnedNotes,
                                        "notPinnedNotes" => $notPinnedNotes,
                                        "user" => $user]);
    }

    //Button de création d'une nouvelle note
    public function  add_text_note() : void {
        (new View("addtextnote"))->show();
    }

     //Button de création d'une nouvelle note
     public function  add_checklist_note() : void {
        (new View("addchecklistnote"))->show();
    }

     //Button de création d'une nouvelle note
     public function  tempviewshares() : void {
        (new View("viewshares"))->show();
    }
}