<?php
require_once 'db.php';

$db = db::connect();

$sql = "SELECT id, nom, quantite,prix FROM article";
$stmt = $db->prepare($sql);

if ($stmt->execute()) {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>
