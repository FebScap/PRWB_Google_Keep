<?php

require_once "framework/Model.php";

class Label extends Model {
    
    public function __construct(public ?int $id, public string $label) {}

    public static function getNoteLabels(int $noteId): ?array {
        $query = self::execute("SELECT * FROM `note_labels` WHERE note = :noteId", ["noteId" => $noteId]);
        $labels = [];
    
        if (!$query) {
            return null; // Retourne null si aucun Labels n'est trouvé avec cet ID
        }

        // Crée une liste contenant tout les labels de la note
       foreach ($query as $row) {
            $labels[] = $row["label"];
        }
        return $labels;
    }

    public static function getAllExisingLabelsByUserIdMinusNoteID(int $userId, int $noteId): ?array {
        $query = self::execute("SELECT DISTINCT label FROM `note_labels` JOIN notes on notes.id = note_labels.note WHERE notes.owner = :userId", ['userId' => $userId]);
        $labels = [];
        
        if (!$query) {
            return null; // Retourne null si aucun Labels n'est trouvé
        }

        // Crée une liste contenant tout les labels d'un user
        foreach ($query as $row) {
            $labels[] = $row["label"];
        }

        //fait la soustraction des labels existants - ceux déjà indiqués sur la note
        return array_diff($labels, Label::getNoteLabels($noteId));
    }

    public static function getAllExisingLabelsByUserId(int $userId): ?array {
        $query = self::execute("SELECT DISTINCT label FROM `note_labels` JOIN notes on notes.id = note_labels.note WHERE notes.owner = :userId", ['userId' => $userId]);
        $labels = [];
        
        if (!$query) {
            return null; // Retourne null si aucun Labels n'est trouvé
        }

        // Crée une liste contenant tout les labels d'un user
        foreach ($query as $row) {
            $labels[] = $row["label"];
        }

        return $labels;
    }

    public static function getAllExisingLabels(): ?array {
        $query = self::execute("SELECT DISTINCT label FROM `note_labels`", []);
        $labels = [];
        
        if (!$query) {
            return null; // Retourne null si aucun Labels n'est trouvé
        }

        // Crée une liste contenant tout les labels existants
        foreach ($query as $row) {
            $labels[] = $row["label"];
        }

        return $labels;
    }

    public static function delete(int $noteId, string $label) : void {
        self::execute("DELETE FROM note_labels WHERE label=:label AND note=:note", ["note"=>$noteId, "label"=>$label]);
    }

    public static function add(int $noteId, string $label): void {
        self::execute('INSERT INTO note_labels(note, label) VALUES (:note, :label)', ['note' => $noteId, 'label' => $label]);
    }

    public static function validateLabel(string $label) : bool {
        return (strlen($label) >= Configuration::get("label_min_length") && strlen($label) <= Configuration::get("label_max_length"));
    }
}