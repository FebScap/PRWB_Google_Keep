<?php
require_once "framework/Controller.php";

class ControllerOpenNote extends Controller {
    //accueil du controlleur.
    public function index() : void {
        (new View("opentextnote"))->show();
    }
    
}
