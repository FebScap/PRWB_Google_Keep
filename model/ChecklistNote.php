<?php

require_once "framework/Model.php";

class ChecklistNote extends Note {
    
    public function __construct(private Note $note){}
}
