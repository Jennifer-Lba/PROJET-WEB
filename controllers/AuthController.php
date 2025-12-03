<?php
require_once __DIR__ . '/../config/config.php';
session_start();

class AuthController
{
    // INSCRIPTION
    public function register()
    {
        global $pdo;

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: ../views/auth/register.php");
            exit;
        }

        // Vérifier champs
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

        // Vérifier si email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Cet email existe déjà. Connectez-vous.";
            header("Location: ../views/auth/login.php");
            exit;
        }

        // Inscrire l'utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role)
                               VALUES (?,?,?,?,?)");
        $stmt->execute([$first, $last, $email, $password, $role]);

        $_SESSION['success'] = "Inscription réussie ! Vous pouvez vous connecter.";
        header("Location: ../views/auth/login.php");
        exit;
    }

    // CONNEXION
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

        // Chercher utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header("Location: ../views/auth/login.php");
            exit;
        }

        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection selon le rôle
        switch ($user['role']) {
            case 'Admin':
                header("Location: ../views/admin/dashboard.php");
                break;
            case 'Ecole':
                header("Location: ../views/ecole/dashboard.php");
                break;
            case 'Entreprise':
                header("Location: ../views/entreprise/dashboard.php");
                break;
            default:
                header("Location: ../views/user/dashboard.php");
                break;
        }
        exit;
    }

    // DECONNEXION
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: ../views/auth/login.php");
        exit;
    }
}

// ROUTER SIMPLE
$auth = new AuthController();
$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === "register") $auth->register();
if ($action === "login") $auth->login();
if ($action === "logout") $auth->logout();
