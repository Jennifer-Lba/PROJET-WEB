<?php
//Zeinab

require_once __DIR__ . '/../config/config.php';

require_once __DIR__ . '/../models/users.php';

//gérer l'inscription
session_start();

class AuthController
{
    public function register()
    {
        global $pdo;

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: ../views/auth/register.php");
            exit;
        }

        if (
            empty($_POST['first_name']) ||
            empty($_POST['last_name']) ||
            empty($_POST['email']) ||
            empty($_POST['password']) ||
            empty($_POST['role'])
        ) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header("Location: ../views/auth/register.php");
            exit;
        }

        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role)
                               VALUES (?,?,?,?,?)");
        $stmt->execute([$first, $last, $email, $password, $role]);

        $_SESSION['success'] = "Inscription réussie ! Vous pouvez vous connecter.";
        header("Location: ../views/auth/login.php");
        exit;
    }

    //connexion
    public function login()
    {
        global $pdo;

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: ../views/auth/login.php");
            exit;
        }

        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header("Location: ../views/auth/login.php");
            exit;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Chercher l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header("Location: ../views/auth/login.php");
            exit;
        }

        // Connexion OK
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        header("Location: ../index.php");
        exit;
    }
    //deconnexion
    public function logout()
    {
        session_destroy();
        header("Location: ../views/auth/login.php");
        exit;
    }
}

$auth = new AuthController();

// router simple
if (isset($_GET['action'])) {
    if ($_GET['action'] === "register") $auth->register();
    if ($_GET['action'] === "login") $auth->login();
    if ($_GET['action'] === "logout") $auth->logout();
};
