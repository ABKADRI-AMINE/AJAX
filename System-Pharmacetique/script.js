$(document).ready(function () {
    var articlesList = [];
    var itemsPerPage = 4;
    var currentPage = 1;
    var currentArticle;

    function displayArticles(articles) {
        var tableBody = $("#tableBody");
        tableBody.empty();

        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = Math.min(startIndex + itemsPerPage, articles.length);

        for (var i = startIndex; i < endIndex; i++) {
            var article = articles[i];

            var row = $("<tr></tr>");
            row.append("<td>" + article.nom + "</td>");

            var voirButton = $("<button class='btn btn-info btn-sm'>Voir</button>");
            voirButton.attr("data-article-id", article.id);
            var actionCell = $("<td></td>");
            actionCell.append(voirButton);
            row.append(actionCell);

            var updateButton = $("<button class='btn btn-primary btn-sm'>Mise à jour</button>");
            updateButton.attr("data-article-id", article.id);
            var updateCell = $("<td></td>");
            updateCell.append(updateButton);
            updateButton.click(function () {
                var articleId = $(this).attr("data-article-id");
                window.location.href = "updatearticle.php?id=" + articleId;
            });
            row.append(updateCell);

            var addCell = $("<td class='align-middle'></td>");
            var inputGroup = $('<div class="input-group" style="display: flex; align-items: center;"></div>');
            var quantityInput = $('<input type="number" class="form-control" id="quantityInput">');
            var addButton = $("<button class='btn btn-success btn-sm'>Ajouter</button>");
            inputGroup.append(quantityInput);
            inputGroup.append(addButton);
            addCell.append(inputGroup);
            row.append(addCell);

            var addCelll = $("<td class='align-middle'></td>");
            var prixtotal = $('<div class="prixt" style="display: flex; align-items: center;"></div>');
            var prixt = $('<input type="number" class="form-control" id="prixt" value="0" readonly>');
            prixtotal.append(prixt);
            addCelll.append(prixtotal);
            row.append(addCelll);

            tableBody.append(row);

            addButton.data("article", article);

            addButton.click(function () {
                var article = $(this).data("article");
                var articleId = article.id;
                var quantityInput = $(this).closest("tr").find("#quantityInput");
                var quantity = parseInt(quantityInput.val());
                var availableQuantity = parseInt(article.quantite);

                if (isNaN(quantity) || quantity <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Veuillez entrer une quantité valide.'
                    });
                    return;
                } else if (quantity > availableQuantity) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'La quantité commandée ne peut pas dépasser la quantité disponible.'
                    });
                    return;
                }

                quantityInput.prop("disabled", true);

                $.ajax({
                    url: "ajouter_commande.php",
                    method: "POST",
                    data: { article_id: articleId, quantite: quantity },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: 'Commande ajoutée avec succès!'
                            });

                            var totalPrice = (quantity * article.prix).toFixed(2);
                            console.log("Prix total:", totalPrice);
                            quantityInput.closest("tr").find("#prixt").val(totalPrice);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Erreur lors de l\'ajout de la commande.'
                            });
                        }
                        quantityInput.prop("disabled", false);
                        quantityInput.val("");
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur lors de la communication avec le serveur.'
                        });
                        quantityInput.prop("disabled", false);
                    }
                });
            });
        }

        $(".btn-info").click(function () {
            getArticle($(this).attr("data-article-id"));
        });

        updatePagination(articles.length);
    }

    function updatePagination(totalItems) {
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var pagination = $("#pagination");
        pagination.empty();

        for (var i = 1; i <= totalPages; i++) {
            var pageItem = $("<li class='page-item'></li>");
            var pageLink = $("<a class='page-link'></a>");
            pageLink.text(i);
            pageLink.attr("data-page", i);
            pageItem.append(pageLink);
            pagination.append(pageItem);
        }

        $(".page-link").click(function () {
            currentPage = parseInt($(this).attr("data-page"));
            displayArticles(articlesList);
        });
    }

    function getArticle(articleId) {
        window.location.href = "info.php?id=" + articleId;
    }

    function loadAllArticles() {
        $.ajax({
            url: "load_all_articles.php",
            method: "POST",
            dataType: "json",
            success: function (data) {
                articlesList = data;
                displayArticles(articlesList);
            },
            error: function () {
                var tableBody = $("#tableBody");
                tableBody.empty();
                tableBody.append("<tr><td colspan='4'>Erreur lors du chargement des articles.</td></tr>");
            }
        });
    }

    loadAllArticles();

    $("#searchInput").keyup(function (evt) {
        var searchText = $("#searchInput").val();

        if (searchText.length >= 1) {
            var filteredArticles = articlesList.filter(function (article) {
                return article.nom.toLowerCase().startsWith(searchText.toLowerCase());
            });
            displayArticles(filteredArticles);
        } else {
            displayArticles(articlesList);
        }
    });
});
