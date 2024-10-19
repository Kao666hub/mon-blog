<?php
session_start();
include('includes/db.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Traitement du formulaire lorsque l'utilisateur soumet les données
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $content = trim($_POST['content']);

    // Insertion des données dans la base de données
    $query = "INSERT INTO articles (title, category, content) VALUES (:title, :category, :content)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':title' => $title,
        ':category' => $category,
        ':content' => $content
    ]);

    // Rediriger vers la page après l'ajout
    header("Location: add_article.php");
    exit;
}

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
    <title>Ajouter un article</title>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <section id="add-article">
        <h2>Ajouter un nouvel article</h2>
        <form action="add_article.php" method="post">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>

            <label for="category">Catégorie :</label>
            <select id="category" name="category" required>
                <option value="Mondes Fictifs">Mondes Fictifs</option>
                <option value="Cours Élaborés">Cours Élaborés</option>
                <option value="Vie Terrienne">Vie Terrienne</option>
            </select>

            <label for="content">Contenu :</label>
            <textarea id="content" name="content" required></textarea>

            <button type="submit" name="submit">Ajouter l'article</button>
        </form>
    </section>

    <a href="logout.php">Déconnexion</a> <!-- Bouton de déconnexion -->

    <h2>Liste des articles</h2>
    <section id="articles-admin">
        <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $article) : ?>
                <div>
                    <h3><?= htmlspecialchars($article['title']); ?></h3>
                    <p>Catégorie : <?= htmlspecialchars($article['category']); ?></p>
                    <a href="edit_article.php?id=<?= $article['id']; ?>">Modifier</a>
                    <a href="delete_article.php?id=<?= $article['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </section>

    <?php include('includes/footer.php'); ?>
</body>
</html>
