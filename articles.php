<?php
session_start();
include('includes/db.php');

// Définir le nombre d'articles par page
$limit = 5;

// Calculer l'offset pour la pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Vérifier si une catégorie est sélectionnée pour le filtrage
$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    // Si une catégorie est sélectionnée, on filtre les articles
    $query = "SELECT * FROM articles WHERE category = :category ORDER BY date DESC LIMIT :limit OFFSET :offset";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':category', $category, PDO::PARAM_STR);
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Sinon, on récupère tous les articles
    $query = "SELECT * FROM articles ORDER BY date DESC LIMIT :limit OFFSET :offset";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer le nombre total d'articles pour la pagination
$queryTotal = "SELECT COUNT(*) FROM articles";
$statementTotal = $pdo->prepare($queryTotal);
$statementTotal->execute();
$totalArticles = $statementTotal->fetchColumn();

// Calculer le nombre total de pages
$totalPages = ceil($totalArticles / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <title><?= htmlspecialchars($article['title']); ?></title>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- Affichage des articles -->
    <section id="articles-admin">
        <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $article) : ?>
                <div>
                    <h3><?= htmlspecialchars($article['title']); ?></h3>
                    <p>Catégorie : <?= htmlspecialchars($article['category']); ?></p>
                    <p><?= htmlspecialchars(substr($article['content'], 0, 100)); ?>...</p>
                    <a href="edit_article.php?id=<?= $article['id']; ?>">Modifier</a>
                    <a href="delete_article.php?id=<?= $article['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </section>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1; ?>">Précédent</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1; ?>">Suivant</a>
        <?php endif; ?>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
