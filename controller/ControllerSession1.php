<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';


class ControllerSession1 extends Controller{
    public function index() : void {
        $user = $this->get_user_or_redirect();
        $users = User::getAllUsers();
        $error = "You must choose two different users";
        $source_user = "";
        $target_user = "";
        $source_notes = [];
        $target_notes = [];

        if ($user->getRole() == "admin") {
            if (isset($_GET['param1'])) {
                $source_user = User::getById($_GET['param1']);
            }
            if (isset($_GET['param2'])) {
                $target_user = User::getById($_GET['param2']);
            }
            if ($source_user != $target_user && $_GET['param1'] != 0 && $_GET['param2'] != 0) {
                $error = "";
                $source_notes = Note::getAllNotesByUser($_GET['param1']);
                $target_notes = Note::getAllNotesByUser($_GET['param2']);
                (new View("session1"))->show(["users" => $users, "error" => $error, "source_notes" => $source_notes, "target_notes" => $target_notes]);
            } else {
                (new View("session1"))->show(["users" => $users, "error" => $error]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you don't have the rights to do that"]);
        }
    }

    public function swapNote () {
        $note = Note::getNoteById($_POST['noteId']);
        
        $note->setOwner($_POST["target_user"]);
        $note->setWeight(100);
        $note->setPinned(1);
        $note->setArchived(0);
        $note->persist();

    }

    public function sess1() :void {
        $user = $this->get_user_or_redirect();
        $error = "You must choose two different users";


        if ($user->getRole() == "admin") {
            if (is_numeric($_POST['source_user']) && is_numeric($_POST['target_user'])) {
                $this->redirect("Session1", "index", $_POST['source_user'], $_POST['target_user']);
            }
            (new View("session1"))->show(["users" => $users, "error" => $error]);
        }
        (new View("error"))->show(["error" => $error = "Oops, looks like you don't have the rights to do that"]);
        
    }
}
