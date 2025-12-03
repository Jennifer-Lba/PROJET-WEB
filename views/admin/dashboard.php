<h1>Dashboard Admin</h1>

<h2>Utilisateurs</h2>
<table>
    <tr>
        <th>ID</th><th>Email</th><th>Role</th><th>Action</th>
    </tr>

    <?php foreach ($users as $u) : ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= $u['role'] ?></td>
        <td>
            <a href="/controllers/AdminController.php?action=deleteUser&id=<?= $u['id'] ?>"
               onclick="return confirm('Supprimer cet utilisateur ?')">
               Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Quiz</h2>
<table>
    <tr>
        <th>ID</th><th>Titre</th><th>Action</th>
    </tr>

    <?php foreach ($quizzes as $q) : ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= $q['title'] ?></td>
        <td>
            <a href="/controllers/AdminController.php?action=deleteQuiz&id=<?= $q['id'] ?>"
               onclick="return confirm('Supprimer ce quiz ?')">
               Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
