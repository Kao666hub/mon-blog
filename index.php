<?php
// Inclure la connexion à la base de données
include('includes/db.php');

// Récupérer tous les articles
$query = "SELECT * FROM articles ORDER BY date DESC";
$statement = $pdo->prepare($query);
$statement->execute();
$articles = $statement->fetchAll(PDO::FETCH_ASSOC);
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