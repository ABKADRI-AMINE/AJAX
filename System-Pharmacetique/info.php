<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    $db = db::connect();

    $sql = "SELECT * FROM article WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $articleId, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        // article trouvé, obtenir les détails
        $articleName = $article['nom'];
        $articleQuantity = $article['quantite'];
        $articlePrice = $article['prix'];
    } else {
        // article non trouvé
        $articleName = "article non trouvé";
        $articleQuantity = "N/A";
        $articlePrice = "N/A";

    }
} else {
    $articleName = "Requête invalide";
    $articleQuantity = "N/A";
    $articlePrice = "N/A";

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background-color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Détails de la article</h2>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th scope="row">Nom de l'article</th>
            <td><?php echo $articleName; ?></td>
        </tr>
        <tr>
            <th scope="row">Quantité disponible de l'article</th>
            <td><?php echo $articleQuantity; ?></td>
        </tr>
        <tr>
            <th scope="row">Prix de l'article</th>
            <td><?php echo $articlePrice; ?></td>
        </tr>

        </tbody>
    </table>
    <a href="index.html" class="btn btn-primary mt-3">Retour a la recherche</a>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
