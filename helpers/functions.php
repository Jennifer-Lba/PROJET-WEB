<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function redirect($url)
{
    header("Location: $url");
    exit;
}

function sanitize($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}


function post($key)
{
    return isset($_POST[$key]) ? sanitize($_POST[$key]) : null;
}


function get($key)
{
    return isset($_GET[$key]) ? sanitize($_GET[$key]) : null;
}


function isLogged()
{
    return isset($_SESSION['user']);
}


function isAdmin()
{
    // Supporter deux variantes possibles du rôle administrateur
    return isLogged() && in_array($_SESSION['user']['role'], ['admin', 'administrateur'], true);
}

// Bloque l'accès si l'utilisateur n'est pas connecté
function requireLogin() {
    if (!isLogged()) {
        redirect('/views/auth/login.php');
    }
}

// Bloque l'accès selon le rôle
function requireRole($roles = []) {
    if (!isLogged() || !in_array($_SESSION['user']['role'], $roles)) {
        die("Accès refusé : vous n'etes pas autorisé à accèder à cette page.");
    }
}

// Récupère les informations de l'utilisateur connecté
function currentUser() {
    return $_SESSION['user'] ?? null;
}

// Génère un token CSRF
function generateCSRFToken() {
    // Toujours générer un nouveau token pour cette session
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Retourne un champ input caché avec le token CSRF
function csrfField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

// Vérifie le token CSRF
function verifyCSRFToken($token = null) {
    if ($token === null) {
        $token = trim($_POST['csrf_token'] ?? '');
    }

    $session_token = isset($_SESSION['csrf_token']) ? trim($_SESSION['csrf_token']) : '';

    if (empty($session_token) || empty($token) || $token !== $session_token) {
        die("Erreur de sécurité : token invalide.");
    }

    return true;
}
