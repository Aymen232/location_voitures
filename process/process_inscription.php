<?php
// Inclure la connexion à la base de données
include('db/db_connection.php');

// Démarrer la session pour gérer les messages d'erreur et de succès
session_start();

// Vérifier que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $confirmer_mot_de_passe = trim($_POST['confirmer_mot_de_passe']);
    
    // Vérifier si les mots de passe correspondent
    if ($mot_de_passe !== $confirmer_mot_de_passe) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: inscription.php");
        exit;
    }

    // Vérifier si l'email existe déjà
    $sql_check_email = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email déjà utilisé
        $_SESSION['error'] = "Cet email est déjà utilisé.";
        header("Location: inscription.php");
        exit;
    } else {
        // Hasher le mot de passe pour la sécurité
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insérer le nouvel utilisateur dans la base de données
        $sql_insert_user = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role, date_creation) VALUES (?, ?, ?, ?, 'utilisateur', NOW())";
        $stmt = $conn->prepare($sql_insert_user);
        $stmt->bind_param("ssss", $nom, $prenom, $email, $mot_de_passe_hache);

        if ($stmt->execute()) {
            // Succès de l'inscription
            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: login.php");
            exit;
        } else {
            // Erreur lors de l'insertion
            $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer.";
            header("Location: inscription.php");
            exit;
        }
    }
    
    // Fermer la connexion
    $stmt->close();
    $conn->close();
} else {
    // Rediriger vers la page d'inscription si l'accès direct est tenté
    header("Location: inscription.php");
    exit;
}
?>
