Installation de XAMPP, WORDPESS et du thème




XAMPP
Wordpress
Mettre Wordpress dans XAMPP
VHOST de XAMPP
Créer un base de données dans phpMyAdmin
Installer Wordpress
Installer le thème
Paramétrer le backoffice Wordpress


XAMPP
1. Télécharger XAMPP
   1. https://www.apachefriends.org/fr/download.html
   2. Exécuter le fichier d’installation
   3. Mettre le dossier d’installation proche de la racine du disque dur
      1. c:\XAMPP
2. Créer un dossier “www” dans c:\XAMPP
Wordpress
3. Télécharger Wordpress
   1. https://fr.wordpress.org/download/
4. Extraire l'archive wordpress dans un dossier avec winrar
   1. Télécharger winrar
      1. https://www.win-rar.com/start.html?&L=10
   2. Installer winrar 
      1. Double cliquer sur le fichier et suivez les instructions
   3. Sur le fichier de téléchargement 
      1. Clique droit
      2. Cliquez sur Extraire vers wordpress-6.2-fr_FR
Mettre Wordpress dans XAMPP
5. Dans c:/XAMPP/www/ 
   1. Créer un dossier que vous nommerez “ecf_juin_2023” 
   2. Copier le contenu du dossier nommé “wordpress” qui se trouve dans le dossier d’extraction winrar
   3. Coller le dans XAMPP\www\ecf_juin_2023\
VHOST de XAMPP
6. Configurer le vhost Apache dans XAMPP si vous avez plusieurs sites en local sinon passer cette étape l’url sera simplement localhost
   1. c:/XAMPP\apache\conf\extra
   2. Ouvrez le fichier “httpd-vhosts.conf” avec un notepad++ ou un éditeur de texte
   3. Insérer le code suivant en bas de page :
      1. <VirtualHost *:80>
      2.             ServerName ecf_juin_2023.localhost
      3.       DocumentRoot "C:\xampp\www\ecf_juin_2023"
      4.       DirectoryIndex index.php
      5.                     
      6.       <Directory "C:\xampp\www\ecf_juin_2023">
      7.               Require all granted
      8.               FallbackResource /index.php
      9.       </Directory>
      10. </VirtualHost>
7. Enregistrer le fichier de conf avec vos modifications
Créer un base de données dans phpMyAdmin
8. Ouvrir XAMPP
9. Lancer le serveur Apache et Mysql (bouton Apache et phpMyAdmin)
10. Aller sur phpMyAdmin
   1. Ouvrez votre navigateur https://localhost/phpmyadmin/
   2. Ou dans Xamp cliquez sur “Admin” à la ligne “MySql”
11. Créer une base de données dans phpMyAdmin
   1. Cliquez sur “Nouvelle base de données”
   2. Dans le champs “Nom de base de données”
      1. Saisir “ecf_restaurant_quai_antique”
      2. Cliquer sur le bouton “créer” juste à droite
12. Laisser l’accès depuis l’utilisateur “root” sans mot de passe
Installer Wordpress
13. Ouvrir votre navigateur
14. Taper dans la barre d’adresse : ecf_juin_2023.localhost/index.php ou simplement localhost si vous n’avez qu’un site en local
15. Suivez l’installation de Wordpress
16. Quand le nom de la base de données est demandé renseignez “ecf_restaurant_quai_antique” 
17. Pour les accès à la base de données renseigner seulement “root” dans le champs identifiant
18. Adresse de la base de données => localhost
19. Préfixe des table => wp_
20. Cliquez sur “Lancer l’installation”
21. Title du site : “Restaurant Quai Antique”
22. Renseigner vos identifiants admin (à conserver)
23. Connectez-vous à l’admin wordpress avec vos identifiants
24. L’adresse du backoffice est : ecf_juin_2023.localhost/admin ou localhost/admin
25. Aller dans
   1. Backoffice
   2. Réglages
   3. Permaliens
   4. Structure des permaliens
   5. Sélectionner “Titre de la publication”
   6. Cliquez sur “Enregistrer les modifications” en bas (bouton bleu)
Installer le thème
26. Installer le thème
   1. Télécharger le thème à partir de github
   2. https://github.com/JohnSansPseudo/ECF_restaurant_quai_antique.git
   3. Dans l’onglet “Code” choisir la branche master
   4. Cliquez sur le bouton “Code” (bleu)
   5. Cliquez sur download zip
   6. Sur l’archive zip télécharger cliquez droit puis extraire vers (option de winrar)
   7.  Dans le nouveau dossier créer par winrar
      1. Descendre dans l’arborescence jusqu'au dossier “restaurantQuaiAntique”
      2. Copier le dossier
