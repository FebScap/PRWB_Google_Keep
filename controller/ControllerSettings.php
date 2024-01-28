<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';

class ControllerSettings extends Controller{
    public function index() : void {
        $user = $this->get_user_or_false();
        (new View("settings"))->show(["user" => $user]);
    }
}
