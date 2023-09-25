<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $quantite = $_POST["quantite"];
    $prix = $_POST["prix"];

    $db = db::connect();

    $sql = "INSERT INTO article (nom, quantite, prix) VALUES (:nom, :quantite, :prix)";
    $stmt = $db->prepare($sql);

    // Exécution de la requête avec les valeurs fournies
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":quantite", $quantite);
    $stmt->bindParam(":prix", $prix);

    if ($stmt->execute()) {
        header("Location: index.html");
        exit();
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
}
?>
