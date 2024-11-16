<?php
session_start();

// Vérifier si l'utilisateur est connecté
$isConnected = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déposer une annonce</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <?php include('includes/includes_header.php'); ?>
</header>

<h2>Déposer une annonce</h2>

<?php if (!$isConnected): ?>
    <!-- Message de connexion obligatoire -->
    <p id="message" style="color: red; font-weight: bold;">Connexion Obligatoire</p>
    <!-- Bouton de dépôt d'annonce caché au départ -->
    <a href="login.php" id="btn-deposer" style="display: none; font-size: 24px; color: gray; text-decoration: none;">Déposer une annonce</a>
    
    <script>
        // Afficher le message pendant 2 secondes, puis afficher le bouton
        setTimeout(function() {
            document.getElementById('message').style.display = 'none'; // Cacher le message
            document.getElementById('btn-deposer').style.display = 'inline-block'; // Afficher le bouton
        }, 2000); // 2000 ms = 2 secondes
    </script>
<?php else: ?>
    <!-- Formulaire pour déposer une annonce si l'utilisateur est connecté -->
    <form action="process_annonce.php" method="POST">
        <label for="marque">Marque :</label>
        <input type="text" id="marque" name="marque" required><br>

        <label for="modele">Modèle :</label>
        <input type="text" id="modele" name="modele" required><br>

        <label for="prix_par_jour">Prix par jour :</label>
        <input type="number" id="prix_par_jour" name="prix" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="location">Lieu de prise en charge :</label>
        <input type="text" id="location" name="location" placeholder="Ex: Calais, Pas-de-Calais" required><br>

        <label for="start-date">Date de début :</label>
        <input type="date" id="start-date" name="start_date" required><br>

        <label for="start-time">Heure de début :</label>
        <select id="start-time" name="start_time" required>
            <option value="Matin">Matin</option>
            <option value="Midi">Midi</option>
            <option value="Après-midi">Après-midi</option>
            <option value="Soir">Soir</option>
        </select><br>

        <label for="end-date">Date de fin :</label>
        <input type="date" id="end-date" name="end_date" required><br>

        <label for="end-time">Heure de fin :</label>
        <select id="end-time" name="end_time" required>
            <option value="Matin">Matin</option>
            <option value="Midi">Midi</option>
            <option value="Après-midi">Après-midi</option>
            <option value="Soir">Soir</option>
        </select><br>

        <button type="submit">Déposer l'annonce</button>
    </form>
<?php endif; ?>

</body>
</html>
