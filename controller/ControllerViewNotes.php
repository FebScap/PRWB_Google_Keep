<?php
require_once "framework/Controller.php";
require_once 'model/Note.php';
require_once 'model/ChecklistItem.php';
require_once 'model/User.php';
require_once 'model/Label.php';

class ControllerViewNotes extends Controller {
    //accueil du controlleur.
    public function index() : void {
        
        $user = $this->get_user_or_redirect()->getId();
        $pinnedNotes = Note::getAllPinnedNotesByUser($user);
        $notPinnedNotes = Note::getAllUnpinnedNotesByUser($user);
        $sharedBy = Note::getAllSharedBy($user);

        $nameSharedBy = [];
        foreach ($sharedBy as $id) {
            $nameSharedBy[] = User::getByID($id)->getFullName();
        }
        (new View("viewnotes"))->show(["pinnedNotes" => $pinnedNotes,
                                        "notPinnedNotes" => $notPinnedNotes,
                                        "sharedBy" => $sharedBy,
                                        "nameSharedBy" => $nameSharedBy,
                                        "user" => $user]);
    }

    //Button de création d'une nouvelle note texte
    public function  add_text_note() : void {
        $this->redirect("addTextNote");
    }

     //Button de création d'une nouvelle note checklist
     public function  add_checklist_note() : void {
        $this->redirect("addchecklistnote");
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
        $swap_note->setWeight(100);
        $swap_note->persist();
        $current_note->persist();
        $swap_note->setWeight($tmp);
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
        $swap_note->setWeight(100);
        $swap_note->persist();
        $current_note->persist();
        $swap_note->setWeight($tmp);
        $swap_note->persist();

        $this->redirect("viewnotes");
    }


    public function dragNote() : void {
        $pinnedOrUnpinned = $_POST["hasChanged"];

        $note = Note::getNoteById($_POST['itemId']);
        $noteWeight = $note->getWeight();

        if ($_POST['replacedItemId'] != -1) {
            $replacedNote = Note::getNoteById($_POST['replacedItemId']);
            $replacedWeight = $replacedNote->getWeight();

            //LE POID DE LA NOTE EST PLUS GRAND QUE CELLE QU'ELLE REMPLACE
            if ($noteWeight > $replacedWeight) {
                $notes = Note::getAllNotesByUser($this->get_user_or_false()->getId());
                $note->setWeight(99999);
                $note->persist();
                
                $actualWeight = $noteWeight;
                foreach ($notes as $current) {
                    if ($current->getWeight() < $noteWeight && $current->getWeight() >= $replacedWeight) {   
                        $current->setWeight($actualWeight--);
                        $current->persist();
                    }
                }
                $note->setWeight($replacedWeight);
                $note->persist();

            //LE POID DE LA NOTE EST PLUS PETIT QUE CELLE QU'ELLE REMPLACE
            } else {
                $notes = Note::getAllNotesByUserInverted($this->get_user_or_false()->getId());
                $replacedWeight--;
                $note->setWeight(99999);
                $note->persist();
                
                $actualWeight = $noteWeight;
                foreach ($notes as $current) {
                    if ($current->getWeight() > $noteWeight && $current->getWeight() <= $replacedWeight) {   
                        $current->setWeight($actualWeight++);
                        $current->persist();
                    }
                }
                $note->setWeight($replacedWeight);
                $note->persist();
            }
            // LA NOTE A ETE PLACEE A L'EXTREME GAUCHE D'UNE DES LISTE
        } else {
            $noteWeight = $note->getWeight();
            $notes = Note::getAllNotesByUserInverted($this->get_user_or_false()->getId());
           
            $replacedWeight = $notes[sizeof($notes) - 1]->getWeight();     
            $note->setWeight(99999);    
            $note->persist();       
            $actualWeight = $noteWeight;
            foreach ($notes as $current) {
                if ($current->getWeight() > $noteWeight && $current->getWeight() <= $replacedWeight) {   
                    $current->setWeight($actualWeight++);
                    $current->persist();
                }
            }
            $note->setWeight($replacedWeight);
            $note->persist();   
        }
        
        if ($pinnedOrUnpinned === "true") {
            if ($note->getPinned() == 1) {
                $note->setPinned(0);
            } else {
                $note->setPinned(1);
            }
            $note->persist();
        }
        
    }
}