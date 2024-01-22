<?php
require_once "framework/Controller.php";

class ControllerViewNotes extends Controller {
    public function index() : void {
        echo "<h1>My Notes</h1>";
    }
}