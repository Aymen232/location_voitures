<?php
// Inclure la connexion à la base de données
include('db/db_connection.php');

// Démarrer la session
session_start();

// Récupérer les données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Vérifier si l'email existe dans la base de données
$sql_check_user = "SELECT * FROM utilisateur WHERE email = ?";
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
        $_SESSION['role'] = $user['role'];

        // Rediriger en fonction du rôle de l'utilisateur
        // Rediriger en fonction du rôle de l'utilisateur
    if ($user['role'] == 'administrateur') {
    echo "Redirection vers dashbord_admin.php";
    header("Location: administrateur/dashbord_admin.php");
    exit;
    } 
    else {
    echo "Redirection vers utilisateur_dashbord.php";
    header("Location: utilisateur/utilisateur_dashbord.php");
    exit;
    }
    } else {
        // Si le mot de passe est incorrect
        echo "Mot de passe incorrect.";
    }
} else {
    // Si l'email n'existe pas dans la base de données
    echo "L'email n'existe pas. Veuillez vérifier votre adresse email ou vous inscrire";
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
