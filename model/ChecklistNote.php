<?php

require_once "framework/Model.php";

class ChecklistNote extends Note {
    
    public function __construct(public int $id, public string $title, public int $owner, public string $created_at, public ?string $edited_at, public int $pinned, public int $archived, public int $weight, public ?array $content = null)
    {
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
            return new ChecklistNote($data["id"],
            $data["title"],
            $data["owner"],
            $data["created_at"],
            $data["edited_at"],
            $data["pinned"],
            $data["archived"],
            $data["weight"], 
            Note::getItemListById($data["id"]))
            ;
        }
    }

    public static function validateContent(array $contentArray): array {
        $errors = array();

        for ($i = 0 ; $i < count($contentArray) ; $i++) {
            foreach ($contentArray as $actual) {
                if ($actual != '' && $actual === $contentArray[$i]) {
                    $errors[$i] = "Must be unique";
                }
            }
        } 
    
        return $errors;
    }

    public function persist() : ChecklistNote|array {
        if ($this->id == NULL){
            $errors = $this->validate();
            if (empty($errors)){
                
                self::execute('INSERT INTO Notes(title, owner, edited_at, pinned, archived, weight) VALUES (:title, :owner, null, 0, 0, 1)', ['title' => $this->title, 'owner' => $this->owner]);
                $note = self::getNoteById(self::lastInsertId());
                $this->id = $note->getId();
                $this->created_at = $note->getCreatedAt();
                self::execute('INSERT INTO checklist_notes (id) VALUES (:id)', ['id' => $this->id]);
                return $this;
            } else {
                return $errors;
            }
        } else {
            // Mise à jour d'une note existante
            $errors = $this->validate();
            if (empty($errors)){
            // Mise à jour dans la table 'Notes'
                self::execute('UPDATE Notes SET weight = :weight WHERE id = :id', ['weight' => $this->weight, 'id' => $this->id]);
                self::execute('UPDATE Notes SET title = :title WHERE id = :id', ['title' => $this->title, 'id' => $this->id]);
                //self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->id]);
                return $this;
            } else {
                return $errors;
            }
        }
    }
    
}
