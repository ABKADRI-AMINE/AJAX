<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Signature</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<main>
    <h1>Signature</h1>
    <form id="signature-form" method="post" action="ajouterSignature.php">
        <label for="idp">IDP:</label>
        <input type="text" id="idp" name="idp" required>
        <br>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="pays">Pays:</label>
        <input type="text" id="pays" name="pays" required>
        <br>
        <input type="submit" value="Envoyer">
    </form>
    <div id="result"></div>
    <br>
    <label for="liste-signatures">Cinq dernières signatures:</label>
    <textarea id="liste-signatures" rows="5"></textarea>
</main>
<script>
    $(document).ready(function () {
        $('#signature-form').submit(function (event) {
            event.preventDefault(); // Empêche la soumission normale du formulaire
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(), // Sérialise les données du formulaire
                success: function (data) {
                    $('#result').html(data);
                    $('#signature-form')[0].reset(); // Réinitialise le formulaire
                    updateListeSignatures();
                }
            });
        });
        function updateListeSignatures() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'getLastSignatures.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    $('#liste-signatures').val(xhr.responseText);
                }
            }
            xhr.send();
        }

        updateListeSignatures(); // Met à jour la liste des signatures au chargement de la page
    });
</script>
</body>
</html>