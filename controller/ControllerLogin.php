<?php
require_once "framework/Controller.php";

class ControllerLogin extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("login"))->show();
        /*if ($this->user_logged()) {
            $this->redirect("viewnotes");
        } else {
            (new View("login"))->show();
        }*/
    }
}
