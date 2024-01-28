<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';

class ControllerSettings extends Controller{
    public function index() : void {
        $this->logout();;
    }
}
