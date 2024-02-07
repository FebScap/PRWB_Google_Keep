<?php

require_once "framework/Model.php";

class Shares extends Model {
    
    public function __construct(private int $note, private int $user, private int $editor)
    {}

    // Méthodes GET
    public function getNote(): int {
        return $this->note;
    }

    public function getUser(): int {
        return $this->user;
    }

    public function getEditor(): int {
        return $this->editor;
    }

    public function isEditor(): bool {
        return $this->editor == 1;
    }

    // Méthodes SET
    public function setEditor(int $editor): void {
        $this->editor = $editor;
    }

    public static function getAllSharesByNoteId(int $noteId) : array {
        $data = self::execute("SELECT * FROM `note_shares` WHERE note = :id", ["id" => $noteId])->fetchAll();
        $share = [];
        foreach ($data as $row) {
            $share[] = new Shares(
                $row["note"], 
                $row["user"],
                $row["editor"]
                );
        }
        return $share;
    }

    public static function getSharesByNoteIdAndUser(int $noteId, int $userid) : Shares {
        $data = self::execute("SELECT * FROM `note_shares` WHERE note = :id AND user = :user", ["id" => $noteId, "user" => $userid])->fetch();
        return new Shares($data["note"], $data["user"], $data["editor"]);
    }

    public static function isSharedBy(int $noteId, int $userId): bool {
        $query = self::execute("SELECT user, editor FROM `note_shares` WHERE note = :id AND user = :userId", ["id" => $noteId, "userId" => $userId]);
        return $query->rowCount() > 0;
    }

    public final static function delete(int $noteId, int $userId): void {
        self::execute("DELETE FROM note_shares WHERE note=:note AND user=:user", ["note"=>$noteId, "user"=>$userId]);
    }

    public final static function add(Shares $share): void {
        self::execute('INSERT INTO note_shares(note, user, editor) VALUES (:note, :user, :editor)', ['note' => $share->getNote(), 'user' => $share->getUser(), 'editor' => $share->getEditor()]);
    }

    public function persist() : Shares {
        self::execute("UPDATE note_shares SET editor=:editor WHERE note=:note AND user=:user", 
                        ["note"=>$this->note, "user"=>$this->user, "editor"=>$this->editor]);
        return $this;
    }
}