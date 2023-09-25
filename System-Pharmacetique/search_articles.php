<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchText = isset($_POST["search"]) ? $_POST["search"] : "";

    $db = db::connect();

    if (!empty($searchText)) {
        $sql = "SELECT id, nom,quantite,prix FROM article WHERE nom LIKE :searchText";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':searchText', '%' . $searchText . '%', PDO::PARAM_STR);
    } else {
        echo json_encode([]);
        exit;
    }

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } else {
        echo json_encode([]);
    }
}
?>
