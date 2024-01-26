<?php

require_once "framework/Model.php";

class Note extends Model {
    
    public function __construct(public string $id, public string $title, public int $owner, public string $created_at, public ?string $edited_at, public string $pinned, public string $archived, public string $weight)
    {
        
    }

    public static function getAllNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllPinnedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 1 and archived = 0 ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }
    

    public static function getAllUnpinnedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 0 and archived = 0 ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }



    public static function getAllArchivedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId AND archived = 1", ["userId" => $userId])->fetchAll();
        $notes = [];
    
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
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
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
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
