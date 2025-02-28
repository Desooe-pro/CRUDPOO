<?php
require "Produit.php";
$produits = new Produit();

$id = isset($_GET["id"]) ? $_GET["id"] : 0 ;

$article = $produits->ReadID($id);

if (empty($article)) {
    $_SESSION["Message"] = "Article introuvable !";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = !empty($_POST["name"]) ? trim($_POST["name"]) : $article[0]["Designation_Article"];
    $prix = !empty($_POST["prix"]) ? floatval($_POST["prix"]) : floatval($article[0]["Prix_unitaire_Article"]);
    $quantite = !empty($_POST["quantite"]) ? intval($_POST["quantite"]) : intval($article[0]["Quantite_Article"]);

    // Vérification que le champ n'est pas vide
    if ($name !== "" && $prix !== "" && $quantite !== ""){
        try{
            $retour = $produits->Update($name, $prix, $quantite, $id);
            if($retour){
                $_SESSION["Confirmation"] = "Message envoyé";
            }
        } catch(PDOException $e){
            echo 'error  est survenue '.$e->getMessage();
        }

        // Redirection vers la même page
        header("Location: index.php"); // Les ":" doivent toujours être collés à "Location"
        exit();
    } else {
        // Message d'erreur
        $_SESSION["Message"] = "Veuillez indiquer les bonnes informations !";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="crudintro.css">
    <title>Liste des auteurs</title>
</head>
<body>
    <a href="index.php"><button>Retour</button></a>
    <form action="modif.php?id=<?= htmlspecialchars($id)?>" method="post">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" placeholder="Entrez le nom"/>
        <label for="prix">Prix :</label>
        <input type="text" id="prix" name="prix" placeholder="Entrez le prix"/>
        <label for="quantite">Quantité :</label>
        <input type="text" id="quantite" name="quantite" placeholder="Entrez la quantité"/>
        <button type="submit">Envoyer</button>
    </form>


</body>
</html>