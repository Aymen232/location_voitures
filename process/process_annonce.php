<?php
include('../DB/db_connection.php');
session_start();

// Vérification de l'utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour déposer une annonce.";
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $prix_par_jour = (float)($_POST['prix_par_jour']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $date_debut = $_POST['date_debut'];
    $heure_debut = $_POST['heure_debut'];
    $date_fin = $_POST['date_fin'];
    $heure_fin = $_POST['heure_fin'];
    $utilisateur_id = $_SESSION['user_id'];
    $statut = 'en attente';
    $photo = null;

    // Gestion de l'upload de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/';
        $photo_name = uniqid() . '_' . basename($_FILES['photo']['name']);
        $target_path = $upload_dir . $photo_name;

        // Vérification du type de fichier
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error'] = "Format de fichier non supporté.";
            header("Location: ../deposer_annonce.php");
            exit();
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
            $photo = 'images/' . $photo_name;
        } else {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            header("Location: ../deposer_annonce.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Veuillez ajouter une photo valide.";
        header("Location: ../deposer_annonce.php");
        exit();
    }

    // Insérer l'annonce dans la base de données
    $sql_insert = "INSERT INTO annonces (marque, modele, prix_par_jour, description, location, date_debut, heure_debut, date_fin, heure_fin, date_creation, statut, utilisateur_id, photo) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);

    if ($stmt) {
        $stmt->bind_param("ssssssssisss", $marque, $modele, $prix_par_jour, $description, $location, $date_debut, $heure_debut, $date_fin, $heure_fin, $statut, $utilisateur_id, $photo);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Annonce déposée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'insertion : " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Erreur SQL : " . $conn->error;
    }

    header("Location: ../annonces.php");
    exit();
} else {
    $_SESSION['error'] = "Méthode de requête invalide.";
    header("Location: ../deposer_annonce.php");
    exit();
}