<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// récupération des données du formulaire
$titre = $_POST['titre'];
$description = $_POST['description'];
$datePublic = $_POST['date_public'];
$dateFin = $_POST['date_fin'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];


// insertion des données dans la table Petition
$requete = $bdd->prepare('INSERT INTO petition (Nom, Prenom, Description, DatePublic, DateFin, Titre) VALUES (?, ?, ?, ?, ?, ?)');
if ($requete->execute(array($nom, $prenom, $description, $datePublic, $dateFin, $titre))) {
    // réponse envoyée au client si l'ajout s'est bien déroulé
    echo 'OK';
} else {
    // réponse envoyée au client si l'ajout s'est mal déroulé
    echo 'NotOK';
}
?>
