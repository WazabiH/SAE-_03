<?php
$couleur_bulle_classe = "violet";
$page_active = "equipe";

require_once('./ressources/includes/connexion-bdd.php');

// Vos requêtes SQL
$requete_auteurs = "SELECT id, nom, prenom, lien_avatar FROM auteur";
$resultat_auteurs = mysqli_query($mysqli_link, $requete_auteurs);

$auteurs = mysqli_fetch_all($resultat_auteurs, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe de Rédaction - SAÉ 203</title>

    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/fonts.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/accueil.css">
    <link rel="stylesheet" href="ressources/css/equiperedaction.css">

    <link rel="stylesheet" href="ressources/css/global.css">
    <link rel="stylesheet" href="ressources/css/equipe.css">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php require_once('./ressources/includes/bulle.php'); ?>

    <main class="conteneur-principal conteneur-1280">
        <div class="container">
            <h1 class="titre text-center">Équipe de Rédaction</h1>
            <div class="team-container">
                <?php foreach ($auteurs as $auteur) : ?>
                    <div class="team-member">
                        <a href="auteur.php?auteur_id=<?php echo $auteur['id']; ?>" class="auteur">
                            <img src="<?php echo isset($auteur['lien_avatar']) ? htmlspecialchars_decode($auteur['lien_avatar']) : 'ressources/images/default.jpg'; ?>" alt="Photo de profil de <?php echo htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']); ?>" class="member-photo">
                        </a>
                        <div class="member-info">
                            <p class="member-name"><?php echo htmlspecialchars_decode($auteur['nom'] . ' ' . $auteur['prenom']); ?></p>
                            <?php if (isset($auteur['role'])) : ?>
                                <p class="member-role"><?php echo htmlspecialchars_decode($auteur['role']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php require_once('./ressources/includes/footer.php'); ?>
</body>

</html>