<!DOCTYPE html>
<html>
<head>
    <title>Florian & Timothée | SAÉ : Installation Services Réseau</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    session_start(); // cette méthode sers principalement a stocker/recuperer les données des pages précédentes
    ?>
    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Connexion</a></li>
        <li><a href="inserenotes.php">Insertion Notes</a></li>
        <li><a href="notes.php">Notes</a></li>
        <li class="utilisateur-connecte">
            <?php
            if (isset($_SESSION['username'])) {
                    echo "Utilisateur connecté : " . $_SESSION['username'];
                }
            ?>
        </li>
    </ul>
    <h1>Introduction</h1>
    <p>
        Cette SAÉ consiste à mettre en place un serveur <b>LAMP (Linux-Apache-MySQL-PHP)</b>. Pour cette SAÉ nous avons
        aussi installé <b>MAMP (Microsoft-Apache-MySQL-PHP)</b> ainsi qu'une machine virtuelleafin de pouvoir travailler 
        sur les pages <b>HTML</b> et scripts <b>PHP</b> depuis nos ordinateurs.
        <br>
        Ce qui nous a été demandé de faire est d'exécuter le script
        <a href="info.php" target="_blank">php.info</a>
        ainsi que de concevoir un script <b>PHP</b> (avec carte blanche dessus) qui communique avec une base de données.
        <br><br>
        Nous avons donc décidé de créer un script <b>PHP</b> qui aura pour fonction de mettre des notes dans un cadre
        scolaire
        <br><br>
        Pour cela on a créé une page d'accueil <a href="index.php" target="_parent">(index.php)</a> ainsi qu'une page 
        de connection <a href="login.php">(login.php)</a> où il y a 6 utilisateurs :
        <br><br>
        3 élèves et 3 enseignants (Identifiant:MotDePasse):
    </p>
    <ul>
        <li>eleve1:mdp1</li>
        <li>eleve2:mdp2</li>
        <li>eleve3:mdp3</li>
        <li>enseignant1:profmath</li>
        <li>enseignant2:profhistoire</li>
        <li>enseignant3:proffrancais</li>
    </ul>
    <p><a href="login.php">Se connecter</a></p>
    <p>Et il y a aussi une page pour insérer les notes (dans le cadre des enseignants,
        <a href="inserenotes.php">inserenotes.php</a>) et une autre pour visualiser 
        les notes insérées dans la base de données <a href="notes.php">notes.php</a>.</p>
</body>
</html>