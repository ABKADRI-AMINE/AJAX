<!DOCTYPE html>
<html>
<head>
    <title>Mettre à jour un article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-container {
            text-align: right;
            margin-top: 15px;
        }
        .btn-container .btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Mettre à jour un article</h2>
    <div class="form-container">
        <?php
        require_once 'db.php';

        if (isset($_GET["id"])) {
            $articleId = $_GET["id"];

            $db = db::connect();

            $sql = "SELECT * FROM article WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $articleId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $article = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="update_article_process.php?id=<?php echo $articleId; ?>" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="nom">Nom de l'article:</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $article['nom']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité :</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" value="<?php echo $article['quantite']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" class="form-control" id="prix" name="prix" value="<?php echo $article['prix']; ?>" required>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="index.html" class="btn btn-secondary">Retour à la recherche</a>
                    </div>
                </form>
                <?php
            } else {
                echo "L'article avec l'identifiant spécifié n'existe pas.";
            }
        } else {
            echo "Identifiant d'article non spécifié.";
        }
        ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>\
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function validateForm() {
        var quantite = parseFloat(document.getElementById("quantite").value);
        var prix = parseFloat(document.getElementById("prix").value);

        if (isNaN(quantite) || isNaN(prix) || quantite <= 0 || prix <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Veuillez saisir des quantites et des prix positifs.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return false;
        }

        return true;
    }
</script>
</script>
</body>
</html>
