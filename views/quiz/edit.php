<?php
require_once __DIR__ . '/../../controllers/QuizController.php';
require_once __DIR__ . '/../../helpers/functions.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    redirect('/view/auth/login.php');
}

$quizCtrl = new QuizController();
$message = '';

// Vérifie qu'on a bien l'ID du quiz
$id = get('id');
if (!$id) {
    redirect('/view/admin/dashboard.php');
}

$quiz = $quizCtrl->getById((int)$id);
if (!$quiz) {
    redirect('/view/admin/dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = post('title');
    $description = post('description');

    if ($title && $description) {
        if ($quizCtrl->update((int)$id, $title, $description)) {
            $message = "Quiz modifié avec succès !";
            $quiz = $quizCtrl->getById((int)$id);
        } else {
            $message = "Erreur lors de la modification du quiz.";
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
    <title>Modifier le quiz</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <h1>Modifier le quiz</h1>

    <?php if ($message) : ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="title">Titre du quiz :</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($quiz['title']) ?>" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($quiz['description']) ?></textarea>

        <button type="submit">Modifier le quiz</button>
    </form>

    <a href="/view/admin/dashboard.php">Retour au dashboard</a>
</body>

</html>
