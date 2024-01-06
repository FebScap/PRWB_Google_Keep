<?php

require_once "framework/Model.php"

class User extends Model {

    public function __construct(public string $mail, public string $hashed_password, public string $full_name, public ?string $role = "user", public ?int $id = NULL)
    {
        
    }
    
    public static function get_all_users() : array {
        $data = self::execute("SELECT * FROM Users", [])->fetchAll();
        $users = [];
        foreach ($data as $row) {
            $users[] = new User($row["mail"], $row["hashed_password"], $row["full_name"], $row["role"]);
        }
        return $users;
    }
}