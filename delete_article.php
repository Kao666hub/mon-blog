<?php
include('includes/db.php');

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Supprimer l'article de la base de données
    $query = "DELETE FROM articles WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $article_id]);

    // Rediriger vers la page d'accueil après suppression
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
