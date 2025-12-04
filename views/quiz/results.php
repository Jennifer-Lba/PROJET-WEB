<?php
// view/quiz/results.php
//cette page affiche les résultats de un quiz spécifique.
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../config/config.php';
requireLogin(); //  accès uniquement aux utilisateurs connectés

$quizId = get('quiz_id');
if (!$quizId) die("Quiz introuvable.");
// Vérifier que le quiz existe et est actif
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch();
if (!$quiz) die("Quiz introuvable.");


// Vérifier que l'utilisateur est le créateur ou admin
$user = currentUser();
if ($quiz['creator_id'] != $user['id'] && !isAdmin()) {
    die("Accès refusé.");
}
// Pour récupérer les résultats pour ce quiz
$stmt = $conn->prepare("
    SELECT r.*, u.first_name, u.last_name
    FROM results r
    JOIN users u ON u.id = r.user_id
    WHERE r.quiz_id = ?
    ORDER BY r.score DESC
");
$stmt->execute([$quizId]);
$results = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats du quiz</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Résultats du quiz</h1>

    <?php if (empty($results)): ?>
        <p>Aucun résultat pour ce quiz.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['last_name']) ?></td>
                        <td><?= htmlspecialchars($r['first_name']) ?></td>
                        <td><?= htmlspecialchars($r['score']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="/index.php">Retour à l’accueil</a>
</body>
</html>
