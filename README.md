# Projet PRWB 2324 - Groupe a05 - Google Keep

 * Projet WEB réalisé en PHP/html/CSS(Bootstrap)

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
