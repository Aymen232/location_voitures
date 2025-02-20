<?php
// Inclure la connexion à la base de données
include('../DB/db_connection.php');

// Démarrer la session
session_start();

// Vérifier que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier si l'email existe dans la base de données
    $sql_check_user = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql_check_user);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si l'utilisateur existe, récupérer ses informations
        $user = $result->fetch_assoc();

        // Vérifier si le mot de passe est correct
        if (password_verify($password, $user['mot_de_passe'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 'administrateur') {
                header("Location: ../administrateur/dashboard_admin.php");
                exit;
            } else {
                header("Location: ../utilisateur/utilisateur_dashboard.php");
                exit;
            }
        } else {
            // Mot de passe incorrect
            $_SESSION['error'] = "Mot de passe incorrect.";
            header("Location: ../login.php");
            exit;
        }
    } else {
        // Aucun utilisateur trouvé avec cet email
        $_SESSION['error'] = "Aucun utilisateur trouvé avec cet email.";
        header("Location: ../login.php");
        exit;
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
} else {
    // Rediriger vers la page de connexion si l'accès direct est tenté
    header("Location: ../login.php");
    exit;
}
