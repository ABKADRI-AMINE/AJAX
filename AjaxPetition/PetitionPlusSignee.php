<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// récupération de la pétition la plus signée
$requete = $bdd->prepare('SELECT p.Titre, COUNT(s.IDP) AS nbSignatures FROM petition p INNER JOIN signature s ON p.IDP = s.IDP GROUP BY p.IDP ORDER BY nbSignatures DESC LIMIT 1');
$requete->execute();
$resultat = $requete->fetch(PDO::FETCH_ASSOC);

// affichage de la pétition la plus signée
echo 'La pétition qui a le plus de signatures : '.$resultat['Titre'].' ('.$resultat['nbSignatures'].' signatures)';
?>
