<!DOCTYPE html>
<html lang="en">
<!-- //Zeinab -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h1>INSCRIPTION</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>

    <form action="../../controllers/AuthController.php" method="POST">
        <!--
        //permet denvoyer linfo au controleur donc le controller saura quoi faire -->
        <input type="hidden" name="action" value="register">
        <div>
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" id="first_name">
            <br>
        </div>

        <div>
            <br>
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" id="last_name">
        </div>
        <div>
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <br>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <br>
            <label for="role">Sélectionner votre Rôle</label>
            <select name="role" id="role" required>
                <option value="Admin">Admin</option>
                <option value="Ecole">Ecole</option>
                <option value="Entreprise">Entreprise</option>
                <option value="Simple Utilisateur">Simple Utilisateur</option>
            </select>
        </div>
        <p>Vous avez déjà un compte ? </p>
        <a href="login.php">Se connecter </a> <br>
        <br>
        <button type="submit"> S'inscrire </button>

    </form>
</body>

</html>
