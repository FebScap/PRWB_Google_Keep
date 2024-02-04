<?php

require_once "framework/Model.php";

class ChecklistNote extends Note {
    
    public function __construct(private Note $note, private array $content){
        $this->content = $content ?? "";
    }

    public function getContent(): array {
        return $this->content;
    }
    public function setContent(array $content): void {
        $this->content = $content;
    }

    public static function getChecklistNoteById(int $noteId) : ChecklistNote|false {
        $query = self::execute("SELECT * FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $querycontent = self::execute("SELECT id, content, checked FROM checklist_note_items WHERE checklist_note = :noteId", ["noteId" => $noteId])->fetchAll();
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new TextNote(
                $data["id"],
                $data["title"],
                $data["owner"],
                $data["created_at"],
                $data["edited_at"],
                $data["pinned"],
                $data["archived"],
                $data["weight"],
                $querycontent[]
            );
        }
    }
}
