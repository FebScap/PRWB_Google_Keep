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
            (new View("login"))->show();
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
        $pseudo = '';
        $password = '';
        $password_confirm = '';
        $errors = [];

        if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
            $pseudo = trim($_POST['pseudo']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $member = new Member($pseudo, Tools::my_hash($password));
            $errors = Member::validate_unicity($pseudo);
            $errors = array_merge($errors, $member->validate());
            $errors = array_merge($errors, Member::validate_passwords($password, $password_confirm));

            if (count($errors) == 0) { 
                $member->persist(); //sauve l'utilisateur
                $this->log_user($member);
            }
        }
        (new View("signup"))->show(["pseudo" => $pseudo, "password" => $password, 
                                         "password_confirm" => $password_confirm, "errors" => $errors]);
    }
}