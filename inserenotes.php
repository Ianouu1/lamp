<html>
<head>
    <title>Insertion des notes</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    session_start(); // cette méthode sers principalement a stocker/recuperer les données des pages précédentes
    
    // sers a savoir si un utilsateur est connecté ou non
    $utilisateurConnecte = false;
    if (isset($_SESSION['username'])) {
        $utilisateurConnecte = true;
        $utilisateur = $_SESSION['username'];
    }
    ?>
    
    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Connexion</a></li>
        <li><a href="inserenotes.php">Insertion Notes</a></li>
        <li><a href="notes.php">Notes</a></li>
        <li class="utilisateur-connecte">
            <?php
            if (isset($_SESSION['username'])) {
                echo "Utilisateur connecté : " . $utilisateur;
            }
            ?>
        </li>
    </ul>
    
    <h1>Insérer une note</h1>
    
    <?php
    // Regarde si l'utilisateur fais parti des professeur, et donc peut insérer des notes
    $enseignantsAutorises = ['enseignant1', 'enseignant2', 'enseignant3'];
    if ($utilisateurConnecte && in_array($utilisateur, $enseignantsAutorises)) {
        // Définir la matière préremplis en fonction de l'enseignant
        $matierePreRemplie = '';
        if ($utilisateur === 'enseignant1') {
            $matierePreRemplie = 'Mathématiques';
        } elseif ($utilisateur === 'enseignant2') {
            $matierePreRemplie = 'Histoire';
        } elseif ($utilisateur === 'enseignant3') {
            $matierePreRemplie = 'Français';
        }
        
        // mettre les text fields qui seront renseignés dans la base de données ensuite
        echo '
        <form method="post" action="">
            <label for="nomCtrl">Nom du contrôle :</label>
            <input type="text" name="nomCtrl" id="nomctrl" required><br><br>
            
            <label for="matiere">Matière :</label>
            <input type="text" name="matiere" id="matiere" value="' . $matierePreRemplie . '" required><br><br>
            
            <label for="note">Note :</label>
            <input type="number" name="note" id="note" step="0.1" required><br><br>
            
            <label for="utilisateur">Nom d\'utilisateur :</label>
            <input type="text" name="utilisateur" id="utilisateur" required><br><br>
            
            <input type="submit" value="Insérer">
        </form>';

        // Vérifier si le bouton a été cliqué
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les valeurs des textfields
            $nomCtrl = $_POST['nomCtrl'];
            $matiere = $_POST['matiere'];
            $note = $_POST['note'];
            $utilisateur = $_POST['utilisateur'];
            
            // information pour se connecter a la base de donnée
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "testdata";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données regarde si le username/password/dbname est correcte " . $conn->connect_error);
            }

            // Fais en sorte de récupérer l'id utilisateur a partir du nom utilisateur
            $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateurs WHERE nomutilisateur = ?");
            $stmt->bind_param("s", $utilisateur);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $idUtilisateur = $row['id_utilisateur'];
            $stmt->close();

            // Insertion de la note
            $sql = "INSERT INTO notes (id_utilisateur, nomctrl, matiere, note) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql); // permet la liaison afin d'y mettres les valeurs qui sont inconnnues pour le moment
            $stmt->bind_param("issd", $idUtilisateur, $nomCtrl, $matiere, $note); //issd pour int, string, string, decimal

            // Exécuter la requête d'insertion
            if ($stmt->execute()) {
                echo "Note insérée avec succès.";
            } else {
                echo "Erreur lors de l'insertion de la note : " . $stmt->error;
            }

            // Fermer la connexion à la base de données
            $stmt->close();
            $conn->close();
        }
    }
    ?>
    
</body>
</html>
