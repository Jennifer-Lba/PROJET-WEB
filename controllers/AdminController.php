<?php
session_start();

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Quiz.php';

class AdminController
{
    private static function requireAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            redirect('/view/auth/login.php');
            exit;
        }
    }

    public static function dashboard()
    {
        self::requireAdmin();

        $users = User::getAll(); 
        $quizzes = Quiz::getAll();

        include __DIR__ . '/../view/admin/dashboard.php';
    }

    public static function deleteUser($id)
    {
        self::requireAdmin();
        User::delete($id);
        redirect('/view/admin/dashboard.php');
    }

    public static function deleteQuiz($id)
    {
        self::requireAdmin();
        Quiz::delete($id);
        redirect('/view/admin/dashboard.php');
    }
}

if (isset($_GET['action'])) {
    session_start();

    require_once __DIR__ . '/../model/User.php';
    require_once __DIR__ . '/../model/Quiz.php';
    require_once __DIR__ . '/../helpers/functions.php';

    $action = $_GET['action'];

    if ($action === 'deleteUser' && isset($_GET['id'])) {
        AdminController::deleteUser($_GET['id']);
    }

    if ($action === 'deleteQuiz' && isset($_GET['id'])) {
        AdminController::deleteQuiz($_GET['id']);
    }
}
