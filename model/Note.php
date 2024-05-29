<?php

require_once "framework/Model.php";
require_once "model/ChecklistItem.php";

 class Note extends Model {
    
    public function __construct(public int $id, public string $title, public int $owner, public string $created_at, public ?string $edited_at, public int $pinned, public int $archived, public int $weight) {

    }

    // Méthodes GET
    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getOwner(): int {
        return $this->owner;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function getEditedAt(): ?string {
        return $this->edited_at;
    }

    public function getPinned(): int {
        return $this->pinned;
    }

    public function getArchived(): int {
        return $this->archived;
    }

    public function getWeight(): int {
        return $this->weight;
    }

    // Méthodes SET
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setOwner(int $owner): void {
        $this->owner = $owner;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }

    public function setEditedAt(?string $edited_at): void {
        $this->edited_at = $edited_at;
    }

    public function setPinned(int $pinned): void {
        $this->pinned = $pinned;
    }

    public function setArchived(int $archived): void {
        $this->archived = $archived;
    }

    public function setWeight(int $weight): void {
        $this->weight = $weight;
    }

    // Méthodes IS
    public function isPinned(): bool {
        return $this->pinned == 1;
    }

    public function isArchived(): bool {
        return $this->archived == 1;
    }

    public function isShared(): bool {
        $query = self::execute("SELECT COUNT(*) as count FROM note_shares WHERE note = :noteId", ["noteId" => $this->id]);
        $data = $query->fetch();
    
        return ($data['count'] > 0);
    }

    public function isEditable(): bool {
        $query = self::execute("SELECT COUNT(*) as count FROM note_shares WHERE note = :noteId AND editor = 1", ["noteId" => $this->id]);
        $data = $query->fetch();
    
        return ($data['count'] > 0);
    }

    public static function isANote(int $noteId): bool {
        $query = self::execute("SELECT id FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
        return $query->rowCount() > 0;
    }

    public static function isCheckListNote(int $id): bool {
        $query = self::execute("SELECT * FROM checklist_notes WHERE id = :id", ["id" => $id]);
        return $query->rowCount() > 0;
    }
    

    public static function getAllNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllNotesByUserInverted(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId ORDER BY weight", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllPinnedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 1 and archived = 0 ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllPinnedNotesByUserInverted(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 1 and archived = 0 ORDER BY weight", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }
    
    public static function getAllUnpinnedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 0 and archived = 0 ORDER BY weight DESC", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllUnpinnedNotesByUserInverted(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId and pinned = 0 and archived = 0 ORDER BY weight", ["userId" => $userId])->fetchAll();
        $notes = [];
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
        return $notes;
    }

    public static function getAllArchivedNotesByUser(int $userId) : array {
        $data = self::execute("SELECT * FROM notes WHERE owner = :userId AND archived = 1", ["userId" => $userId])->fetchAll();
        $notes = [];
    
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
    
        return $notes;
    }
    
    public static function getAllSharedNotesEditorByUserId(int $userId) : array {
        $data = self::execute(
            "SELECT notes.id, notes.title, notes.owner, notes.created_at, notes.edited_at, notes.pinned, notes.archived, notes.weight 
            FROM note_shares JOIN notes on notes.id = note_shares.note 
            WHERE user = :userId AND editor = 1", 
            ["userId" => $userId])->fetchAll();
        $notes = [];
    
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
    
        return $notes;
    }

    public static function getAllSharedNotesReaderByUserId(int $userId) : array {
        $data = self::execute(
            "SELECT notes.id, notes.title, notes.owner, notes.created_at, notes.edited_at, notes.pinned, notes.archived, notes.weight 
            FROM note_shares JOIN notes on notes.id = note_shares.note 
            WHERE user = :userId AND editor = 0", 
            ["userId" => $userId])->fetchAll();
        $notes = [];
    
        foreach ($data as $row) {
            $notes[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $row["created_at"],
                $row["edited_at"],
                $row["pinned"],
                $row["archived"],
                $row["weight"]
            );
        }
    
        return $notes;
    }

    public static function getAllSharedBy(int $userId) : array {
        $data = self::execute(
            "SELECT DISTINCT owner FROM note_shares JOIN notes on notes.id = note_shares.note WHERE user = :userId", 
            ["userId" => $userId])->fetchAll();
        $sharedby = [];
    
        foreach ($data as $row) {
            $sharedby[] = $row["owner"];
        }
        return $sharedby;
    }

    public static function getNoteById(int $noteId) : Note|false {
        $query = self::execute("SELECT * FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Note(
                $data["id"],
                $data["title"],
                $data["owner"],
                $data["created_at"],
                $data["edited_at"],
                $data["pinned"],
                $data["archived"],
                $data["weight"]
            );
        }
    }

    public static function getTitleById(int $noteId) : string {
        $query = self::execute("SELECT title FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
    
        if ($query->rowCount() === 0 || !$data) {
            // Aucune note trouvée avec l'ID spécifié
            return null;
        }
    
        return $data["title"];
    }
    
    public static function getWeightbyId(int $noteId) : int {
        $query = self::execute("SELECT weight FROM notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
    
        if ($query->rowCount() === 0 || !$data) {
            // Aucune note trouvée avec l'ID spécifié
            return false;
        }
    
        return $data["weight"];
    }

    public static function increaseWeight(int $noteId): void {
        self::execute("UPDATE notes SET weight = weight + 1 WHERE id = :noteId", ["noteId" => $noteId]);
    }

    public static function decreaseWeight(int $noteId): void {
        self::execute("UPDATE notes SET weight = weight - 1 WHERE id = :noteId", ["noteId" => $noteId]);
    }
    
    public static function validateTitle(string $title) : bool {
        return (strlen($title) >= Configuration::get("title_min_length") && strlen($title) <= Configuration::get("title_max_length"));
    }

    public static function increaseAllWeightBy1(int $id) : void { //Augmente le poids de toutes les nutes d'un user afin d'inserer une nouvelle note au poids de 1
        $notes = Note::getAllNotesByUser($id);
        foreach ($notes as $note){
            $note->setWeight($note->getWeight() + 1);
            $note = new Note($note->getId(),
                                    $note->getTitle(),
                                    $note->getOwner(),
                                    $note->getCreatedAt(),
                                    $note->getEditedAt(),
                                    $note->getPinned(),
                                    $note->getArchived(),
                                    $note->getWeight());
            $note->persist();
        }
    }
 

    public function persist() : Note|array {
        if ($this->id == NULL){
            $errors = $this->validate();
            if (empty($errors)){
                
                self::execute('INSERT INTO Notes(title, owner, edited_at, pinned, archived, weight) VALUES (:title, :owner, null, 0, 0, 1)', ['title' => $this->title, 'owner' => $this->owner]);
                $note = self::getNoteById(self::lastInsertId());
                $this->id = $note->id;
                $this->created_at = $note->created_at;
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
                self::execute('UPDATE Notes SET archived = :archived WHERE id = :id', ['archived' => $this->archived, 'id' => $this->id]);
                self::execute('UPDATE Notes SET pinned = :pinned WHERE id = :id', ['pinned' => $this->pinned, 'id' => $this->id]);
                //self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->id]);
                return $this;
            } else {
                return $errors;
            }
        }
    }

    public function persist_date() : void {
        self::execute('UPDATE Notes SET edited_at = NOW() WHERE id = :id', ['id' => $this->id]);
    }

    public function validate() : array {
        $errors = [];
        if (!(strlen($this->title) >= Configuration::get("title_min_length") && strlen($this->title) <= Configuration::get("title_max_length"))) {
            $errors[] = "Title length must be between 3 and 25.";
        }
        return $errors;
    }


    public final static function delete(int $id): void {
        
        // Supprimer les enregistrements dans la table checklist_note_items liés à la note
        self::execute("DELETE FROM checklist_note_items WHERE checklist_note = :id", ["id" => $id]);
        
        // Supprimer les enregistrements dans la table checklist_notes liés à la note
        self::execute("DELETE FROM checklist_notes WHERE id = :id", ["id" => $id]);
        
        // Supprimer les enregistrements dans la table note_shares liés à la note
        self::execute("DELETE FROM note_shares WHERE note = :id", ["id" => $id]);

        //Supprimer les enregistrements dans la table note_labels liés à la note
        self::execute("DELETE FROM note_labels WHERE note = :id", ["id" => $id]);

        // Supprimer la note de la table text_notes
        self::execute("DELETE FROM text_notes WHERE id = :id", ["id" => $id]);
    
        // Supprimer la note de la table notes
        self::execute("DELETE FROM notes WHERE id = :id", ["id" => $id]);
    }
    
    public static function getContentById(int $noteId): string {
        // À utiliser uniquement sur des textNote ! Appeler cette méthode uniquement après vérification avec isCheckListNote()
        $query = self::execute("SELECT content FROM text_notes WHERE id = :noteId", ["noteId" => $noteId]);
        $data = $query->fetch();
    
        if ($query->rowCount() === 0 || !$data || !isset($data['content'])) {
            return "";
        }
    
        return $data['content'];
    }

    public static function getItemListById(int $noteId): array {
        // À utiliser uniquement sur des textNote ! Appeler cette méthode uniquement après vérification avec isCheckListNote()
        $data = self::execute("SELECT id, content, checked FROM checklist_note_items WHERE checklist_note = :noteId ORDER BY checked, id", ["noteId" => $noteId])->fetchAll();
    
        $content = [];
    
        foreach ($data as $row) {
            $content[] = new ChecklistItem(
                $row['id'],
                $noteId,
                $row['content'],
                $row['checked']
            );
        }
        return $content;
    }

    public static function elapsedDate($timestampString): string {
        $timestamp = strtotime($timestampString);
        $currentTimestamp = time();
        $elapsedSeconds = $currentTimestamp - $timestamp;

        if ($elapsedSeconds < 60) {
            return "just now";
        } elseif ($elapsedSeconds < 3600) {
            $minutes = floor($elapsedSeconds / 60);
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } elseif ($elapsedSeconds < 86400) {
            $hours = floor($elapsedSeconds / 3600);
            if ($hours == 1) {
                return "one hour ago";
            } else {
                return "$hours hours ago";
            }
        } elseif ($elapsedSeconds < 2592000) { // 30 days
            $days = floor($elapsedSeconds / 86400);
            if ($days == 1) {
                return "one day ago";
            } else {
                return "$days days ago";
            }
        } else {
            $months = floor($elapsedSeconds / 2592000); // 30 days
            if ($months == 1) {
                return "one month ago";
            } else {
                return "$months months ago";
            }
        }
    }

    public static function isUniqueTitlePerOwner($title, $idUser): bool {
        $notes = Note::getAllNotesByUser($idUser);

        foreach ($notes as $note) {
            if ($note->getTitle() === $title) {
                return false; // Le titre n'est pas unique
            }
        }
    
        return true; // Le titre est unique
    }
}
