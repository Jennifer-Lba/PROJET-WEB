<?php
require_once "../../config/config.php";
// // pour utiliser la variable définie dans config.php
global $pdo;

?>
<?php
if (!empty($_SESSION['error'])): ?>
    <p style="color:red;"><?= $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green;"><?= $_SESSION['success']; ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
</head>

<body>
    <h1>SE CONNECTER</h1>

    <p>Vous avez déjà un compte connectez-vous!</p>
    <!-- Affichage des erreurs -->
    <?php if (!empty($_SESSION['error'])): ?>
        <p style="color:red;"><?= $_SESSION['error']; ?></p>
        <?php $_SESSION['error'] = ""; ?>
    <?php endif; ?>

    <form action="../../controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="login">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <br><br>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p>Vous n'avez pas encore de compte ? </p>
    <a href="register.php">Créer un compte </a>
</body>

</html>
