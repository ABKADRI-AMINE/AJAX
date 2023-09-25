<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

$idp = $_POST['idp'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$pays = $_POST['pays'];
$date = date('Y-m-d');
$heure = date('H:i:s');

$requete = $bdd->prepare('INSERT INTO signature (IDP, Nom, Prenom, Email, Pays, Heure, Date) VALUES (?, ?, ?, ?, ?, ?, ?)');
if ($requete->execute(array($idp, $nom, $prenom, $email, $pays, $heure, $date))) {
    echo 'OK';
} else {
    echo 'NotOK';
}
?>
