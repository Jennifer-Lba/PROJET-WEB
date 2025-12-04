<?php
$host = "localhost";
<<<<<<< HEAD
$db_name = "quizzeo";
=======
$db_name = "quizzeo_db";
>>>>>>> 9cffc80c4e55a780bfee1a7178c5fe58868c1964
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
