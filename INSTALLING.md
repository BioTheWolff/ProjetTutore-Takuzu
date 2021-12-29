# Projet tutoré - Takuzu
## Manuel d'installation

### Prérequis
  * un serveur web (Apache, NGINX, etc.)
  * PHP >= 7.3
  * [si vérification d'intégrité] Composer

### Sanity checks (Vérification d'intégrité)
Il est possible de vérifier l'intégrité du logiciel en lançant les tests unitaires écrits, qui se trouvent dans le dossier `tests/` à la racine du projet. 

En supposant les commandes et instructions faites pour Linux ci-dessous, on peut suivre cette démarche :
  1. installer les dépendances Composer : `composer install`
  2. lancer PHPUnit : `./vendor/bin/phpunit ./tests/`

### Installation
Pour installer le projet, il suffit de demander au serveur web de pointer sur le dossier `public/` qui se trouve à la racine du projet. C'est dans ce dossier qu'est contenu le fichier index qui redirigera le traffic.