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

    private static function sanitizeId($id)
    {
        // Vérifie que c’est un entier strictement
        return filter_var($id, FILTER_VALIDATE_INT);
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

        $id = self::sanitizeId($id);
        if (!$id) {
            redirect('/view/admin/dashboard.php?error=invalid_id');
            exit;
        }

        User::delete($id);
        redirect('/view/admin/dashboard.php?success=user_deleted');
        exit;
    }

    public static function deleteQuiz($id)
    {
        self::requireAdmin();

        $id = self::sanitizeId($id);
        if (!$id) {
            redirect('/view/admin/dashboard.php?error=invalid_id');
            exit;
        }

        Quiz::delete($id);
        redirect('/view/admin/dashboard.php?success=quiz_deleted');
        exit;
    }
}


// ---------------------------
//   ROUTER SÉCURISÉ
// ---------------------------

if (isset($_GET['action'])) {

    // Sécurise l'action
    $action = sanitize($_GET['action']);

    // Liste blanche (actions autorisées)
    $allowedActions = ['deleteUser', 'deleteQuiz'];

    if (!in_array($action, $allowedActions)) {
        redirect('/view/admin/dashboard.php?error=invalid_action');
        exit;
    }

    // Vérifie que l’ID existe
    if (!isset($_GET['id'])) {
        redirect('/view/admin/dashboard.php?error=missing_id');
        exit;
    }

    $id = $_GET['id'];

    if ($action === 'deleteUser') {
        AdminController::deleteUser($id);
    }

    if ($action === 'deleteQuiz') {
        AdminController::deleteQuiz($id);
    }
}
