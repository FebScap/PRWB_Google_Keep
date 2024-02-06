<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/User.php";
require_once "model/TextNote.php";
require_once "model/ChecklistNote.php";
require_once "model/Shares.php";

class ControllerViewShares extends Controller {
    //accueil du controlleur.
    public function index() : void {
        $user = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"])) {
            if ($user->isOwner($_GET["param1"])) {
                $users = User::getAllUsersExeptOne($user->id);
                $shares = Shares::getAllSharesByNoteId($_GET["param1"]);
            (new View("viewshares"))->show(["user"=>$user, "users"=>$users, "shares"=>$shares]);
            } else {
                (new View("error"))->show(["error"=>$error = "You may not acces to this note."]);
            }
            
        } else {
            (new View("error"))->show(["error"=>$error = "This note doesn't exist."]);
        }
       
    }
}