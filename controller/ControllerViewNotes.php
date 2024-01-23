<?php
require_once "framework/Controller.php";

class ControllerViewNotes extends Controller {
    
    public function index() : void {
        (new View("viewnotes"))->show();
    }
}