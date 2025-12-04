<?php
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../config/config.php';
 
session_start();
 
// Afficher les erreurs (évite la page blanche)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// Sécurité
requireLogin();
requireRole(['Admin']); // ton rôle exact en base
 
$user = currentUser();
 
// Utiliser $pdo 
$stmt = $pdo->query("SELECT id, first_name, last_name, email, role, is_active FROM users");
$users = $stmt->fetchAll();
 
// Tous les quizzes
$stmt = $pdo->query("
    SELECT q.id, q.title, q.status, u.first_name, u.last_name
    FROM quizzes q
    JOIN users u ON q.creator_id = u.id
");
$quizzes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrateur</title>
</head>
<body>
 
<h1>Bonjour <?= htmlspecialchars($user['first_name']) ?>, Dashboard Admin</h1>
 
<h2>Liste des utilisateurs</h2>
<table>
<thead>
<tr>
<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Rôle</th>
<th>Actif</th>
</tr>
</thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
<td><?= htmlspecialchars($u['last_name']) ?></td>
<td><?= htmlspecialchars($u['first_name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= htmlspecialchars($u['role']) ?></td>
<td><?= $u['is_active'] ? "Oui" : "Non" ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
 
<h2>Liste des quiz</h2>
<table>
<thead>
<tr>
<th>Titre</th>
<th>Créateur</th>
<th>Statut</th>
</tr>
</thead>
<tbody>
<?php foreach ($quizzes as $q): ?>
<tr>
<td><?= htmlspecialchars($q['title']) ?></td>
<td><?= htmlspecialchars($q['first_name'] . ' ' . $q['last_name']) ?></td>
<td><?= htmlspecialchars($q['status']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
 
<a href="/controllers/AuthController.php?action=logout">Se déconnecter</a>
 
</body>
</html>