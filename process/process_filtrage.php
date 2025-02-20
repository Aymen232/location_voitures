<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si des résultats initiaux existent dans la session
    if (empty($_SESSION['resultats'])) {
        $_SESSION['message'] = "Aucune annonce disponible pour le filtrage.";
        header("Location: ../recherche.php");
        exit();
    }

    // Récupérer les résultats initiaux
    $resultats_initials = $_SESSION['resultats'];

    // Récupérer les données des filtres
    $price_min = $_POST['price_min'] ?? '';
    $price_max = $_POST['price_max'] ?? '';
    $tri = $_POST['tri'] ?? '';

    // Appliquer les filtres sur les résultats initialement trouvés
    $resultats_filtres = array_filter($resultats_initials, function ($annonce) use ($price_min, $price_max) {
        $prix = $annonce['prix_par_jour'];

        // Filtrer par prix minimum
        if (!empty($price_min) && $prix < $price_min) {
            return false;
        }

        // Filtrer par prix maximum
        if (!empty($price_max) && $prix > $price_max) {
            return false;
        }

        return true;
    });

    // Appliquer le tri si sélectionné
    if ($tri === 'prix_croissant') {
        usort($resultats_filtres, function ($a, $b) {
            return $a['prix_par_jour'] <=> $b['prix_par_jour'];
        });
    } elseif ($tri === 'prix_decroissant') {
        usort($resultats_filtres, function ($a, $b) {
            return $b['prix_par_jour'] <=> $a['prix_par_jour'];
        });
    }

    // Stocker les résultats filtrés dans la session
    $_SESSION['resultats'] = $resultats_filtres;

    // Définir un message si aucun résultat n'est trouvé après filtrage
    if (empty($_SESSION['resultats'])) {
        $_SESSION['message'] = "Aucune annonce ne correspond aux filtres appliqués.";
    }

    // Redirection vers la page des résultats
    header("Location: ../recherche.php");
    exit();
}
