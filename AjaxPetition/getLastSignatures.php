<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

$requete = $bdd->query('SELECT * FROM signature ORDER BY IDS DESC LIMIT 5');
$listeSignatures = '';
while ($donnees = $requete->fetch()) {
    $listeSignatures .= $donnees['Nom'].' '.$donnees['Prenom'].' ('.$donnees['Pays'].') le '.$donnees['Date'].' à '.$donnees['Heure']."\n";
}
echo $listeSignatures;
?>