<?php
require_once __DIR__ . '/../../controllers/QuizController.php';
require_once __DIR__ . '/../../helpers/functions.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    redirect('/view/auth/login.php');
}

$quizCtrl = new QuizController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = post('title');
    $description = post('description');

    if ($title && $description) {
        if ($quizCtrl->create($title, $description)) {
            $message = "Quiz créé avec succès !";
        } else {
            $message = "Erreur lors de la création du quiz.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un quiz</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Créer un quiz</h1>

    <?php if ($message) : ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="title">Titre du quiz :</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit">Créer le quiz</button>
    </form>

    <a href="/view/admin/dashboard.php">Retour au dashboard</a>
</body>
</html>
