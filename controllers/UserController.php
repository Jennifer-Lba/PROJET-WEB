<?php
// controllers/UserController.php
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../config/config.php';

requireLogin(); // accès réservé aux utilisateurs connectés

$user = currentUser();

// Traitement du formulaire POST pour mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = post('first_name');
    $lastName  = post('last_name');
    $email     = post('email');
    $password  = post('password');

    if ($firstName && $lastName && $email) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, password=? WHERE id=?");
            $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $user['id']]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
            $stmt->execute([$firstName, $lastName, $email, $user['id']]);
        }

        // Mettre à jour la session
        $_SESSION['user']['first_name'] = $firstName;
        $_SESSION['user']['last_name']  = $lastName;
        $_SESSION['user']['email']      = $email;

        $successMessage = "Profil mis à jour avec succès !";
    } else {
        $errorMessage = "Veuillez remplir tous les champs requis.";
    }

    // Redirection vers la page profil
    redirect('/view/user/profile.php');
} else {
    die("Méthode non autorisée.");
}
