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
    return isLogged() && $_SESSION['user']['role'] === 'admin';
}

// Bloque l'accès si l'utilisateur n'est pas connecté
function requireLogin() {
    if (!isLogged()) {
        redirect('/auth/login.php');
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
