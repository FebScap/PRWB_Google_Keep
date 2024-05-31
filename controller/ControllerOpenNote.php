<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/User.php";
require_once "model/TextNote.php";
require_once "model/ChecklistNote.php";
require_once "model/Label.php";
require_once 'utils/Base64url.php';

class ControllerOpenNote extends Controller {
    //accueil du controlleur.
    public function index() : void {

        $user = $this->get_user_or_redirect()->getId();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToSee($_GET["param1"])) {
            if (Note::isCheckListNote($_GET["param1"])) {
                $textnote = ChecklistNote::getChecklistNoteById($_GET["param1"]);
                $items = Note::getItemListById($_GET["param1"]);
                if (isset($_GET["param2"])) {
                    (new View("openchecklistNote"))->show(["textnote" => $textnote, "url" => $_GET["param2"], "user" => $this->get_user_or_false(), "items" => $items]);
                } else {
                    (new View("openchecklistNote"))->show(["textnote" => $textnote, "user" => $this->get_user_or_false(), "items" => $items]);
                }
                
            } else {
                $textnote = TextNote::getTextNoteById($_GET["param1"]);
                if (isset($_GET["param2"])) {
                    (new View("opentextNote"))->show(["textnote" => $textnote, "url" => $_GET["param2"], "user" => $this->get_user_or_false()]);
                } else {
                    (new View("opentextNote"))->show(["textnote" => $textnote, "user" => $this->get_user_or_false()]);
                }
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not be here"]);
        }
    }

    public function archive() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setArchived(1);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function unarchive() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setArchived(0);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function pin() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setPinned(1);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function unpin() : void {
        $note = Note::getNoteById($_POST["idnote"]);
        $note->setPinned(0);
        $note->persist();
        $this->redirect("opennote", "index", $note->getId());
    }

