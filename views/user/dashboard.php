<?php
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../config/config.php';

requireLogin();

$user = currentUser();

// Récupérer les quiz disponibles pour l'utilisateur (actifs)
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE status = 'active'");
$stmt->execute();
$quizzes = $stmt->fetchAll();

// Récupérer les quiz auxquels l'utilisateur a déjà répondu
$stmt = $conn->prepare("SELECT quiz_id FROM results WHERE user_id = ?");
$stmt->execute([$user['id']]);
$answered = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bonjour <?= htmlspecialchars($user['first_name']) ?>, Dashboard Utilisateur</h1>

    <h2>Quiz disponibles</h2>
    <ul>
        <?php foreach ($quizzes as $q): ?>
            <li>
                <?= htmlspecialchars($q['title']) ?>
                <?php if (in_array($q['id'], $answered)): ?>
                    - Déjà répondu
                <?php else: ?>
                    - <a href="/view/quiz/answer.php?quiz_id=<?= $q['id'] ?>">Répondre</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="/controllers/AuthController.php?action=logout">Se déconnecter</a>
</body>
</html>
