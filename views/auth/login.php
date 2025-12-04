<!DOCTYPE html>
<html lang="en">
<!-- //Zeinab -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
</head>

<body>
    <h1>SE CONNECTER</h1>
    <!-- //Afficher les erreurs -->
    <?php if (!empty($_SESSION['error'])): ?>
        <p style="color:red;"><?= $_SESSION['error']; ?></p>
        <?php $_SESSION['error'] = ""; ?>
    <?php endif; ?>

    <!-- //Afficher les succes -->
    <?php if (!empty($_SESSION['success'])): ?>
        <p style="color:green;"><?= $_SESSION['success']; ?></p>
        <?php $_SESSION['success'] = ""; ?>
    <?php endif; ?>

    <p>Vous avez déjà un compte connectez-vous!</p>

    <form action="../../controllers/AuthController.php?action=login" method="POST">
        <!--
        //sert a indiquer au controleur que l'action a traiter est login. -->
        <input type="hidden" name="action" value="login">

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <br>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <button type="submit"> Se Connecter</button>
    </form>

    <p>Vous n'avez pas encore de compte ? </p>
    <a href="register.php">Créer un compte </a>
</body>

</html>
