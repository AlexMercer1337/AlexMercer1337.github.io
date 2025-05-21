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

    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO book_appointments (service, date, time, name, email, phone) VALUES (:service, :date, :time, :name, :email, :phone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'service' => $service,
        'date' => $date,
        'time' => $time,
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ]);

    header('Location: payment.html');
    exit();
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
