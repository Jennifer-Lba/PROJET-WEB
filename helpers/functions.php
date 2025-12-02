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
