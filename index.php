<?php
require_once "Produit.php";
$produits = new Produit();
$article = $produits->Read();

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "" ;
    $prix = isset($_POST["prix"]) ? floatval($_POST["prix"]) : "" ;
    $quantite = isset($_POST["quantite"]) ? intval($_POST["quantite"]) : "" ;

    // Vérification que le champ n'est pas vide
    if ($name !== "" && $prix !== "" && $quantite !== ""){
        // Stockage dans la session
        $retour = $produits->Ajouter($name, $prix, $quantite);
        if($retour){
            $_SESSION["Confirmation"] = "Message envoyé";
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
    <title>Liste des produits</title>
</head>
<body>
<form action="index.php" method="post" style="padding: 8px 0 16px 8px">
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" required placeholder="Entrez le nom"/>
    <label for="prix">Prix :</label>
    <input type="text" id="prix" name="prix" required placeholder="Entrez le prix"/>
    <label for="quantite">Quantité :</label>
    <input type="text" id="quantite" name="quantite" required placeholder="Entrez la quantité"/>
    <button type="submit">Envoyer</button>
</form>
<?php if(!empty($article)): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Modification</th>
            <th>Suppression</th>
        </tr>
        </thead>
        <tbody>
        <!-- PHP -->
        <?php foreach($article as $a):  ?>
            <tr>
                <td><?= htmlspecialchars($a['Id_Article']) ?></td>
                <td><?= htmlspecialchars($a['Designation_Article']) ?></td>
                <td><?= htmlspecialchars($a['Prix_unitaire_Article']) ?></td>
                <td><?= htmlspecialchars($a['Quantite_Article']) ?></td>
                <td><a href="modif.php?id=<?= htmlspecialchars($a['Id_Article']) ?>">Modifier</a></td>
                <td><a href="Suppression.php?id=<?= htmlspecialchars($a['Id_Article']) ?>">Supprimer</a></td>
            </tr>
        <?php endforeach;  ?>
        </tbody>
    </table>
<?php else:  ?>
    <p>Aucun auteur</p>
<?php endif; ?>

</body>
</html>