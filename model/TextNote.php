<?php

require_once "framework/Model.php";

class TextNote extends Note {
    
    public function __construct(public string $id, public string $title, public int $owner, public string $created_at, public ?string $edited_at, public string $pinned, public string $archived, public string $weight, public string $content)
    {}

    public function persist() : Note|array {
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
            throw new Exception("Pas rdy encore");
        }
    }

    public function validate() : array {
        $errors = [];
        if (!(strlen($this->title) >= 3 && strlen($this->title) <= 25)) {
            $errors[] = "Title length must be between 3 and 25.";
        }
        return $errors;
    }
}