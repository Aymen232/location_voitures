<?php
// Démarrer la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil: Location de voitures</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?php include('../includes/includes_header_dashboard.php'); ?>
</header>

<!-- Message de connexion/déconnexion -->
<div class="status-connexion">
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($_SESSION['prenom']) . " " . htmlspecialchars($_SESSION['nom']); ?></strong></p>
        <a href="/location_voitures/logout.php">Se déconnecter</a>
    <?php else: ?>
        <p>Vous n'êtes pas connecté.</p>
    <?php endif; ?>
</div>


<div class="reservation-bar">
    <form action="recherche.php" method="POST">
        <div class="location">
            <label for="location">Lieu de prise en charge</label>
            <input type="text" id="location" name="location" placeholder="Calais, Pas-de-Calais, France">
        </div>
        <div class="date">
            <label for="start-date">Date de début</label>
            <input type="date" id="start-date" name="start_date">
        </div>
        <div class="time">
            <label for="start-time">Heure de début</label>
            <select id="start-time" name="start_time">
                <option value="Matin">Matin</option>
                <option value="Midi">Midi</option>
                <option value="Après-midi">Après-midi</option>
                <option value="Soir">Soir</option>
            </select>
        </div>
        <div class="date">
            <label for="end-date">Date de fin</label>
            <input type="date" id="end-date" name="end_date">
        </div>
        <div class="time">
            <label for="end-time">Heure de fin</label>
            <select id="end-time" name="end_time">
                <option value="Matin">Matin</option>
                <option value="Midi">Midi</option>
                <option value="Après-midi">Après-midi</option>
                <option value="Soir">Soir</option>
            </select>
        </div>
        <div class="submit">
            <button type="submit" name="rechercher">Rechercher</button>
        </div>
    </form>
</div>



<footer>
    <?php include('../includes/includes_footer.php'); ?>
</footer>

</body>
</html>
