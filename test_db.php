<?php
// Test de connexion à la base de données

$host = "localhost";
$db_name = "quizzeo_db";
$username = "root";
$password = "";

echo "Test de connexion à MySQL...\n";
echo "Host: $host\n";
echo "Database: $db_name\n";
echo "Username: $username\n\n";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie !\n";

    // Test si la table users existe
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->rowCount() > 0) {
        echo "✅ Table 'users' existe\n";
    } else {
        echo "❌ Table 'users' n'existe pas\n";
    }

} catch (PDOException $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "\n";
}
?>
