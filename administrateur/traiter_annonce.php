
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../DB/db_connection.php');
require_once 'C:/Composer/vendor/autoload.php'; // Charger PHPMailer avec Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: ../login.php");
    exit();
}

// Vérifier si les données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    $statut = ($action === 'valider') ? 'validée' : 'refusée';

    // Mettre à jour le statut de l'annonce
    $sql_update = "UPDATE annonce SET statut = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $statut, $id);

    if ($stmt->execute()) {
        // Récupérer l'email de l'utilisateur pour envoyer la notification
        $sql_email = "SELECT u.email, a.marque, a.modele 
                      FROM utilisateurs u 
                      JOIN annonces a ON u.id = a.utilisateur_id 
                      WHERE a.id = ?";
        $stmt_email = $conn->prepare($sql_email);
        $stmt_email->bind_param("i", $id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();

        if ($result_email->num_rows > 0) {
            $user_data = $result_email->fetch_assoc();
            $email = $user_data['email'];
            $marque = $user_data['marque'];
            $modele = $user_data['modele'];

            // Préparer le contenu de l'email
            $sujet = "Statut de votre annonce pour $marque $modele";
            $message = "Bonjour,\n\nVotre annonce pour le véhicule $marque $modele a été $statut.\n\n";
            $message .= ($statut === 'validée') ? 
                        "Elle est maintenant visible sur notre site. Merci pour votre confiance.\n\n" : 
                        "Elle n'a pas été acceptée. Vous pouvez modifier et soumettre à nouveau votre annonce.\n\n";
            $message .= "Cordialement,\nL'équipe de Location de Voitures.";

            // Utiliser PHPMailer pour envoyer l'email
            $mail = new PHPMailer(true);

            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Serveur SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'votre_email@gmail.com'; // Adresse email
                $mail->Password = 'votre_mot_de_passe'; // Mot de passe ou mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinataires
                $mail->setFrom('votre_email@gmail.com', 'Location de Voitures');
                $mail->addAddress($email);

                // Contenu de l'email
                $mail->isHTML(false); // Email en texte brut
                $mail->Subject = $sujet;
                $mail->Body = $message;

                // Envoyer l'email
                $mail->send();
                $_SESSION['success'] = "Annonce $statut avec succès. Un email a été envoyé à l'utilisateur.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Annonce $statut, mais l'envoi de l'email a échoué. Erreur : {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = "Impossible de récupérer l'email de l'utilisateur pour l'annonce ID : $id.";
        }
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'annonce : " . $conn->error;
    }

    header("Location: dashboard_admin.php");
    exit();
} else {
    $_SESSION['error'] = "Données invalides ou requête incorrecte.";
    header("Location: dashboard_admin.php");
    exit();
}
?>
