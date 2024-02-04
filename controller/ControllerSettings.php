<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';

class ControllerSettings extends Controller{
    public function index() : void {
        $user = $this->get_user_or_false();
        (new View("settings"))->show(["user" => $user]);
    }

    public function changePassword() : void {
        $old_password = '';
        $new_password = '';
        $new_password_confirm = '';
        $errors = [];
        $user = $this->get_user_or_false();
        if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_confirm']) ) {
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $new_password_confirm = $_POST['new_password_confirm'];
            if (!User::checkPassword($old_password, $user->getPassword())) {
                array_push($errors, "Wrong password");
            }
            $errors = array_merge($errors, User::validatePasswords($new_password, $new_password_confirm));
            
            if (count($errors) == 0) { 
                $user->changePassword($new_password);
                $this->redirect("settings");
            }
        }
        (new View("changePassword"))->show(["old_password" => $old_password, "new_password_confirm" => $new_password_confirm,
                                             "new_password" => $new_password, "errors" => $errors]);

    }

    public function editProfile() : void {
        $user = $this->get_user_or_redirect();
        $fullname = $user->getFullname();
        $errorsFullname = [];

        if (isset($_POST['fullname'])){

            if (!User::isValidFullname($_POST['fullname'])){
                $errorsFullname = ["Fullname length must be at least 3."];
            }
            
            if (count($errorsFullname) == 0) {
                $user->setFullName($_POST['fullname']);
                $user->persist();
                $this->redirect("settings");
            }
        }
        (new View("editProfile"))->show(["fullname" => $fullname, "errorsFullname" => $errorsFullname]);
    }
}
