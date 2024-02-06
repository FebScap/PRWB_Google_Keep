<?php

require_once "framework/Model.php";

class Shares extends Model {
    
    public function __construct(private int $note, private int $user, private int $editor)
    {}

    // Méthodes GET
    public function getNote(): int {
        return $this->note;
    }

    public function getUser(): string {
        return $this->user;
    }

    public function isEditor(): bool {
        return $this->editor == 1;
    }

    public static function getAllSharesByNoteId(int $noteId) : array {
        $data = self::execute("SELECT * FROM `note_shares` WHERE note = :id", ["id" => $noteId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Shares(
                $row["note"], 
                $row["user"],
                $row["editor"]
                );
        }
        return $notes;
    }

    public static function isSharedBy(int $noteId, int $userId): bool {
        $query = self::execute("SELECT user, editor FROM `note_shares` WHERE note = :id AND user = :userId", ["id" => $noteId, "userId" => $userId]);
        $data = $query->fetchAll();
        return sizeof($data) > 0;
    }
}