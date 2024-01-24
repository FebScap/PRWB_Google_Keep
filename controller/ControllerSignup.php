<?php
require_once "framework/Controller.php";

class ControllerSignup extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("signup"))->show();
    }
}