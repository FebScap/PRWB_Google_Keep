<?php
require_once "framework/Controller.php";

class ControllerLogin extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("login"))->show();
    }
}