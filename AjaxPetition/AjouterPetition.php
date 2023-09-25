<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une pétition</title>
    <meta charset="utf-8">
    <script>

        function submitForm() {
            event.preventDefault(); // annule le comportement par défaut du formulaire
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        if (xhr.responseText === 'OK') {
                            alert('La pétition a été ajoutée avec succès !');
                            document.getElementById('ajoutPetition').reset(); // réinitialise le formulaire


                            // Affiche en temps réel la pétition qui a le plus de signatures
                            var xhr2 = new XMLHttpRequest();
                            xhr2.onreadystatechange = function() {
                                if (xhr2.readyState === XMLHttpRequest.DONE) {
                                    if (xhr2.status === 200) {
                                        document.getElementById('petitionPlusSignee').textContent = xhr2.responseText;
                                    } else {
                                        console.log('Erreur : impossible de récupérer la pétition la plus signée.');
                                    }
                                }
                            };
                            xhr2.open('GET', 'PetitionPlusSignee.php');
                            xhr2.send();
                        } else {
                            alert('Une erreur est survenue, la pétition n\'a pas pu être ajoutée.');
                        }
                    } else {
                        alert('Une erreur est survenue, la pétition n\'a pas pu être ajoutée.');
                    }
                }
            };
            xhr.open('POST', 'AjouterPetitiontrait.php');
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var formData = new FormData(document.getElementById('ajoutPetition'));
            xhr.send(new URLSearchParams(formData).toString());
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('ajoutPetition').addEventListener('submit', submitForm);
        });
        function getLatestPetition() {
            var evtSource = new EventSource('DernierePetition.php');
            evtSource.addEventListener('nouvelle-petition', function(event) {
                var latestPetition = event.data.trim();
                if (latestPetition !== '') {
                    // Afficher la notification ici
                    alert('Une nouvelle pétition a été ajoutée: ' + latestPetition);
                }
            });
        }

        getLatestPetition();

    </script>
</head>
<body>
<h1>Ajouter une pétition</h1>
<form id="ajoutPetition" method="post">
    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre"><br>
    <label for="description">Description :</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="date_public">Date de publication :</label>
    <input type="date" id="date_public" name="date_public"><br>

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin"><br>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom"><br>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom"><br>

    <button type="submit">Ajouter</button>
</form>
<p> <span id="petitionPlusSignee"></span></p>

</body>
</html>
