<?php
session_start();
$host = 'localhost';
$db = 'salon_beauty';
$user = 'postgres';
$password = '12345';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хэширование пароля

    $sql = "INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password]);

    header('Location: login.html'); 
    exit();
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