    public function editnote() : void {
        $user = $this->get_user_or_redirect()->getId();
        $errors = [];
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToEdit($_GET["param1"])) {
            $textnote = TextNote::getTextNoteById($_GET["param1"]); 
            if (isset($_GET["param2"])) {
                (new View("edittextnote"))->show(["textnote" => $textnote, "url" => $_GET["param2"], "errors" => $errors]);
            } else {
                (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not edit this note"]);
        }        
    }

    public function checkUncheck () : void {
        $note = ChecklistNote::getChecklistNoteById($_POST["idnote"]);
        $items = Note::getItemListById($_POST["idnote"]);
        $item = ChecklistItem::getItemById($_POST["itemid"]);
        if ($item->isChecked()){
            $item->setChecked(0);
        } else {
            $item->setChecked(1);
        }
        $item->persist();
        $this->redirect("opennote", "index", $_POST["idnote"]);        
    }

    public function saveNote() : void {
        
        $user = $this->get_user_or_redirect();
        $errors = [];
        $textnote = TextNote::getTextNoteById($_POST["id"]);

        if (isset($_POST['title'])){

            $title = $_POST['title'];

            if (!Note::validateTitle($_POST['title'])){

                $errors = ["Title length must be at least 3 and maximum 25."];
            }

            if ($_POST['title'] != $textnote->getTitle() && !Note::isUniqueTitlePerOwner($title, $user->getId())) {
                $errors = array_merge($errors, ["Title must be unique per User"]);
            }
            
            if (count($errors) == 0) {
                $textnote->setTitle($_POST["title"]);
                $textnote->setContent($_POST["content"]); //Je ne sais pas pq il me dit que la méthode est undefined alors qu'elle l'est
                $textnote->persist();
                $textnote->persist_date();
                $this->redirect("opennote", "index", $textnote->getId());
            } else {
                
                $textnote->setTitle($title);
                $textnote->setContent($_POST['content']);
                (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
            }
        } else {
            (new View("edittextnote"))->show(["textnote" => $textnote, "errors" => $errors]);
        }
    }

    public function editChecklistNote() : void {
        $user = $this->get_user_or_redirect()->getId();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToEdit($_GET["param1"])) {
            $textnote = ChecklistNote::getChecklistNoteById($_GET["param1"]);
            $itemList = ChecklistNote::getItemListById($_GET['param1']);
            if (isset($_GET["param2"])) {
                (new View("editchecklistnote"))->show(["textnote" => $textnote, "itemList" => $itemList, "url" => $_GET["param2"], "errorsTitle" => $errorsTitle = [], "errorsContent" => $errorsContent = []]);
            } else {
                (new View("editchecklistnote"))->show(["textnote" => $textnote, "itemList" => $itemList, "errorsTitle" => $errorsTitle = [], "errorsContent" => $errorsContent = []]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not edit this note"]);     
        }   
    }

    public function saveChecklistNote() : void {
        
        $user = $this->get_user_or_redirect();
        $errorsTitle = [];
        $errorsContent = [];
        $textnote = ChecklistNote::getChecklistNoteById($_POST["id"]);
        $itemList = ChecklistNote::getItemListById($_POST['id']);


        if (isset($_POST['title'])){
            if (isset($_POST['content'])) {
                $title = $_POST['title'];
                

                if (!Note::validateTitle($_POST['title'])){

                    $errorsTitle = ["Title length must be at least 3 and maximum 25."];
                }

                if ($_POST['title'] != $textnote->getTitle() && !Note::isUniqueTitlePerOwner($title, $user->getId())) {
                    $errorsTitle = array_merge($errorsTitle, ["Title must be unique per User"]);
                }

                //Validation Content               
                $content = $_POST['content'];
                $itemList = ChecklistNote::getItemListById($_POST["id"]);
                    $i = 0;
                    foreach ($itemList as $item) {
                        if ($_POST['content'][$i] != $item->getContent()){
                            $item->setContent($_POST['content'][$i]);
                        }
                        $i++;
                    }

                if (count($content) !== count(array_unique($content))) {
                    $errorsContent[] = "All items must be unique.";
                }
                
                if (count($errorsTitle) == 0 && count($errorsContent) == 0) {
                    $textnote->setTitle($_POST["title"]);
                    $textnote->setContent($_POST["content"]);
                    $textnote->persist();
                    $textnote->persist_date();
                    $itemList = ChecklistNote::getItemListById($_POST["id"]);
                    $i = 0;
                    foreach ($itemList as $item) {
                        if ($_POST['content'][$i] != $item->getContent()){
                            $item->setContent($_POST['content'][$i]);
                            $item->persist();
                        }
                        $i++;
                    }
                    $this->redirect("opennote", "index", $textnote->getId());
                } else {
                    $textnote->setTitle($title);
                    (new View("editchecklistnote"))->show(["textnote" => $textnote, "errorsTitle" => $errorsTitle, "errorsContent" => $errorsContent, "itemList" => $itemList]);
                }
            } else {
                $this->redirect("opennote", "index", $textnote->getId());
            }
        } else {
            (new View("editchecklistnote"))->show(["textnote" => $textnote, "errorsTitle" => $errorsTitle, "errorsContent" => $errorsContent, "itemList" => $itemList]);
        }
    }


    // FONCTIONNALITE ITEMS
    public function deleteItem() : void {
        $item = ChecklistItem::getItemById($_POST['itemid']);
        $id = $item->getchecklist_note();
        $item->delete();
        $this->redirect("opennote", "editchecklistNote", $id);
    }

    public function deleteItemRaw() : void {
        $item = ChecklistItem::getItemById($_POST['itemid']);
        $id = $item->getchecklist_note();
        $item->delete();
        echo $item->getId();
    }

    public function addItem() : void {
        $textnote = ChecklistNote::getChecklistNoteById($_POST["id"]);
        $errorsTitle = [];
        $errorsContent = [];
        $itemList = ChecklistNote::getItemListById($_POST['id']);
        $itemListTitle = [];
        foreach ($itemList as $i) {
            array_push($itemListTitle, $i->getContent());
        }

        if (empty($_POST['itemtitle'])) {
            $errorsContent[] = "Item name shouldn't be empty.";
            (new View("editchecklistnote"))->show(["textnote" => $textnote, "errorsTitle" => $errorsTitle, "errorsContent" => $errorsContent, "itemList" => $itemList]);
        } else if (in_array($_POST['itemtitle'], $itemListTitle)) {
            $errorsContent[] = "Must be unique.";
            (new View("editchecklistnote"))->show(["textnote" => $textnote, "errorsTitle" => $errorsTitle, "errorsContent" => $errorsContent, "itemList" => $itemList, "itemtitle"=>$_POST['itemtitle']]);
        } else {
            $emptyItem = new ChecklistItem(0, $_POST["id"], $_POST['itemtitle'], 0);
            $emptyItem->persist();
            array_push($itemList, $emptyItem);
            $this->redirect("opennote", "editchecklistnote", $_POST["id"]);
        }
    }

    public function addItemRaw() : void {
        $textnote = ChecklistNote::getChecklistNoteById($_POST["noteId"]);
        $item = new ChecklistItem(0, $textnote->getId(), $_POST['value'], 0);
        $item->persist();
        echo $item->getId();
    }

    public function check_title_unicity_service() : void {
        $res = "false";
    
        // Vérifie si des données POST ont été envoyées
        $post_data = json_decode(file_get_contents("php://input"), true);
    
        // Vérifie si les données POST contiennent un titre
        if (isset($post_data["title"]) && $post_data["title"] !== "") {
            // Vérifie l'unicité du titre
            $res = Note::isUniqueTitlePerOwner($post_data["title"], $this->get_user_or_redirect()->getId());
        }
    
        // Retourne la réponse au format JSON
        echo json_encode($res);
    }

    public function editLabels() : void {
        $user = $this->get_user_or_redirect()->getId();
        $errors = [];
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"] ) && $this->get_user_or_false()->isAllowedToEdit($_GET["param1"])) {
            $note = Note::getNoteById($_GET["param1"]); 
            $labelList = Label::getNoteLabels($_GET["param1"]);
            $existingLabels = Label::getAllExisingLabelsByUserIdMinusNoteID($user, $_GET["param1"]);
            
            (new View("viewLabels"))->show(["note" => $note, "errors" => $errors, "labelList" => $labelList, "existingLabels" => $existingLabels]);
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not edit this note"]);
        }        
    }
    public function addLabel() : void {
        $user = $this->get_user_or_redirect()->getId();
        $errors = [];
        if (isset($_POST['id']) && is_numeric($_POST['id'] ) && $this->get_user_or_false()->isAllowedToEdit($_POST['id'])) {
            $note = Note::getNoteById($_POST['id']); 
            $labelList = Label::getNoteLabels($_POST['id']);
            $existingLabels = Label::getAllExisingLabelsByUserIdMinusNoteID($user, $_POST['id']);

            // Validation du titre
            if (!Label::validateLabel($_POST['labeltitle'])) {
                $errors[] = "Label length must be between " . Configuration::get("label_min_length") . " and " . Configuration::get("label_max_length");
                (new View("viewLabels"))->show(["note" => $note, "errors" => $errors, "labelList" => $labelList, "existingLabels" => $existingLabels]);
           
            // Vérification si le titre nest pas null
            } else if (in_array($_POST['labeltitle'], $labelList)) {
                $errors[] = "A note cannot contain the same label twice";
                (new View("viewLabels"))->show(["note" => $note, "errors" => $errors, "labelList" => $labelList, "existingLabels" => $existingLabels]);
            } else {
                Label::add($_POST['id'], $_POST['labeltitle']);
                $labelList = Label::getNoteLabels($_POST['id']);
                $existingLabels = Label::getAllExisingLabelsByUserIdMinusNoteID($user, $_POST['id']);
                (new View("viewLabels"))->show(["note" => $note, "errors" => $errors, "labelList" => $labelList, "existingLabels" => $existingLabels]);
            }
        } else {
            (new View("error"))->show(["error" => $error = "Oops, looks like you may not edit this note"]);
        }      
    }

    public function addLabelNoRedirect() : void {
        Label::add($_POST['noteId'], $_POST['label']);
        echo "Added " . $_POST['label'] . " to note " . $_POST['noteId'];
    }

    public function deleteLabel() : void {
        Label::delete($_POST['noteId'], $_POST['label']);
        $this->redirect("opennote", "editLabels", $_POST['noteId']);
    }

    public function deleteLabelNoRedirect() : void {
        Label::delete($_POST['noteId'], $_POST['label']);
        echo "Removed " . $_POST['label'] . " from note " . $_POST['noteId'];
    }

    //FONCTION SEARCH
    public function search() {
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
                                                "url" => $_GET["param1"],
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

    public function checkboxSearch() : void {
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
            $this->redirect("openNote", "search");
        } else {
            $encoded = base64url::url_safe_encode($labelsChecked);
            $this->redirect("openNote", "search",  base64url::url_safe_encode($labelsChecked));
        }
    
    }
}
