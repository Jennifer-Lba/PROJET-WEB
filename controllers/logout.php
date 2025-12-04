<?php
require_once __DIR__ . '/../helpers/functions.php';

// Déconnecter l'utilisateur
session_unset();
session_destroy();

// Rediriger vers l'accueil
header("Location: /index.php");
exit;
?>
