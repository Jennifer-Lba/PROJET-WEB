<?php
require_once __DIR__ . '/../config/config.php';

class Question
{
    private static function getConnection(): PDO
    {
        global $conn;
        return $conn;
    }

    public static function getAllByQuiz(int $quiz_id): array
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $quiz_id, string $question, string $a, string $b, string $c, string $d, string $correct): bool
    {
        $stmt = self::getConnection()->prepare("
            INSERT INTO questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_option)
            VALUES (:quiz_id, :question, :a, :b, :c, :d, :correct)
        ");
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':a', $a);
        $stmt->bindParam(':b', $b);
        $stmt->bindParam(':c', $c);
        $stmt->bindParam(':d', $d);
        $stmt->bindParam(':correct', $correct);
        return $stmt->execute();
    }

    public static function delete(int $id): bool
    {
        $stmt = self::getConnection()->prepare("DELETE FROM questions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
