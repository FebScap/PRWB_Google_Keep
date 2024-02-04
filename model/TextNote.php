<?php

require_once "framework/Model.php";

class TextNote extends Note {
    
    public function __construct(public int $id, public string $title, public int $owner, public string $created_at, public ?string $edited_at, public int $pinned, public int $archived, public int $weight, public ?string $content = null)
    {
        $this->content = $content ?? "";
    } //Modifier constructeur avec seulement 2 attributs : Note $note et string $content

    public function getContent(): string {
        return $this->content;
    }
    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function persist() : TextNote|array {
        if ($this->id == NULL){
            $errors = $this->validate();
            if (empty($errors)){
                
                self::execute('INSERT INTO Notes(title, owner, edited_at, pinned, archived, weight) VALUES (:title, :owner, null, 0, 0, 1)', ['title' => $this->title, 'owner' => $this->owner]);
                $note = self::getNoteById(self::lastInsertId());
                $this->id = $note->id;
                $this->created_at = $note->created_at;
                self::execute('INSERT INTO Text_Notes(content, id) VALUES (:content, :id)', ['content' => $this->content, 'id' => $this->id]);
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
                self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->id]);
            
            // Mise à jour dans la table 'Text_Notes'
                self::execute('UPDATE Text_Notes SET content = :content WHERE id = :id', ['content' => $this->content, 'id' => $this->id]);
            
                return $this;
            } else {
                return $errors;
            }
        }
    }

    /*public static function delete(int $id): void {
        // Supprimer les enregistrements dans la table note_shares liés à la note
        self::execute("DELETE FROM note_shares WHERE note = :id", ["id" => $id]);
    
        // Supprimer la note de la table text_notes
        self::execute("DELETE FROM text_notes WHERE id = :id", ["id" => $id]);
    
        // Supprimer la note de la table notes
        self::execute("DELETE FROM notes WHERE id = :id", ["id" => $id]);
    }*/
    
    public function validate() : array {
        $errors = [];
        if (!(strlen($this->title) >= 3 && strlen($this->title) <= 25)) {
            $errors[] = "Title length must be between 3 and 25.";
        }
        return $errors;
    }

    public static function getTextNoteById(int $noteId) : Note|false {
        $query = self::execute("SELECT * FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $querycontent = self::execute("SELECT content FROM text_notes WHERE id = :noteId", ["noteId" => $noteId])->fetch();
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
                $querycontent[0]
            );
        }
    }
}
