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

    $sql = " SELECT b.id, b.date, b.time, s.sname, b.email, b.name, b.phone
    FROM book_appointments b
    JOIN services s ON b.service = s.service_id ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're my princess - Просмотр Записей</title>
    <link rel="stylesheet" href="view-appointments.css">
</head>
<body>
    <header>
        <nav class="header-left">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="service.php">Услуги</a></li>
                <li><a href="info.php">О нас</a></li>
            </ul>
        </nav>
        <h1 class="logo">You're My Princess</h1>
        <nav class="header-right">
            <ul>
                <li><a href="profile.php">Профиль</a></li>
                <li><a href="login.html">Выход</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Ваши Записи</h1>
        <div class="appointment-list">
            <ul>
                <?php foreach ($appointments as $appointment): ?>
                     <li>
                        <h3>Запись <?= htmlspecialchars($appointment['id']); ?></h3>
                        <p>Дата: <?= htmlspecialchars($appointment['date']); ?></p>
                        <p>Время: <?= htmlspecialchars($appointment['time']); ?></p>
                        <p>Услуга: <?= htmlspecialchars($appointment['sname']); ?></p>
                        <p>Имя: <?= htmlspecialchars($appointment['name']); ?></p>
                        <p>Электронная почта: <?= htmlspecialchars($appointment['email']); ?></p>
                        <p>Телефон: <?= htmlspecialchars($appointment['phone']); ?></p>
                        <p>Статус: Подтверждена</p> <!-- Вы можете изменить это поле в зависимости от статуса записи -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <footer>
        <p>© 2024 You're My Princess. Все права защищены.</p>
    </footer>
</body>
</html>
