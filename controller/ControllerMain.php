<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';


class ControllerMain extends Controller {
    //si l'utilisateur est connecté, redirige vers son view notes.
    //sinon, produit la vue d'accueil.
    public function index() : void {
        if ($this->user_logged()) {
            $this->redirect("viewnotes");
        } else {
            (new View("login"))->show(["mail" => $mail='', "password" => $password='', "errors" => $errors=[]]);
        }
    }

    //gestion de la connexion d'un utilisateur
    public function login() : void {
        $mail = '';
        $password = '';
        $errors = [];
        if (isset($_POST['mail']) && isset($_POST['password'])) { //note : pourraient contenir des chaînes vides
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $errors = User::validateLogin($mail, $password);
            if (empty($errors)) {
                $this->log_user(User::getByMail($mail));
            }
        }
        (new View("login"))->show(["mail" => $mail, "password" => $password, "errors" => $errors]);
    }

    //gestion de l'inscription d'un utilisateur
    public function signup() : void {
        $mail = '';
        $fullname = '';
        $password = '';
        $password_confirm = '';
        $errors = [];

        if (isset($_POST['mail']) && isset($_POST['fullname']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
            $mail = trim($_POST['mail']);
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $user = new User($mail, Tools::my_hash($password), $fullname);
            $errors = User::validateUnicity($mail);
            $errors = array_merge($errors, $user->validateMail());
            $errors = array_merge($errors, $user->validateFullname());
            $errors = array_merge($errors, User::validatePasswords($password, $password_confirm));

            if (count($errors) == 0) { 
                $user->persist(); //sauve l'utilisateur
                $this->log_user($user);
            }
        }
        (new View("signup"))->show(["mail" => $mail, "password" => $password, 
                                         "password_confirm" => $password_confirm, "fullname" => $fullname, "errors" => $errors]);
    }
}?>