<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articleId = isset($_POST["article_id"]) ? $_POST["article_id"] : null;
    $quantity = isset($_POST["quantite"]) ? $_POST["quantite"] : null;

    if ($articleId === null || $quantity === null || !is_numeric($articleId) || !is_numeric($quantity) || $quantity <= 0) {
        echo json_encode(["success" => false]);
        exit;
    }

    $db = db::connect();

    $getPriceSql = "SELECT prix FROM article WHERE id = :articleId";
    $getPriceStmt = $db->prepare($getPriceSql);
    $getPriceStmt->bindValue(':articleId', $articleId, PDO::PARAM_INT);
    $getPriceStmt->execute();
    $row = $getPriceStmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["success" => false]);
        exit;
    }

    $prixArticle = $row['prix'];

    $prixTotal = $prixArticle * $quantity;

    $insertCommandSql = "INSERT INTO commande (article_id, quantite, prix_total, date_commande) VALUES (:articleId, :quantity, :prixTotal, NOW())";
    $insertCommandStmt = $db->prepare($insertCommandSql);
    $insertCommandStmt->bindValue(':articleId', $articleId, PDO::PARAM_INT);
    $insertCommandStmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $insertCommandStmt->bindValue(':prixTotal', $prixTotal, PDO::PARAM_STR);

    if ($insertCommandStmt->execute()) {
        $updateSql = "UPDATE article SET quantite = quantite - :quantity WHERE id = :articleId";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bindValue(':articleId', $articleId, PDO::PARAM_INT);
        $updateStmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
