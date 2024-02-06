<?php

require_once "framework/Model.php";

class ChecklistItem extends Model {
    
    public function __construct(private ?int $id, private int $checklist_note, private string $content, private int $checked) {}

    public function getId(): int {
        return $this->id;
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

    public function setChecked(int $checked): void {
        $this->checked = $checked;
    }

    public function persist(): ChecklistItem {
        if ($this->id === null) {
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
            self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->checklist_note]);
            return $this;
        }
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
    
}