<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';
require_once 'model/TextNote.php';
require_once 'model/ChecklistNote.php';



class ControllerAddChecklistNote extends Controller{
    public function index() : void {
        $user = $this->get_user_or_redirect();
        $title = '';
        $content = ['','','','','',''];
        $errorsTitle = [];
        $errorsContent = [];
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $note = new ChecklistNote(0, $_POST['title'], $user->getId(), "", null, 0, 0, 1, []);
            $title = $_POST['title'];
            $content = $_POST['content'];
            $errorsTitle = $note->validate();
            $errorsContent = ChecklistNote::validateContent($content);
            if (count($errorsTitle) == 0 && count($errorsContent) == 0){
                Note::increaseAllWeightBy1($user->getId());
                $note->persist();
                foreach ($content as $item){
                    if (isset($item) && $item != ""){
                        $checklist_item = new ChecklistItem(null, $note->getId(), $item, 0);
                        $checklist_item->persist();
                    }
                }
                $this->redirect("viewnotes");
            }
        }
        (new View("addCheckListNote"))->show(["title" => $title, "content" => $content, "errorsTitle" => $errorsTitle, "errorsContent" => $errorsContent]);
    }
}
