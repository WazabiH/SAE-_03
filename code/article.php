<?php
$couleur_bulle_classe = "rose";
$page_active = "index";

require_once('./ressources/includes/connexion-bdd.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Requête SQL pour récupérer l'article et les détails de l'auteur
    $requete_brute = "
        SELECT article.*, auteur.prenom, auteur.nom 
        FROM article
        LEFT JOIN auteur 
        ON article.auteur_id = auteur.id
        WHERE article.id = $id
    ";
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

    if (!$resultat_brut) {
        die('Erreur de requête SQL : ' . mysqli_error($mysqli_link));
    }

    $entite = mysqli_fetch_assoc($resultat_brut);
    $auteur = $entite['prenom'] . ' ' . $entite['nom'];

    // Fonction pour intégrer le lien YouTube
    function integrerlien($lien) {
        $pattern = "/^https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/";
        $replace = "https://www.youtube.com/embed/$1";
        return preg_replace($pattern, $replace, $lien);
    }
} else {
    echo "ID d'article invalide.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - SAÉ 203</title>

    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/fonts.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/accueil.css">

    <link rel="stylesheet" href="ressources/css/global.css">
    <link rel="stylesheet" href="ressources/css/accueil.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        .bg-bordeaux {
            background-color: #800020;
        }
        .text-bordeaux {
            color: #800020;
        }
        .responsive-iframe {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%;
        }
        .responsive-iframe iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .contenu p {
            margin-top: 1.5rem; /* Ajoute un espace au début de chaque paragraphe */
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php require_once('./ressources/includes/bulle.php'); ?>
    <main class="max-w-7xl mx-auto px-12 py-8 bg-white shadow-md rounded-lg border-8">
        <div id="hautarticle" class="mb-8">
            <h1 class="text-4xl font-bold mb-4 text-bordeaux"><?php echo $entite["titre"]; ?></h1>
            <h2 class="text-2xl font-semibold mb-4 text-bordeaux"><?php echo $entite["chapo"];?></h2>
            <p class="text-lg text-gray-600 mb-4">
                Rédigé par <?php echo $auteur; ?> le <?php echo $entite["date_creation"];?>
            </p>
            <figure class="mb-8">
                <img src="<?php echo $entite["image"];?>" alt="image de l'article" class="w-full h-auto rounded">
            </figure>
            <div class="contenu leading-relaxed">
                <?php
                // Divise le contenu en paragraphes en utilisant PHP
                $paragraphes = explode("\n", $entite["contenu"]);
                foreach ($paragraphes as $paragraphe) {
                    echo '<p class="font-medium text-base">' . $paragraphe . '</p>';
                }
                ?>
            </div>
            <?php
            if (!empty($entite["lien_yt"])) {
                $lien_yt_integre = integrerlien($entite["lien_yt"]);
                echo '<div class="responsive-iframe my-8">';
                echo '<iframe src="'.$lien_yt_integre.'" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                echo '</div>';
            }        
            ?>        
        </div>
    </main>
    <?php require_once('./ressources/includes/footer.php'); ?>
</body> 
</html>
