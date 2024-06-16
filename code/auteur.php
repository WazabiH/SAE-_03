<?php
$couleur_bulle_classe = "rose";
$page_active = "equipe";

require_once('./ressources/includes/connexion-bdd.php');

// Récupérer l'ID de l'auteur
$auteur_id = isset($_GET['auteur_id']) ? $_GET['auteur_id'] : 0;

// Récupérer les informations de l'auteur avec son avatar et lien Twitter
$requete_auteur = "SELECT * FROM auteur WHERE id = $auteur_id";
$resultat_auteur = mysqli_query($mysqli_link, $requete_auteur);
$auteur = mysqli_fetch_assoc($resultat_auteur);

// Récupérer les articles de l'auteur
$requete_articles = "SELECT * FROM article WHERE auteur_id = $auteur_id";
$resultat_articles = mysqli_query($mysqli_link, $requete_articles);
$articles = mysqli_fetch_all($resultat_articles, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteur de <?php echo htmlspecialchars_decode($auteur['nom'] . ' ' . $auteur['prenom']); ?> - SAÉ 203</title>

    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/fonts.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/accueil.css">
    <link  rel= "icône de raccourci"  href= "/favicon.ico"  type= "image/x-icon" > 
    <link  rel= "icon"  href= "favicon.ico"  type= "image/x-icon" >
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php require_once('./ressources/includes/bulle.php');?>

    <main class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-center mb-8">
            <?php if (!empty($auteur['lien_avatar'])) : ?>
                <a href="<?php echo htmlspecialchars_decode($auteur['lien_twitter']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo htmlspecialchars_decode($auteur['lien_avatar']); ?>" alt="Avatar de <?php echo htmlspecialchars_decode($auteur['nom'] . ' ' . $auteur['prenom']); ?>" class="h-24 w-24 object-cover">
                </a>
            <?php endif; ?>
        </div>
            <h1 class="text-3xl font-bold mb-4 text-center">Articles de <?php echo htmlspecialchars_decode($auteur['nom'] . ' ' . $auteur['prenom']); ?></h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($articles as $article) : ?>
        <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition duration-300 transform hover:scale-105 hover:shadow-xl">
        <?php if (!empty($article['lien_image'])) : ?>
            <img src="<?php echo htmlspecialchars_decode($article['lien_image']); ?>" alt="Image de l'article" class="w-full h-64 object-cover">
        <?php endif; ?>
        <div class="p-6">
            <h2 class="text-xl font-bold"><?php echo htmlspecialchars_decode($article['titre']); ?></h2>
            <p class="text-gray-600 mt-2"><?php echo date("d/m/Y", strtotime($article['date_creation'])); ?></p>
            <p class="text-gray-800 mt-4"><?php echo htmlspecialchars_decode($article['chapo']); ?></p>
            <a href="article.php?id=<?php echo $article['id']; ?>" class="mt-4 block text-blue-600 hover:text-blue-800">Lire l'article</a>
        </div>
    </div>
            <?php endforeach; ?>
        </div>
    </main> 
    </main>
</body> 
    <?php require_once('./ressources/includes/footer.php'); ?>