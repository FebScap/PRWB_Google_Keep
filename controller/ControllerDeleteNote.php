<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';

class ControllerDeleteNote extends Controller {
    public function index() : void {
        
        
        
        
        (new View("deleteNote"))->show(["noteid" => $noteid = 22]);
    }

    public function delete() : void {
        Note::delete($_GET["param1"]);
        
        (new View("viewnotes"))->show();
    }
}
