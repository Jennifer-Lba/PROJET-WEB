<?php
// Controllers/AnswerController.php : Cette page permet de gérer les actions liées aux réponses des utilisateurs aux quiz et aux résultats.
session_start();
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../config/config.php';

requireLogin();
$user = currentUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizId = post('quiz_id');
    $answers = $_POST['answers'] ?? [];

    if (!$quizId) die("Quiz introuvable.");

    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
    $stmt->execute([$quizId]);
    $quiz = $stmt->fetch();
    if (!$quiz || $quiz['status'] === 'disabled') die("Ce quiz est indisponible.");

    $totalScore = 0;

    foreach ($answers as $questionId => $answer) {
        $stmt = $conn->prepare("SELECT * FROM questions WHERE id=? AND quiz_id=?");
        $stmt->execute([$questionId, $quizId]);
        $question = $stmt->fetch();
        if (!$question) continue;

        $score = 0;

        if ($question['type'] === 'qcm') {
            $stmt = $conn->prepare("SELECT * FROM choices WHERE id=? AND question_id=? AND is_correct=1");
            $stmt->execute([$answer, $questionId]);
            $correct = $stmt->fetch();
            if ($correct) $score = $question['points'];
        }

        $totalScore += $score;

        $stmt = $conn->prepare("
            INSERT INTO answers_quiz (user_id, quiz_id, question_id, answer_text, score)
            VALUES (?, ?, ?, ?, ?)
        ");
        $answerText = is_array($answer) ? implode(',', $answer) : $answer;
        $stmt->execute([$user['id'], $quizId, $questionId, $answerText, $score]);
    }

    $stmt = $conn->prepare("SELECT * FROM results WHERE user_id=? AND quiz_id=?");
    $stmt->execute([$user['id'], $quizId]);
    $existingResult = $stmt->fetch();

    if ($existingResult) {
        $stmt = $conn->prepare("UPDATE results SET score=? WHERE id=?");
        $stmt->execute([$totalScore, $existingResult['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO results (user_id, quiz_id, score) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $quizId, $totalScore]);
    }

    redirect("/view/quiz/results.php?quiz_id=$quizId");
} else {
    die("Méthode non autorisée.");
}
