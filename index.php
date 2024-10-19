<?php
// Inclure la connexion à la base de données
include('includes/db.php');

// Récupérer tous les articles
$query = "SELECT * FROM articles ORDER BY date DESC";
$statement = $pdo->prepare($query);
$statement->execute();
$articles = $statement->fetchAll(PDO::FETCH_ASSOC);

// Définir le nombre d'articles par page
$limit = 5;

// Calculer l'offset
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupérer les articles avec LIMIT et OFFSET
$query = "SELECT * FROM articles ORDER BY date DESC LIMIT :limit OFFSET :offset";
$statement = $pdo->prepare($query);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$articles = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nombre total d'articles
$queryTotal = "SELECT COUNT(*) FROM articles";
$statementTotal = $pdo->prepare($queryTotal);
$statementTotal->execute();
$totalArticles = $statementTotal->fetchColumn();

// Calculer le nombre total de pages
$totalPages = ceil($totalArticles / $limit);

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
?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <title>Chaos</title>
</head>

<body>
    <!-- Inclusion du header -->
    <?php include('includes/header.php'); ?>

    <!-- Section des articles récents -->
    <section id="articles-recents">
        <h2>Articles récents</h2>
            <?php foreach ($articles as $article) : ?>
                <article>
                    <h3><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h3>
                    <p><?= substr(htmlspecialchars($article['content']), 0, 150) . '...'; ?></p>

                    <!-- Ajouter les boutons Modifier et Supprimer -->
                    <a href="edit_article.php?id=<?= $article['id']; ?>">Modifier</a>
                    <a href="delete_article.php?id=<?= $article['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                </article>
            <?php endforeach; ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1; ?>">Précédent</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1; ?>">Suivant</a>
                <?php endif; ?>
            </div>

        </section>

        <!-- Section à propos -->
        <section id="a-propos">
            <h2>À propos de moi</h2>
            <p>Lorem ipsum</p>
        </section>

    <!-- Pied de page -->
    <!-- Inclusion du footer -->
    <?php include('includes/footer.php'); ?>
</body>

</html>