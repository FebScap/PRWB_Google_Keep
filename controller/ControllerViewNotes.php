<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';
require_once 'model/User.php';

class ControllerViewNotes extends Controller {
    //accueil du controlleur.
    public function index() : void {
        
        /*$user = $this->get_user_or_redirect()->getId(); Appel à faire mais l'object user recu via get_user_or_redirect n'est pas complet, il manque l'id
        $user = 1; Forcer l'affichage d'un user via son id
        echo gettype($user);
        echo print_r($user);
        $mail=$user->getMail();
        echo print_r(User::getByMail($mail)->getId());
        $id = User::getByMail($mail)->getId();
        echo print_r($id);*/

        $user = User::getByMail($this->get_user_or_redirect()->getMail())->getId(); //Modifier cet appel si possible, voir commentaires au dessus
        $pinnedNotes = Note::getAllPinnedNotesByUser($user);
        $notPinnedNotes = Note::getAllUnpinnedNotesByUser($user);
        $sharedBy = Note::getAllSharedBy($user);
        $nameSharedBy = [];
        foreach ($sharedBy as $id) {
            $nameSharedBy[] = User::getByID($id)->full_name;
        }
        (new View("viewnotes"))->show(["pinnedNotes" => $pinnedNotes,
                                        "notPinnedNotes" => $notPinnedNotes,
                                        "sharedBy" => $sharedBy,
                                        "nameSharedBy" => $nameSharedBy,
                                        "user" => $user]);
    }

    //Button de création d'une nouvelle note texte
    public function  add_text_note() : void {
        //(new View("addtextnote"))->show();
        $this->redirect("addTextNote");
    }

     //Button de création d'une nouvelle note checklist
     public function  add_checklist_note() : void {
        (new View("addchecklistnote"))->show();
    }

     //Button de création d'une nouvelle note
     public function  tempviewshares() : void {
        (new View("viewshares"))->show();
    }

    public function moveUp() : void {
        if ($_POST["pinned"] == "pinned") {
            $list = Note::getAllPinnedNotesByUser($this->get_user_or_false()->getId());
        } else {
            $list = Note::getAllUnpinnedNotesByUser($this->get_user_or_false()->getId());
        }
        $current_note = $list[$_POST["pos"]];
        $swap_note = $list[$_POST["pos"]-1];
        $tmp = $current_note->getWeight();
        $current_note->setWeight($swap_note->getWeight());
        $swap_note->setWeight($tmp);
        $current_note->persist();
        $swap_note->persist();

        $this->redirect("viewnotes");
    }

    public function moveDown () : void {
        if ($_POST["pinned"] == "pinned") {
            $list = Note::getAllPinnedNotesByUser($this->get_user_or_false()->getId());
        } else {
            $list = Note::getAllUnpinnedNotesByUser($this->get_user_or_false()->getId());
        }
        $current_note = $list[$_POST["pos"]];
        $swap_note = $list[$_POST["pos"]+1];
        $tmp = $current_note->getWeight();
        $current_note->setWeight($swap_note->getWeight());
        $swap_note->setWeight($tmp);
        $current_note->persist();
        $swap_note->persist();

        $this->redirect("viewnotes");
    }
}