<?php

require_once "framework/Model.php";

class Note extends Model {

    public function __construct(public string $title, public int $owner, public string $edited_at, public int $pinned, public int $archived, public float $weight)
    {

    }

    public static function getAllNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["title"],
                $row["owner"],
                $row["id"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;

    public static function getAllPinnedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 1 ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["title"],
                $row["owner"],
                $row["id"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
        }
    }

    public static function getAllArchivedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId AND archived = 1", ["userId" => $userId])->fetchAll();
        $notes = [];
    
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["title"],
                $row["owner"],
                $row["id"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
    
        return $notes;
    }
    

    public static function getNoteById(int $noteId) : Note|false {
        $query = self::execute("SELECT * FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Note(
                $data["title"],
                $data["owner"],
                $data["id"],
                $data["created_at"],
                $data["edited_at"],
                $data["pinned"],
                $data["archived"],
                $data["weight"]
            );
        }
    }

    public static function getTitle(int $noteId) : string {
        $query = self::execute("SELECT title FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
    
        if ($query->rowCount() === 0 || !$data) {
            // Aucune note trouvée avec l'ID spécifié
            return null;
        }
    
        return $data["title"];
    }
    
    public static function getWeight(int $noteId) : int {
        $query = self::execute("SELECT weight FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
    
        if ($query->rowCount() === 0 || !$data) {
            // Aucune note trouvée avec l'ID spécifié
            return false;
        }
    
        return $data["weight"];
    }

    public static function increaseWeight(int $noteId): void {
        self::execute("UPDATE notes SET weight = weight + 1 WHERE id = :noteId", ["noteId" => $noteId]);
    }

    public static function decreaseWeight(int $noteId): void {
        self::execute("UPDATE notes SET weight = weight - 1 WHERE id = :noteId", ["noteId" => $noteId]);
    }
     
}
