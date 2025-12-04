<?php
<<<<<<< HEAD
header("Location: /view/auth/login.php");
exit;
=======
// Point d'entrée principal de l'application

// Démarrer la session si nécessaire
session_start();

// Inclure les fichiers de configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Routage simple basé sur les paramètres GET
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];

    // Liste des contrôleurs autorisés
    $allowedControllers = ['Auth', 'Admin', 'Quiz', 'User', 'Answer'];

    if (in_array($controller, $allowedControllers)) {
        $controllerFile = 'controllers/' . $controller . 'Controller.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Appeler la fonction action si elle existe
            if (function_exists($action)) {
                $action();
            } else {
                // Action non trouvée
                header("Location: views/auth/login.php");
                exit;
            }
        } else {
            // Contrôleur non trouvé
            header("Location: views/auth/login.php");
            exit;
        }
    } else {
        // Contrôleur non autorisé
        header("Location: views/auth/login.php");
        exit;
    }
} else {
    // Pas de paramètres, rediriger vers la page de connexion
    header("Location: views/auth/login.php");
    exit;
}
>>>>>>> cc2515b795b7de7df4aaf3f25c2c87f0929fb557
