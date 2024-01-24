<?php
require_once "framework/Controller.php";

class ControllerViewArchives extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("viewarchives"))->show();
    }
}