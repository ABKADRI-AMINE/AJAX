<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=tppetition;charset=utf8', 'root', '');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Requête pour récupérer toutes les pétitions
$requete = $bdd->query('SELECT * FROM petition');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des pétitions</title>
</head>
<style>
    /* Style pour la liste */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #00bfff;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    /* Style pour le titre de la page */
    h1 {
        background-color: #00bfff;
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 0;
    }

    /* Style pour le corps de la page */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
    }

    /* Style pour le contenu de la page */
    main {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
    }
</style>
<body>
<main>
    <h1>Liste des pétitions</h1>

    <table>
        <thead>
        <tr>
            <th>IDP</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Description</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Titre</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Boucle pour afficher toutes les pétitions
        while($petition = $requete->fetch()) {
            echo '<tr>';
            echo '<td>' . $petition['IDP'] . '</td>';
            echo '<td>' . $petition['Nom'] . '</td>';
            echo '<td>' . $petition['Prenom'] . '</td>';
            echo '<td>' . $petition['Description'] . '</td>';
            echo '<td>' . $petition['DatePublic'] . '</td>';
            echo '<td>' . $petition['DateFin'] . '</td>';
            echo '<td>' . $petition['Titre'] . '</td>';
            echo '<td><a href="signature.php?idp=' . $petition['IDP'] . '">Signer</a></td>'; // Lien vers le formulaire de signature avec l'IDP de la pétition en paramètre
            echo '</tr>';
        }
        $requete->closeCursor(); // Libère la connexion
        ?>
        </tbody>
    </table>
</main>
</body>
</html>
