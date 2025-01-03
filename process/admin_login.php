<?php
// Inclure le fichier de connexion à la base de données
include '../DB/db_connection.php'; // Ajustez le chemin selon votre structure

// Vérifier si les données du formulaire ont été envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification des identifiants
    $sql = "SELECT * FROM utilisateurs WHERE email = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Vérifier si l'utilisateur est un administrateur
        if ($user['role'] === 'administrateur') {
            // Mise à jour de la table connexions_admin
            $sql = "INSERT INTO connexions_admin (admin_id, action) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $action = "Connexion réussie";
            $stmt->bind_param("is", $user['id'], $action);
            $stmt->execute();

            // Démarrer une session et sauvegarder les informations utilisateur
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Rediriger vers le tableau de bord
            header("Location: ../administrateur/dashboard_admin.php");
            exit;
        } else {
            // Si ce n'est pas un administrateur
            echo "Vous n'êtes pas autorisé à accéder à cette section.";
        }
    } else {
        // Si les identifiants sont incorrects
        echo "Email ou mot de passe incorrect.";
    }
} else {
    echo "Méthode non autorisée.";
}

// Fermer la connexion
$conn->close();
?>
