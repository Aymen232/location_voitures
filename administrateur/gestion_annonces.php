<?php
include('../DB/db_connection.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT a.*, u.email FROM annonce a 
        JOIN utilisateur u ON a.utilisateur_id = u.id 
        WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Annonce introuvable.";
    header("Location: dashboard_admin.php");
    exit();
}

$annonce = $result->fetch_assoc();
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
    <?php include('../includes/includes_header.php'); ?>
</header>
    <h1>Gérer l'annonce</h1>
    <form action="traiter_annonce.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" name="action" value="valider">Valider</button>
        <button type="submit" name="action" value="refuser">Refuser</button>
    </form>
</body>
</html>
