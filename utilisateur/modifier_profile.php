<?php
// Démarrer la session
session_start();
require_once '../DB/db_connection.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Requête pour récupérer les informations utilisateur
$stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    die("Erreur : utilisateur non trouvé.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="../style1.css">
</head>
<body>
    <header>
        <h1>Modifier mes informations</h1>
    </header>

    <main>
        <form method="POST" action="../process/process_modifier_profile.php">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required><br>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

            <button type="submit" class="btn">Enregistrer les modifications</button>
        </form>
    </main>

    <footer>
        <p>© 2024 Location de Voitures. Tous droits réservés.</p>
    </footer>
</body>
</html>
