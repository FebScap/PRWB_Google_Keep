# Projet PRWB 2324 - Groupe a05 - Google Keep

## Notes de version itération 1 

### Liste des utilisateurs et mots de passes

  * boverhaegen@epfc.eu, password "Password1,", utilisateur
  * bepenelle@epfc.eu, password "Password1,", utilisateur
  * xapigeolet@epfc.eu, password "Password1,", utilisateur
  * mamichel@epfc.eu, password "Password1,", utilisateur
  * Signup pour ajouter des comptes

### Liste des bugs connus

  * Troncage des notes parfois compliqué dans viewnotes/viewarchives/viewsharednotes
  * Lors de l'ajout d'item dans une checklist note: Ajouter un item par un, sinon ça crash. La vérification devrait se faire au moyen d'une input barre à coté de bouton plus et ainsi éviter le fait de mettre un nom unique à chaque fois. Pour le moment la validation nom unique ne se fait que au moment de cliquer sur save et pas sur plus étant donné qu'il n'y a pas d'input.   
  * Validation pour l'ajout d'un share nécessaire, si aucun user ou permission n'est sélectionné, la page plante.

## Fonctionnalités manquantes 
  * Refactor Complet du Model + attributs private partout + Note abstract etc
  
### Liste des fonctionnalités supplémentaires

### Divers

## Notes de version itération 2
...

## Notes de version itération 3 

### Liste des utilisateurs et mots de passes

  * boverhaegen@epfc.eu, password "Password1,", utilisateur
  * bepenelle@epfc.eu, password "Password1,", utilisateur
  * xapigeolet@epfc.eu, password "Password1,", utilisateur
  * mamichel@epfc.eu, password "Password1,", utilisateur
  * Signup pour ajouter des comptes

### Liste des bugs connus

  * Pin/unpin et archive/unarchive n'appliquent pas correctement les règles de poids
  * Le save checklistnote ne fonctionne plus en JS lorqu'on ajoute ou supprime un item
  * L'url en GET pour la recherche d'item se perd lorsque qu'on accède à des parametres d'une note (pin/unpin/archive/unarchive/share/labels) excepté pour edit note
  * Certaines pages HTML présentent des erreurs
  * Certaines erreurs de sécurités sont présentes

## Fonctionnalités manquantes 
  * JS ne tient pas compte du dev.ini
  * Propagation de la recherche pas faite en JS
  * La classe Note n'est pas abstract
  * Le traitement métier devrait entièrement être fait dans le model