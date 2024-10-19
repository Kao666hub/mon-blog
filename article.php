<?php
// Inclure la connexion à la base de données
include('includes/db.php');

// Vérifier si l'ID de l'article est dans l'URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    // Récupérer l'article correspondant
    $query = "SELECT * FROM articles WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $article_id]);
    $article = $statement->fetch(PDO::FETCH_ASSOC);

    // Si l'article n'est pas trouvé, rediriger vers la page d'accueil
    if (!$article) {
        header("Location: index.php");
        exit;
    }
} else {
    // Si aucun ID n'est fourni, rediriger vers la page d'accueil
    header("Location: index.php");
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
    <title><?= htmlspecialchars($article['title']); ?></title>
</head>

<body>
    <!-- Inclusion du header -->
    <?php include('includes/header.php'); ?>

    <!-- Contenu de l'article -->
    <section id="article-content">
        <h2><?= htmlspecialchars($article['title']); ?></h2>
        <p><?= htmlspecialchars($article['content']); ?></p>
        <p><strong>Catégorie :</strong> <?= htmlspecialchars($article['category']); ?></p>
        <p><strong>Date :</strong> <?= htmlspecialchars($article['date']); ?></p>
    </section>

    <!-- Inclusion du footer -->
    <?php include('includes/footer.php'); ?>
</body>

</html>
