<?php
$host = 'localhost'; // Le serveur MySQL
$dbname = 'blog_db'; // Le nom de ta base de données
$username = 'root'; // Par défaut sur WAMP
$password = ''; // Laisse vide par défaut sur WAMP

// Créer une connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Activer le mode d'erreur PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
