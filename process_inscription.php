<?php
// Inclure la connexion à la base de données
include('db/db_connection.php');

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe pour plus de sécurité

// Vérifier si l'email existe déjà dans la base de données
$sql_check_email = "SELECT * FROM utilisateur WHERE email = ?";
$stmt = $conn->prepare($sql_check_email);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si l'email existe déjà, afficher un message d'erreur
    echo "Cet email est déjà utilisé. Veuillez en choisir un autre ou vous connecter.";
} else {
    // Si l'email n'existe pas, insérer l'utilisateur dans la base de données
    $sql_insert_user = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert_user);
    $stmt->bind_param("ssss", $nom, $prenom, $email, $password);

    if ($stmt->execute()) {
        echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
    } else {
        echo "Erreur lors de l'inscription : " . $stmt->error;
    }
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
