# SAÉ 2.01 - Développement d’une application de gestion de films

### Auteurs :

-     Thomas PAZZE
      login: pazz0001

-     Nathan EULLAFFROY
      login: eull0004

### Description du projet :

Le projet consiste à développer une application de gestion de films. Cette application permettra de gérer une base de données de films. Elle rechercher des films. Elle permettra également de gérer les acteurs, les réalisateurs et les genres de films.

## SETUP

### Comment cloner le projet :

tout d'abord cloner le projet avec la commande suivante :
`git clone https://iut-info.univ-reims.fr/gitlab/pazz0001/sae2-01.git`

Ensuite, il faut installer les dépendances nécéssaire au bon fonctionnement du projet avec la commande suivante :
`composer install`

### How To Set Up a DataBase

créer un fichier nommé "`.mypdo.ini`" dans le dossier principal du projet.
Le fichier doit être au format :  
[mypdo]  
dsn = ...  
username = ...  
password = ...

e.g.  
 `[mypdo] `  
 `dsn` = 'mysql:host=mysql;dbname=exemple01;charset=utf8'  
 `username` = 'exemple'  
 `password` = 'exemplepassword'

### Comment lancer le serveur sur Linux :

effectuer la commande suivante :
`composer start:linux`

### Comment lancer le serveur sur Windows :

effectuer la commande suivante :
`composer start:windows`

### Autre commande pour lancer le serveur :

effectuer la commande suivante :
`composer start` (lancement sur envirenement windows par défaut)

### comment fixer les erreurs de code :

Afin d'effectuer une recherche des erreurs de syntaxe conformément au formattage de php-cs-fixer sans modifier les fichiers, il faut effectuer la commande suivante :  
`composer test:cs`

Afin d'effectuer une recherche des erreurs de syntaxe conformément au formattage de php-cs-fixer et modifier les fichiers, il faut effectuer la commande suivante :  
`composer fix:cs`
