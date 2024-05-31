<?php
require_once 'framework/Controller.php';
require_once 'framework/View.php';
require_once 'model/User.php';
require_once 'model/Note.php';
require_once 'model/Label.php';
require_once 'utils/Base64url.php';

class ControllerSearch extends Controller {
    public function index() : void {
        $user = $this->get_user_or_false();
        $labelSearched = [];
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

        if (isset($_GET["param1"])) {
            $search = base64url::url_safe_decode($_GET["param1"]);
            if ($search == '') {
                (new View("error"))->show(["error" => $error = "Oops, looks like you can't do this search"]);
            } else {
                $labelSearched = explode("+", $search);
                //Vérification si les labels founis existent bien
                if(count(array_intersect($labelSearched, Label::getAllExisingLabels())) === count($labelSearched)) {
                    (new View("search"))->show(["sharedBy" => $sharedBy,
                                                "nameSharedBy" => $nameSharedBy,
                                                "userNotes" => $userNotes,
                                                "notesShared" => $notesShared,
                                                "labels" => $labels,
                                                "labelSearched" => $labelSearched,
                                                "user" => $user]);
                  } else {
                    (new View("error"))->show(["error" => $error = "Oops, looks like you can't do this search"]);
                  }
            }
        } else {
            (new View("search"))->show(["sharedBy" => $sharedBy,
                                            "nameSharedBy" => $nameSharedBy,
                                            "userNotes" => $userNotes,
                                            "notesShared" => $notesShared,
                                            "labels" => $labels,
                                            "labelSearched" => $labelSearched,
                                            "user" => $user]);
        }
        

        
    }

    public function checkbox() : void {
        $labelsChecked = '';
        $nbLabels = $_POST['nbLabels'];
        for ($i=0; $i < $nbLabels; $i++) { 
          if (isset($_POST["label" . $i])) {
                if ($labelsChecked == "") {
                    $labelsChecked = $_POST["label" . $i];
                } else {
                    $labelsChecked = $labelsChecked . "+" . $_POST["label" . $i];
                }
           }
        }

        if ($labelsChecked == '') {
            $this->redirect("search");
        } else {
            $encoded = base64url::url_safe_encode($labelsChecked);
            $this->redirect("search", 'index', $encoded);
        }
    
    }
}
