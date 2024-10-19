<?php
include('includes/db.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur dans la base de données
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute(['username' => $username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);    

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Identifiants incorrects";
    }

    if ($user) {
        echo "Utilisateur trouvé : " . htmlspecialchars($user['username']) . "<br>";
        if (password_verify($password, $user['password'])) {
            echo "Mot de passe vérifié<br>";
        } else {
            echo "Mot de passe incorrect<br>";
        }
    } else {
        echo "Utilisateur non trouvé<br>";
    }
    
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <title>Nom de l'article</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Se connecter</button>

        <?php if (isset($error)) : ?>
            <p><?= $error; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
