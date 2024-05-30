<?php

require_once "framework/Model.php";

class Label extends Model {
    
    public function __construct(public ?int $id, public string $label) {}

    // Méthodes GET
    public function getId(): int {
        return $this->id;
    }

    public function getLabel(): string {
        return $this->label;
    }

     // Méthodes SET
     public function setLabel(string $label): void {
        $this->label = $label;
    }

    public static function getNoteLabels(int $noteId): ?array {
        $query = self::execute("SELECT * FROM `note_labels` WHERE note = :noteId", ["noteId" => $noteId]);
        $labels = [];
    
        if (!$query) {
            return null; // Retourne null si aucun Labels n'est trouvé avec cet ID
        }

        // Crée une liste contenant tout les labels de la note
        foreach ($query as $row) {
            $labels[] = new Label(
                $row["note"], 
                $row["label"]
                );
        }
        return $labels;
    }

    public static function getNoteLabelsString(int $noteId): ?array {
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

    public static function getLabelByNoteIdAndLabel(int $noteId, string $label): ?Label {
        $query = self::execute("SELECT * FROM note_labels WHERE id = :noteId AND label = :label", ["noteId" => $noteId, "label" => $label]);
        $data = $query->fetch();
    
        if (!$data) {
            return null; // Retourne null si aucun Label n'est trouvé avec cet ID
        }
    
        // Crée un nouvel objet Label avec les données récupérées de la base de données
        return new Label(
            $data["id"],
            $data["label"]
        );
    }

    public static function getAllExisingLabelsByUserId(int $userId): ?array {
        $query = self::execute("SELECT DISTINCT label FROM `note_labels` JOIN notes on notes.id = note_labels.note WHERE notes.owner = :userId;", ['userId' => $userId]);
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

    public function delete() : void {
        self::execute("DELETE FROM note_labels WHERE label=:label AND note=:note", ["note"=>$this->id, "label"=>$this->label]);
    }

    public final static function add(Label $label): void {
        self::execute('INSERT INTO note_labels(note, label) VALUES (:note, :label)', ['note' => $label->id, 'user' => $label->label]);
    }
}