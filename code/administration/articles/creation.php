<?php
require_once('../../ressources/includes/connexion-bdd.php');

$page_courante = "articles";

$formulaire_soumis = !empty($_POST);

if ($formulaire_soumis) {
    if (
        isset(
            $_POST["titre"],
            $_POST["chapo"],
            $_POST["contenu"],
            $_POST["image"],
            $_POST["lien_yt"],
            $_POST["auteur_id"]
        )
    ){

        $titre = htmlentities($_POST["titre"]);
        $chapo = htmlentities($_POST["chapo"]);
        $contenu = htmlentities($_POST["contenu"]);
        $image = htmlentities($_POST["image"]);
        $lien_yt = htmlentities($_POST["lien_yt"]);// On prépare notre requête pour créer une nouvelle entité
        $auteur_id = htmlentities($_POST["auteur_id"]);

        $requete_brute = "
        INSERT INTO article(titre, chapo, contenu, image, lien_yt, auteur_id) 
        VALUES ('$titre', '$chapo', '$contenu', '$image', '$lien_yt', '$auteur_id')
        ";
        // On crée une nouvelle entrée
        $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

        if ($resultat_brut) {
            // Tout s'est bien passé
            $racineURL = pathinfo($_SERVER['REQUEST_URI']);
            $pageRedirection = $racineURL['dirname'];
            header("Location: $pageRedirection");
        } else {
            // Il y a eu un problème
        }
       
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>
    <link  rel= "icône de raccourci"  href= "/favicon.ico"  type= "image/x-icon" > 
    <link  rel= "icon"  href= "favicon.ico"  type= "image/x-icon" >

    <title>Creation d'un article - Administration</title>
</head>

<body>
    <?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un article</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="py-6">
                <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                    <section class="grid gap-6">
                        <div class="col-span-12">
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" name="titre"  id="titre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="prenom">
                        </div>
                        <div class="col-span-12">
                            <label  for="chapo" class="block text-lg font-medium text-gray-700">Chapô</label>
                            <textarea type="text" name="chapo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="chapo"></textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="contenu" class="block text-lg font-medium text-gray-700">Contenu</label>
                            <textarea name="contenu" id="contenu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                            <input type="text" name="image" id="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="col-span-12">
                            <label for="lien_yt" class="block text-lg font-medium text-gray-700">Lien YouTube</label>
                            <input type="text" name="lien_yt" id="lien_yt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="col-span-12">
                            <label for="auteur_id" class="block text-lg font-medium text-gray-700">Auteur</label>
                            <select name="auteur_id" id="auteur_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <?php
                                $requete = "SELECT id, nom, prenom FROM auteur";
                                $requete_auteur = mysqli_query($mysqli_link, $requete);

                                if ($requete_auteur && mysqli_num_rows($requete_auteur) > 0) {
                                    while ($row = mysqli_fetch_assoc($requete_auteur)) {
                                        $selected = ($row["id"] == $entite['auteur_id']) ? 'selected' : '';
                                        echo "<option value='" . $row["id"] . "' $selected>" . htmlspecialchars_decode($row["nom"] . " " . $row["prenom"]) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Aucune donnée disponible</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700">Créer</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>