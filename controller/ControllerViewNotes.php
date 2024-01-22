<?php
require_once "framework/Controller.php";

class ControllerViewNotes extends Controller {
    //accueil du controlleur.
    //gère l'affichage des messages et le post
    public function index() : void {
        (new View("viewnotes"))->show();
    }
}