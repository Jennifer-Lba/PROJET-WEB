<?php
require_once __DIR__ . '/../config/config.php';

class User
{
    private static function getConnection(): PDO
    {
        global $conn;
        return $conn;
    }

    public static function getAll(): array
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $stmt = self::getConnection()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
