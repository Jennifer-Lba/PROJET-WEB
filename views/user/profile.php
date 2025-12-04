<?php
// profile.php : Page de profil utilisateur
//Cette page permet aux utilisateurs de voir et de modifier leurs informations(nom,prenom,email,mot de passe).
session_start();
require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../config/config.php';

requireLogin();
$user = currentUser();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

   <h1>Mon profil</h1>
<form method="POST" action="/controllers/UserController.php">
    <div>
      <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
       <label>Prénom</label>
    </div>

      <div>
    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
    <label>Nom</label>
      </div>

        <div>
    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
    <label>Email</label>
     </div>

      <div>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
    <label>Mot de passe</label>
    </div>

      <div>
    <input type="password" name="password" placeholder="Nouveau mot de passe">
    <button type="submit">Modifier</button>
    </div>
</form>
</body>
</html>

