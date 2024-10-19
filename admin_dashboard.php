<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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
    <title>Tableau de Bord Admin</title>
</head>
<body>

</body>
<body>
    <!-- Inclusion du header -->
    <?php include('includes/header.php'); ?>

    <!-- Contenu de l'article -->
        <h2>Bienvenue, <?= $_SESSION['username']; ?> !</h2>
        <p><a href="add_article.php">Ajouter un article</a></p>
        <p><a href="index.php">Voir les articles</a></p>
        <a href="delete_article.php?id=<?= $article['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
        <p><a href="logout.php">Déconnexion</a></p>

    <!-- Inclusion du footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>