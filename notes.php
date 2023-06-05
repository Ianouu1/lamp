<?php
    session_start(); // cette méthode sers principalement a stocker/recuperer les données des pages précédentes
?>
<?php
// information pour se connecter a la base de donnée
$servername = "localhost";
$username = "root";
$password = "#TpLinux#";
$dbname = "testdata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données regarde si le username/password/dbname est correcte" . $conn->connect_error);
}

// Récupérer toutes les notes de la base de données et trier les colonnes
$stmt = $conn->prepare("SELECT id_utilisateur, nomctrl, matiere, note FROM notes ORDER BY id_utilisateur, matiere, note");
$stmt->execute();
$result = $stmt->get_result();
$notes = $result->fetch_all(MYSQLI_ASSOC); // stocke les valeurs sous forme de tableau, formate le tout
$stmt->close();

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulter les notes</title>
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
            if (isset($_SESSION['username'])) {
                echo "Utilisateur connecté : " . $_SESSION['username'];
            }
            ?>
        </li>
    </ul>
    <h1>Les notes</h1>
    <p> Voici un rappel des id utilisateur correspondant aux noms des utilisateurs, si l'id utilisateur est vide c'est parce que la note a été
        attribuée à un utilisateur qui n'appartient pas a la base de donée.
    </p>
    <ul>
        <li>
            1 = eleve1
        </li>
        <li>
            2 = eleve2
        </li>
        <li>
            3 = eleve3
        </li>
        <li>
            4 = enseignant1
        </li>
        <li>
            5 = enseignant2
        </li>
        <li>
            6 = enseignant3
        </li>
    </ul>
    <table>
        <tr>
            <th>ID utilisateur</th>
            <th>Nom du contrôle</th>
            <th>Matière</th>
            <th>Note</th>
        </tr>
        <?php foreach ($notes as $note) : ?>
            <tr>
                <td><?php echo $note['id_utilisateur']; ?></td>
                <td><?php echo $note['matiere']; ?></td>
                <td><?php echo $note['nomctrl']; ?></td>
                <td><?php echo $note['note']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
