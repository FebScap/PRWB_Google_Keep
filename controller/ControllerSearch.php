<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';
require_once 'model/Label.php';

class ControllerSearch extends Controller {
    public function index() : void {
        $user = $this->get_user_or_false();
        $userNotes = Note::getAllNotesByUser($user->getId());

        $sharedBy = Note::getAllSharedBy($user->getId());
        $notesShared = Note::getAllSharedNotesByUserId($user->getId());

        $nameSharedBy = [];
        foreach ($sharedBy as $id) {
            $nameSharedBy[] = User::getByID($id)->getFullName();
        }

        $labels = Label::getAllExisingLabelsByUserId($user->getId());
        foreach ($notesShared as $n) {
            $ls = Label::getNoteLabels($n->getId());
            foreach ($ls as $l) {
                if (!in_array($l, $labels)) {
                    array_push($labels, $l);
                }
            }
        }

        (new View("search"))->show(["sharedBy" => $sharedBy,
                                        "nameSharedBy" => $nameSharedBy,
                                        "userNotes" => $userNotes,
                                        "notesShared" => $notesShared,
                                        "labels" => $labels,
                                        "user" => $user]);
    }
}
