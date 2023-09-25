<?php
require_once 'db.php';

if (isset($_GET["id"])) {
    $articleId = $_GET["id"];

    $db = db::connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST["nom"];
        $quantite = $_POST["quantite"];
        $prix = $_POST["prix"];

        $updateSql = "UPDATE article SET nom = :nom, quantite = :quantite, prix = :prix WHERE id = :id";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bindParam(":nom", $nom);
        $updateStmt->bindParam(":quantite", $quantite);
        $updateStmt->bindParam(":prix", $prix);
        $updateStmt->bindParam(":id", $articleId);

        if ($updateStmt->execute()) {
            header("Location: index.html");
            exit();
        } else {
            echo "Erreur lors de la mise à jour des données.";
        }
    }
} else {
    echo "Identifiant d'article non spécifié.";
}
?>