27. Aller dans c:\xamp\www\ecf_juin_2023\wp-content\themes\
28. Coller le dossier “restaurantQuaiAntique”à cette endroit
29. Retourner sur votre navigateur dans le backoffice du site
30. Aller dans Apparence 
31. Cliquez sur Thèmes ou rafraîchissez la page si vous êtes déjà dessus
32. Au survol de la vignette “RestaurantQuaiAntique” cliquez sur “Activer”
33. Cliquez sur le menu “QuaiAntiqueParam” du backoffice de Wordpress (tout en bas)
Paramétrer le backoffice Wordpress
34. Pour paramétrer le wordpress assurez-vous de suivre toutes les instructions qui sont dans la partie “Paramétrage du backoffice”        
35. Une fois le backoffice paramétré vous pouvez aller dans les paramètres du Quai Antique
   1. Backoffice
   2. “QuaiAntiqueParam”
Traitement des erreurs
Problème avec la base de données
* Aller dans le dossier du thème 
   * c:\xamp\www\ecf_juin_2023\wp-content\themes\src\tools\PDOSingketon.php
   * Dans la function getInstance()
   * Modifier le username et le passwd au besoin ou vérifier que le nom de la base de données (dbname) soit le bon. 
Problème avec l'initialisation du thème
* L’action d’initialisation du thème se trouve dans le fichier functions.php à la racine du thème, voir la fonction setTables()
*  Dans cette fonction une option Wordpress est vérifiée et crée elle empêchera de rejouée la fonction si elle est paramétrée à 1.
* Si vous devez refaire l’initialisation du thème il faudra supprimer cette option 
* Il faut donc vérifier que celle ci n’existe pas ou n’est pas à 1
   * Aller dans dans PhpMyAdmin 
   * Cliquez sur la table wp_options 
   * Faites une recherche depuis le bouton rechercher 
   * Dans le champs option_name saisir “init_theme”
   * Cliquez sur exécuter
   * Si un résultat apparaît supprimer simplement l’entrée
Autre problèmes possible
* Dans le fichier functions.php à la racine du thème tout en haut se trouve deux constantes à paramétrer au besoin : 
   * define('LOCAL_SITE_USE', true); 
      * Si vous êtes en local comme c’est le cas dans cette installation cette constante doit être à true
   * define('TEST_IN_PROGESS', false);
      * Sert pour faire les test fonctionnels
* Toujours dans le fichier functions.php vérifier que le contenu de la fonction testLauncher() soit entièrement commenté




________________








Paramétrage du backoffice


Table des matières
Menu principal
Menu du footer
Page
Paramétrer la page d’accueil
Logo
Titre du site
Favicon
Media
Modifier le contenu textuel
Créer la galerie
Paramétrer la galerie
Modifier les images de la galerie
A lire avant de commencer
* Vous devez au préalable suivre les instructions du document “installation locale”
* Respecter l’ordre de cette notice pour le bon déroulement des opérations


Réglage de la taxonomie
* Si ce n’est pas déjà fait :
   * Backoffice
   * Réglages
   * Permaliens
   * Structure des permaliens
   * Sélectionner “Titre de la publication”
   * Enregistrer les modifications
Créer un compte admin
* Backoffice
* Comptes
* Ajouter
* Saisir tous les champs nécessaires au minimum
* Pour le rôle sélectionner “Administrateur / administratrice”
* Cliquez sur “Ajouter un compte”
Page
* Les pages sont créées automatiquement, ne pas modifier les slugs
Paramétrer la page d’accueil
* Backoffice
* Apparence
* Thème
* Personnaliser
* Réglages de la page d’accueil
* La page d’accueil affiche => une page statique
* Accueil => sélectionnez Accueil
* Cliquez sur “Publier” (bouton bleu en haut)
* Revenir au backoffice en cliquant sur le bouton flèche arrière puis le bouton en forme de croix
Media
* Backoffice
* Medias
* Cliquez sur le bouton “Ajouter”
* Cliquez sur “sélectionnez des fichiers”
* Toutes les images natives du thème sont dans le répertoire ci-dessous
   * C:\xamp\www\ecf_2023\wp-content\themes\restaurantQuaiAntique\img\
* Sélectionnez tous les médias fournis
   * galerie1.jpg
   * galerie2.jpg
   * galerie3.jpg
   * galerie4.jpg
   * galerie5.jpg
   * galerie6.jpg
   * galerie7.jpg
   * logo.png
   * logo_white.png
   * Favicon.png
   * Cliquez sur ouvir
