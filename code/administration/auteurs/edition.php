<?php
require_once '../../ressources/includes/connexion-bdd.php';

$page_courante = 'auteurs'; // nom de la page

$formulaire_soumis = !empty($_POST); // vérifie si le formulaire à été soumis 
$entree_mise_a_jour = array_key_exists('id', $_GET); // vérifie si un identifiant est présent dans l'URL pour savoir si une mise à jour est en cours.

$entite = null; // variable pour stoker les informations de l'auteur 
if ($entree_mise_a_jour) {
    $id = $_GET["id"];
    $requete_brute = "SELECT * FROM auteur WHERE id = $id"; // requête crée , ici on séléctionne le tableau "auteur" pour obtenir tout les infos sur lui 
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute); // envoie la commande SQL à la abse donnée et stocke le résultat dans la variable
    $entite = mysqli_fetch_array($resultat_brut, MYSQLI_ASSOC);// prends le résultat de la requête et le transforme en un tableau avec les données stocker 
}// Récupération des informations de l'auteur si une mise à jour est en cours

if ($formulaire_soumis) {
    $id = $_POST["id"];
    $nom = htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $lien_avatar = htmlentities($_POST["lien_avatar"]);
    $lien_twitter = htmlentities($_POST["lien_twitter"]);

    $requete_brute = "
        UPDATE auteur 
        SET 
            nom = '$nom',
            prenom = '$prenom',
            lien_avatar ='$lien_avatar',
            lien_twitter ='$lien_twitter' 
        WHERE id = '$id'
    "; // permet de faire une mise à jour d'un ensemble de champs , ici c'ets auteur , sans le where on modifie toute la table mais grâve à ça on modifie que l'identifiant appeler 

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
    <?php include_once '../ressources/includes/head.php'; ?>
    <link  rel= "icône de raccourci"  href= "/favicon.ico"  type= "image/x-icon" > 
    <link  rel= "icon"  href= "favicon.ico"  type= "image/x-icon" >

    <title>Editeur auteur - Administration</title>
</head>

<body>
    <?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4">
        <h1 class="text-3xl font-bold text-gray-900">Editer</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6">
            <div class="py-6">
            <?php if ($entite) { ?>
                    <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                        <section class="grid gap-6">
                            <input type="hidden" value="<?php echo $entite[
                                'id'
                            ]; ?>" name="id">
                            <div class="col-span-12">
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                                <input type="text" value="<?php echo $entite[
                                    'nom'
                                ]; ?>" name="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="nom">
                            </div>
                            <div class="col-span-12">
                                <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                                <input type="text" value="<?php echo $entite[
                                    'prenom'
                                ]; ?>" name="prenom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="prenom">
                            </div>
                            <div class="col-span-12">
                                <label for="avatar" class="block text-lg font-medium text-gray-700">Lien avatar</label>
                                <input type="url" value="<?php echo $entite['lien_avatar']; ?>" name="lien_avatar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="avatar">
                                <div class="text-sm text-gray-500">
                                    Mettre l'URL de l'avatar (chemin absolu)
                                </div>
                            </div>
                            <div class="col-span-12">
                                <label for="lien_twitter" class="block text-lg font-medium text-gray-700">Lien twitter</label>
                                <input type="text" value="<?php echo $entite[
                                    'lien_twitter'
                                ]; ?>" name="lien_twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="lien_twitter">
                            </div>
                            <div class="mb-3 col-md-6 flex justify-between">
                                <button type="submit" class="font-bold rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700">Éditer</button>
                            </div>
                        </section>
                    </form>
                <?php } else { ?>
                    <div>
                        Aucun auteur trouvé.
                    </div>
                    <!-- A compléter -->
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>
</html>