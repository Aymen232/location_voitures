<?php
// Démarrer la session
session_start();
require_once '../DB/db_connection.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    // Redirection vers la page de connexion si non connecté ou rôle incorrect
    $_SESSION['error'] = "Veuillez vous connecter pour accéder à votre profil.";
    header("Location: ../login.php");
    exit();
}

// Récupérez les informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Requête préparée pour récupérer les informations utilisateur
$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id = ?");
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
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="../style1.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> !</h1>
    </header>

    <main>
        <!-- Section des informations utilisateur -->
        <section>
            <h2>Mes Informations</h2>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <a href="modifier_profile.php" class="btn">Modifier mes informations</a>
        </section>

        <!-- Section des réservations -->
        <section>
            <h2>Mes Réservations</h2>
            <?php
            // Requête pour récupérer les réservations de l'utilisateur
            $stmt_reservations = $conn->prepare("SELECT * FROM reservation WHERE utilisateur_id = ?");
            $stmt_reservations->bind_param("i", $user_id);
            $stmt_reservations->execute();
            $reservations_result = $stmt_reservations->get_result();

            if ($reservations_result && $reservations_result->num_rows > 0) {
                while ($reservation = $reservations_result->fetch_assoc()) {
                    echo "<div class='reservation'>";
                    echo "<h3>Réservation ID: {$reservation['id']}</h3>";
                    echo "<p>Date de début: {$reservation['date_debut']}</p>";
                    echo "<p>Date de fin: {$reservation['date_fin']}</p>";
                    echo "<p>Montant total : {$reservation['montant_total']} €</p>";
                    echo "<p>Statut: {$reservation['statut']}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucune réservation trouvée.</p>";
            }
            ?>
        </section>

        <!-- Section des annonces -->
        <section>
            <h2>Mes Annonces</h2>
            <?php
            // Requête pour récupérer les annonces de l'utilisateur
            $stmt_annonces = $conn->prepare("SELECT * FROM annonce WHERE utilisateur_id = ?");
            $stmt_annonces->bind_param("i", $user_id);
            $stmt_annonces->execute();
            $annonces_result = $stmt_annonces->get_result();

            if ($annonces_result && $annonces_result->num_rows > 0) {
                while ($annonce = $annonces_result->fetch_assoc()) {
                    $marque = htmlspecialchars($annonce['marque'] ?? "Non spécifiée");
                    $modele = htmlspecialchars($annonce['modele'] ?? "Non spécifié");
                    $description = htmlspecialchars($annonce['description'] ?? "Non spécifiée");
                    $prix_par_jour = htmlspecialchars($annonce['prix_par_jour'] ?? "Non spécifié");
                    $statut = htmlspecialchars($annonce['statut'] ?? "Non spécifié");


                    echo "<div class='annonce'>";
                    echo "<h3>{$marque} - {$modele}</h3>";
                    echo "<p>Description : {$description}</p>";
                    echo "<p>Prix par jour : {$prix_par_jour} €</p>";
                    echo "<p>Etat d'annonce : {$statut} </p>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>Aucune annonce trouvée.</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <p>© 2024 Location de Voitures. Tous droits réservés.</p>
    </footer>
</body>
</html>
