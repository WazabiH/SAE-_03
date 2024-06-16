<?php
require_once('../../ressources/includes/connexion-bdd.php');

$page_courante = "articles";

$formulaire_soumis = !empty($_POST);
$entree_mise_a_jour = array_key_exists("id", $_GET);

$entite = null;
if ($entree_mise_a_jour) {
    $id = $_GET["id"];
    // On cherche l'article à éditer
    $requete_brute = "SELECT * FROM article WHERE id = $id";
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);
    $entite = mysqli_fetch_array($resultat_brut, MYSQLI_ASSOC);
}

if ($formulaire_soumis) {
    $id = $_POST["id"];
    $titre = htmlentities($_POST["titre"]);
    $chapo = htmlentities($_POST["chapo"]);
    $contenu = htmlentities($_POST["contenu"]);
    $image = htmlentities($_POST["image"]);
    $lien_yt = htmlentities($_POST["lien_yt"]);
    $auteur_id = htmlentities($_POST["auteur_id"]);
    // On crée notre requête pour éditer une entité
    $requete_brute = "
        UPDATE article
        SET 
            titre = '$titre',
            chapo = '$chapo',
            contenu = '$contenu',
            image = '$image',
            lien_yt = '$lien_yt', 
            auteur_id = '$auteur_id'           
        WHERE id = '$id'
    ";
    // On met à jour l'élément
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

    if ($resultat_brut === true) {
        // Tout s'est bien passé
        $racineURL = pathinfo($_SERVER['REQUEST_URI']);
        $pageRedirection = $racineURL['dirname'];
        header("Location: $pageRedirection");
    } else {
        // Il y a eu un problème
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>
    <link  rel= "icône de raccourci"  href= "/favicon.ico"  type= "image/x-icon" > 
    <link  rel= "icon"  href= "favicon.ico"  type= "image/x-icon" >

    <title>Editer articles - Administration</title>
</head>

<body>
<?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Editer</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="py-6">
            <?php if ($entite) { ?>
                <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                    <section class="grid gap-6">
                        <input type="hidden" value="<?php echo $entite[
                                'id'
                            ]; ?>" name="id">
                        <div class="col-span-12">
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" name="titre"  value="<?php echo $entite['titre']; ?>"  id="titre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="prenom">
                        </div>
                        <div class="col-span-12">
                            <label for="chapo" class="block text-lg font-medium text-gray-700">Chapô</label>
                            <textarea type="text" name="chapo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="chapo"><?php echo $entite['chapo']; ?></textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="contenu" class="block text-lg font-medium text-gray-700">Contenu</label>
                            <textarea name="contenu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="contenu"><?php echo $entite['contenu']; ?></textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                            <input type="text" name="image" value="<?php echo $entite['image']; ?>" id="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="col-span-12">
                            <label for="lien_yt" class="block text-lg font-medium text-gray-700">Lien YouTube</label>
                            <input type="text" name="lien_yt" value="<?php echo $entite['lien_yt']; ?>" id="lien_yt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700">Éditer</button>
                        </div>
                    </section>
                </form>
                <?php } else { ?>
                    <div>
                        Aucun articles trouvé.
                    </div>
                    <!-- A compléter -->
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>