* Laisser tel quel les noms et les titres des fichiers
Logo
* Backoffice
* Apparence
* Personnaliser
* Identité du site
* Logo
* Cliquer sur “Sélectionner un logo”
* Cliquez sur l’onglet médiathèque en haut à gauche
* Sélectionnez logo.png (Quai Antique en marron, le nom du fichier s’affiche une fois l’image sélectionnée)
* Cliquez sur “Sélectionner” (bouton bleu)
* Pas de recadrage
* Cliquez sur “Publier” (bouton bleu en haut)
* Optionnel => Revenir au backoffice en cliquant sur le bouton flèche arrière puis le bouton en forme de croix
* Sinon passer à l’étape Favicon
Favicon 
* Backoffice
* Apparence
* Personnaliser
* Identité du site
* Icône du site
* Cliquez sur “Sélectionner l’icône du site”
* Cliquez sur l’onglet médiathèque en haut à gauche
* Sélectionnez favicon.png (Petite image “Q”,  le nom du fichier s’affiche une fois l’image sélectionnée) 
* Cliquez sur “Sélectionner” (bouton bleu)
* Pas de recadrage
* Cliquez sur “Publier” (bouton bleu en haut)
* Revenir au backoffice en cliquant sur le bouton flèche arrière puis le bouton en forme de croix




Titre du site 
* Backoffice
* Apparence
* Personnaliser
* Identité du site
* Saisir le titre
* Cliquez sur “Publier” (bouton bleu en haut)
* Revenir au backoffice en cliquant sur le bouton flèche arrière puis le bouton en forme de croix




Menu principal
* Backoffice
* Apparence
* Menus
* Dans l’encart Structure du menu
   * Nom du menu 
   * Saisir “Main menu”
   * Sélectionner l’emplacement “top-menu”
   * Cliquez sur “Créer le menu”
* Dans l’encart “Ajouter des éléments de menu”
   * Pages
   * Tout voir
      * Sélectionner les pages Accueil, A la carte, Connexion, Mon compte
   * Cliquer sur “Ajouter au menu”
* Dans l’encart Structure du menu
   * Cliquer sur enregistrer le menu
* Vous venez de faire le premier menu qui se placera dans la navigation


Menu du footer
* Backoffice
* Apparence
* Menus
* Onglet “Modifier les menu “
* Cliquez sur le lien bleu “créez un nouveau menu”
* Dans l’encart Structure du menu
   * Nom du menu
   * Saisir “footer-menu”
   * Sélectionner l’emplacement “bottom-menu”
   * Cliquer sur “Créer le menu”
* Dans l’encart “Ajouter des éléments de menu”
   * Pages
   * Tout voir
      * Sélectionner les pages Accueil, A la carte, Connexion, Mon compte, Réserver votre table
   * Cliquer sur “Ajouter au menu”
* Dans l’encart Structure du menu
   * Cliquer sur enregistrer le menu
* Vous venez de faire le menu du footer


Modifier le contenu textuel (menu, formule, plats…)
* Backoffice
* Quai AntiqueParam
* Cliquez sur l’onglet souhaité pour modifier les textes et autres paramètres
* Par défaut le thèmes est préremplie avec du texte de substitution sauf pour la galerie de la home page
* Visualisez vos changements en rafraîchissant le site dans un autre onglet


Vérifier que le nombres de convives est bien saisie par défaut
* Backoffice
* Quai AntiqueParam
* Cliquez sur l’onglet “Nombre de client maximum”
* La valeur 50 doit être saisi, vous pouvez la modifier si vous le souhaitez


Ajouter les photos à la galerie
* Vous pouvez ajouter de nouvelles images à la galerie dans la section ajouter une image
   * Respectez le ratio, les images du thème font 640 x 427 pixels afin d’éviter les décalages de hauteurs
* Passer ensuite à la section “Modifier la galerie”
   * Cliquez sur ajouter une image 
   * Cliquez sur l’image voulue pour cette emplacement pour l’ajouter
   * Ajouter un titre au besoin et cliquez sur le bouton “Modifier le titre” pour l’enregistrer
* Le bouton tout effacer permet de ne pas mettre d’images toutefois la galerie est prévue pour 6 images
Modifier les menus et options de menus
* Backoffice
* Quai AntiqueParam
* Cliquez sur l’onglet “Menus”
Modifier les plats et type de plat
* Backoffice
* Quai AntiqueParam
* Cliquez sur l’onglet “Plats”
Modifier les horaires d’ouverture
* Bien saisir les heures et minutes de chaque moment de la journée (soir ou midi) avant d’enregistrer
* Le bouton effacer est un raccourcis et indiquera le restaurant fermé sur ce créneau


Visualisez le résultat
* Vous pouvez maintenant visualiser le site
* L’adresse est localhost ou ecf_juin_2023.localhost/index.php si vous avez plusieurs site en locale ou vous pouvez survolez l’icône en forme de maison (tout en haut à gauche du backoffice) puis cliquez sur aller sur le site 


Page connexion
* Vous êtes automatiquement redirigé vers le backoffice si vous êtes connecté en admin. Il faudra vous déconnecter de l’admin pour éviter ce comportement.


Page Mon compte
* Si vous créez un compte client un mail de validation vous sera envoyé vérifier vos spams
Page Réserver votre table 
* Si vous créez faites une réservation un mail de validation vous sera envoyé vérifier vos spams