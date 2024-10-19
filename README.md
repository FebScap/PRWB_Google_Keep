# Projet PRWB 2324 - Groupe a05 - Google Keep

 * Projet WEB réalisé en PHP/html/CSS(Bootstrap)
 * Le but du projet est de développer une application de gestion de notes inspirée de l'application Google Keep.

## Aperçu des vues principales

![Capture d'écran 2024-10-19 115008](https://github.com/user-attachments/assets/3d1ccaef-f679-478d-85a6-379c4ddcbe1f)

![search_1](https://github.com/user-attachments/assets/b34b6808-ee60-43ab-9eb4-28501591b1dc)


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
