<?php
include('includes/db.php');

// Récupérer l'article à modifier
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    $query = "SELECT * FROM articles WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $article_id]);
    $article = $statement->fetch(PDO::FETCH_ASSOC);

    // Si l'article n'existe pas, rediriger vers la page d'accueil
    if (!$article) {
        header("Location: index.php");
        exit;
    }
}

// Mettre à jour l'article
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    $query = "UPDATE articles SET title = :title, category = :category, content = :content WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':title' => $title,
        ':category' => $category,
        ':content' => $content,
        ':id' => $article_id
    ]);

    // Rediriger vers la page d'accueil après modification
    header("Location: index.php");
    exit;
}
?>

<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si non connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <title>Modifier l'article</title>
</head>


<body>
    <?php include('includes/header.php'); ?>

    <section id="edit-article">
        <h2>Modifier l'article</h2>
        <form action="edit_article.php?id=<?= $article_id; ?>" method="post">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']); ?>" required>

            <label for="category">Catégorie :</label>
            <input type="text" id="category" name="category" value="<?= htmlspecialchars($article['category']); ?>" required>

            <label for="content">Contenu :</label>
            <textarea id="content" name="content" required><?= htmlspecialchars($article['content']); ?></textarea>

            <button type="submit" name="submit">Mettre à jour</button>
        </form>
    </section>

    <?php include('includes/footer.php'); ?>
</body>

</html>
