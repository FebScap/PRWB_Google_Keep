<?php

require_once "framework/Model.php";

class User extends Model {

    public function __construct(public string $mail, public string $hashed_password, public string $full_name, public ?string $role = "user", public ?int $id = null)
    {}
    
    public static function getAllUsers() : array {
        $data = self::execute("SELECT * FROM Users", [])->fetchAll();
        $users = [];
        foreach ($data as $row) {
            $users[] = new User($row["mail"], $row["hashed_password"], $row["full_name"], $row["role"]);
        }
        return $users;
    }

    public static function getByMail(string $mail) : User|false {
        $query = self::execute("SELECT * FROM Users WHERE mail = :mail", ["mail" => $mail]);
        $data = $query->fetch();
        if ($query->rowCount() == 0){
            return false;
        } else {
            return new User($data["mail"], $data["hashed_password"], $data["full_name"], $data["role"], $data["id"]);
        }
    }

    public static function getById(string $id) : User|false {
        $query = self::execute("SELECT * FROM Users WHERE id = :id", ["id" => $id]);
        $data = $query->fetch();
        if ($query->rowCount() == 0){
            return false;
        } else {
            return new User($data["mail"], $data["hashed_password"], $data["full_name"], $data["role"]);
        }
    }

    /*public function getNotes() : array {
        return Note::getNotes($this); //Implémenter getNotes dans Note.php
    }

    public function deleteNote(Note $note) : Note|false {
        return $note->delete($this); // Implémenter deleteNote dans Note.php
    }

    public function createNote(Note $note) : Note|array {
        return $note->persist($this);
    }*/

    public function getMail() {
        return $this->mail;
    }

    public function setMail(string $mail) {
        $this->mail = $mail;
    }

    public function getFullName() {
        return $this->full_name;
    }

    public function setFullName(string $fullname) {
        $this->full_name = $fullname;
    }

    public function getRole() {
        return $this->role;
    }

    public function getId() {
        return $this->id;
    }

    public function getPassword() {
        return $this->hashed_password;
    }

    private function setPassword(string $password) {
        $this->hashed_password = Tools::my_hash($password);
    }

    public static function checkPassword(string $clear_password, string $hash) : bool {
        return $hash === Tools::my_hash($clear_password);
    }

    public function validateMail() : array {
        $errors = [];
        if (!strlen($this->mail) > 0) {
            $errors[] = "Mail is required.";
        } 
        if (!(strlen($this->mail) >= 3)) {
            $errors[] = "Mail length must be at least 3.";
        } 
        if (!(preg_match("/^[a-zA-Z0-9][a-zA-Z0-9]*@[a-zA-Z0-9]+\.[a-zA-Z0-9.]+$/", $this->mail))) {
            $errors[] = "Mail must contain one and only one @, at least one dot, and start with a letter or a number.";
        }
        return $errors;
    }

    public function validateFullname() : array {
        $errors = [];
        if (strlen($this->full_name) < 3) {
            $errors[] = "Fullname length must be at least 3.";
        } 
        return $errors;
    }

    private static function validatePassword(string $password) : array {
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Password length must be at least 8.";
        } if (!((preg_match("/[A-Z]/", $password)) && preg_match("/\d/", $password) && preg_match("/['\";:,.\/?!\\-]/", $password))) {
            $errors[] = "Password must contain one uppercase letter, one number and one punctuation mark.";
        }
        return $errors;
    }

    public static function validatePasswords(string $password, string $password_confirm) : array {
        $errors = User::validatePassword($password);
        if ($password != $password_confirm) {
            $errors[] = "You have to enter twice the same password.";
        }
        return $errors;
    }

    public static function validateUnicity(string $mail) : array {
        $errors = [];
        $user = self::getByMail($mail);
        if ($user) {
            $errors[] = "This user already exists.";
        } 
        return $errors;
    }

    public static function validateLogin(string $mail, string $password) : array {
        $errors = [];
        $user = User::getByMail($mail);
        if ($user) {
            if (!self::checkPassword($password, $user->hashed_password)) {
                $errors[] = "Wrong password. Please try again.";
            }
        } else {
            $errors[] = "Can't find a user with the mail '$mail'. Please sign up.";
        }
        return $errors;
    }

    public static function isValidFullname(string $fullname) : bool {
        return strlen($fullname) >=3 ;
    }

    public static function isValidMail(string $mail): bool {
        // Vérifie si la longueur est d'au moins 3 caractères,
        // contient un @, contient au moins un point,
        // et commence par une lettre ou un chiffre.
        return strlen($mail) >= 3 && strpos($mail, '@') !== false && strpos($mail, '.') !== false && ctype_alnum($mail[0]);
    }
    

    public function persist() : User {
        if (self::getByMail($this->mail))
            self::execute("UPDATE Users SET hashed_password=:hashed_password, full_name=:full_name WHERE mail=:mail", 
                            ["mail"=>$this->mail, "hashed_password"=>$this->hashed_password, "full_name"=>$this->full_name]); //Voir si mail ok ou ID auto incr pour le where
        else
            self::execute("INSERT INTO Users(mail, hashed_password, full_name) VALUES (:mail, :hashed_password, :full_name)", 
                            ["mail"=>$this->mail, "hashed_password"=>$this->hashed_password, "full_name"=>$this->full_name]); 
        return $this;
    }

    public function changePassword(string $password) : void {
        $this->setPassword($password);
        $this->persist();
    }

    public function isAllowedToSee(int $idNote): bool {
        
        $loggedInUserId = $this->getId(); 
        
        $queryOwner = self::execute("SELECT * FROM notes WHERE id = :id AND owner = :userId", ["id" => $idNote, "userId" => $loggedInUserId]);
        
        $queryShares = self::execute("SELECT * FROM note_shares WHERE note = :id AND user = :userId", ["id" => $idNote, "userId" => $loggedInUserId]);
        
        
        return (($queryShares->rowCount() + $queryOwner->rowCount()) != 0);
    }

    public function isOwner(int $noteId): bool {
        
        $query = self::execute("SELECT owner FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
        if ($query->rowCount() === 0 || !$data) {
            return false;
        }
        
        return $data['owner'] === $this->getId();
    }
    
    
}
?>
