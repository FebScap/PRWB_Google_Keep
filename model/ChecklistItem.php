<?php

require_once "framework/Model.php";

class ChecklistItem extends Model {
    
    public function __construct(public ?int $id, public int $checklist_note, public string $content, public int $checked) {}

    public function getId(): int {
        return $this->id;
    }

    public function getchecklist_note(): int {
        return $this->checklist_note;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getChecked(): int {
        return $this->checked;
    }

    public function isChecked(): bool {
        return $this->checked == 1;
    }
    
    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function setChecked(int $checked): void {
        $this->checked = $checked;
    }

    public function persist(): ChecklistItem {
        if ($this->id === null || $this->id == 0) {
            // Insérer un nouvel ChecklistItem
            self::execute('INSERT INTO checklist_note_items (checklist_note, content, checked) VALUES (:checklist_note, :content, :checked)', [
                'checklist_note' => $this->checklist_note,
                'content' => $this->content,
                'checked' => $this->checked
            ]);
            // Mettre à jour l'ID pour return
            $this->id = self::lastInsertId();
            return $this;

        } else {
            // Mettre à jour un ChecklistItem
            self::execute('UPDATE checklist_note_items SET content = :content, checked = :checked WHERE id = :id', [
                'content' => $this->content,
                'checked' => $this->checked,
                'id' => $this->id
            ]);
            //self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->checklist_note]);
            return $this;
        }
    }

    public function persist_date(): void {
        self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->checklist_note]);
    }
    

    public static function getItemById(int $itemId): ?ChecklistItem {
        $query = self::execute("SELECT * FROM checklist_note_items WHERE id = :itemId", ["itemId" => $itemId]);
        $data = $query->fetch();
    
        if (!$data) {
            return null; // Retourne null si aucun ChecklistItem n'est trouvé avec cet ID
        }
    
        // Crée un nouvel objet ChecklistItem avec les données récupérées de la base de données
        return new ChecklistItem(
            $data["id"],
            $data["checklist_note"],
            $data["content"],
            $data["checked"]
        );
    }

    public function delete() : void {
        // Supprimer l'élément de la table checklist_note_items
        self::execute("DELETE FROM checklist_note_items WHERE id = :id", ["id" => $this->id]);
    }
    
}