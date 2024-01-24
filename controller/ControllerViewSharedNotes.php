<?php
require_once "framework/Controller.php";

class ControllerViewSharedNotes extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("viewsharednotes"))->show();
    }
}