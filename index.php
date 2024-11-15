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
    <?php include('includes/includes_header.php'); ?>
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

<main>
    <h1>Bienvenue sur notre site de location de voitures</h1>
    <p>Nous offrons une large sélection de véhicules pour répondre à vos besoins.</p>
</main>

<div class="reservation-bar">
    <div class="location">
        <label for="location">Lieu de prise en charge</label>
        <input type="text" id="location" name="location" placeholder="Calais, Pas-de-Calais, France">
    </div>
    <div class="date">
        <label for="start-date">Date de début</label>
        <input type="date" id="start-date" name="start-date">
    </div>
    <div class="time">
        <label for="start-time">Heure de début</label>
        <select id="start-time" name="start-time">
            <option value="matin">Matin</option>
            <option value="midi">Midi</option>
            <option value="apres-midi">Après-midi</option>
            <option value="soir">Soir</option>
        </select>
    </div>
    <div class="date">
        <label for="end-date">Date de fin</label>
        <input type="date" id="end-date" name="end-date">
    </div>
    <div class="time">
        <label for="end-time">Heure de fin</label>
        <select id="end-time" name="end-time">
            <option value="matin">Matin</option>
            <option value="midi">Midi</option>
            <option value="apres-midi">Après-midi</option>
            <option value="soir">Soir</option>
        </select>
    </div>
</div>

<footer>
    <?php include('includes/includes_footer.php'); ?>
</footer>

</body>
</html>
