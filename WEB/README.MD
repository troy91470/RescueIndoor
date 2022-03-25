# WEB

Application web d'administration de l'environnemet du robot.
Pour configurer le serveur web, il faut :
- installer le package lampp,
- ajouter au fichier de configuration d'apache `/opt/lampp/apache2/conf/httpd.conf`, le contenu de `conf/apache.conf` trouvable dans ce répertoire,
- ensuite, lancer lampp : `sudo /opt/lampp/lampp start`,
- effectuer le code SQL de BDD/projet.sql avec le service MySQL 
    -   Avec lampp, le service phpMyAdmin (`http://localhost/phpmyadmin/`) permet une importation plus facile avec toujours le fichier BDD/projet.sql
## Dossier conf

Ensemble des fichiers de configurations necessaires.

* ### apache.conf :

    Après importation du fichier, changer la variable "path" afin qu'elle corresponde au chemin
    où ce dossier "WEB" sera installé.

## Dossiers css - fonts - images - js - vendor

Ensemble de fichiers necessaires au bon fonctionnement du front-end de notre site.

## Dossier BDD

Ensemble des fichiers reliés à la base données

* ### projet.sql

    Code SQL pour créer notre base de données et implémenter des valeurs exemples (3 administrateurs et 2 utilisateurs)

## Fichiers "*.php"

Ensemble de fichiers php correspondant à la mise en application du back-end et du front-end
afin de proposer une interface ergonomique et fonctionnelle.
