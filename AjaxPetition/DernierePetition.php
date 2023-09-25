<?php
// connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$lastId = 0;
while (true) {
    // récupération des pétitions ajoutées à la base de données depuis la dernière requête
    $requete = $bdd->prepare('SELECT Titre FROM petition WHERE IDP > :lastId ORDER BY IDP DESC');
    $requete->bindParam(':lastId', $lastId, PDO::PARAM_INT);
    $requete->execute();

    while ($donnees = $requete->fetch()) {
        // envoi d'un événement SSE contenant les données de la nouvelle pétition
        echo "event: nouvelle-petition\n";
        echo "data: ".$donnees['Titre']."\n\n";
        ob_flush();
        flush();
    }

    // mise à jour de l'ID de la dernière pétition traitée
    $requete = $bdd->query('SELECT MAX(IDP) AS lastId FROM petition');
    $donnees = $requete->fetch();
    $lastId = $donnees['lastId'];

    // attente de 2 secondes avant la prochaine requête
    sleep(2);
}
?>
