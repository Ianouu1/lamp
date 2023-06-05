<?php
session_start();// cette méthode sers principalement a stocker/recuperer les données des pages précédentes

// information pour se connecter a la base de donnée
$servername = "localhost";
$username = "root";
$password = "#TpLinux#";
$dbname = "testdata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données regarde si le username/password/dbname est correcte " . $conn->connect_error);
}

// Recupere les données renseignées dans les text fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // prends dans la table utilisateurs les informations correspondant au pseudo et au mot de passe qu'on a donné dans les
    // textfields
    $sql = "SELECT * FROM testdata.utilisateurs WHERE nomutilisateur = '$username' AND mdp = '$password'";
    $result = $conn->query($sql);
    
    // Vérifie si les identifiants sont bons, si c'est le cas on renvoie l'utilisateur sur la page d'accueil
    // sinon on enregistre dans une variable un message d'erreur
    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = "Identifiant ou mot de passe incorrect.";
    }
}

// Si l'utilisateur appuie sur le bouton déconnexion on déconnecte l'utilisateur de la session et le 
// renvoie sur la page d'accueil
if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Connexion</a></li>
        <li><a href="inserenotes.php">Insertion Notes</a></li>
        <li><a href="notes.php">Notes</a></li>
        <li class="utilisateur-connecte">
            <?php
            // si il y a un utilisateur connecté on renvoie son nom
            if (isset($_SESSION['username'])) {
                echo "Utilisateur connecté : " . $_SESSION['username'];
            }
            ?>
        </li>
    </ul>
    <h1>Page de Connexion</h1>
    <p>
        Voici les utilisateur :
    </p>
    <ul>
        <li>eleve1:mdp1</li>
        <li>eleve2:mdp2</li>
        <li>eleve3:mdp3</li>
        <li>enseignant1:profmath</li>
        <li>enseignant2:profhistoire</li>
        <li>enseignant3:proffrancais</li>
    </ul>
    <?php
    // si la variable errorMessage existe (Si les identifiants sont incorrecte alors on affiche lerreur)
    if (isset($errorMessage)) {
        echo "<p style='color: red;'>$errorMessage</p>";
    }
    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<button type="button" onclick="window.location.href=\'login.php?logout=true\'">Se déconnecter</button>';
        }
        ?>
    </form>
</body>
</html>
