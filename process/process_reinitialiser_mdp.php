<?php
// Démarrer la session si nécessaire
session_start();
include('../DB/db_connection.php');

// Vérifier que les champs sont remplis
if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier que les mots de passe correspondent
    if ($new_password === $confirm_password) {
        // Hasher le mot de passe pour la sécurité
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // ID de l'utilisateur (par exemple, récupéré depuis la session)
        $user_id = $_SESSION['user_id']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session

        // Mettre à jour le mot de passe dans la base de données
        $sql = "UPDATE utilisateurs SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            // Si la mise à jour est réussie, afficher le message et rediriger
            echo "<script>alert('La réinitialisation du mot de passe est réussie'); window.location.href = 'index.php';</script>";
        } else {
            echo "Erreur lors de la mise à jour du mot de passe: " . $conn->error;
        }

        $stmt->close();
    } else {
        // Si les mots de passe ne correspondent pas
        echo "<script>alert('Les mots de passe ne correspondent pas'); window.history.back();</script>";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}

// Fermer la connexion
$conn->close();
?>
