<?php
session_start();
session_unset();
session_destroy();

// Écrire dans un fichier pour vérifier si ce code s'exécute
file_put_contents("debug_log.txt", "Logout script executed.\n", FILE_APPEND);

echo "Vous êtes déconnecté. La redirection devrait s'exécuter.";
header("Location: http://localhost/location_voitures/index.php");
exit();
