<?php
$host = "localhost";
$db = "mindwell";
$user = "postgres";
$password = '1234' ;

try {
    $pdo = new PDO("pgsql:host=$host;port='5434';dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>