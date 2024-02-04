<?php

require_once "framework/Model.php";

class ChecklistItem extends Model {
    
    public function __construct(private int $id, private string $content, private int $checked){
    }

    public function getId(): int {
        return $this->id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getChecked(): int {
        return $this->checked;
    }
}