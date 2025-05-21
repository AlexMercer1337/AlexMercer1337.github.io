<?php
session_start(); 
if (!isset($_SESSION['email'])) { 
    header('Location: login.html'); 
    exit(); 
}
$host = 'localhost';
$db = 'salon_beauty';
$user = 'postgres';
$password = '12345';
$dsn = "pgsql:host=$host;dbname=$db";

try { 
    $pdo = new PDO($dsn, $user, $password); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
    $email = $_SESSION['email']; 
    $sql = "SELECT name, phone, role FROM users WHERE email = :email"; 
    $stmt = $pdo->prepare($sql); 
    $stmt->execute(['email' => $email]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    
    if (!$user) { // Данные не найдены 
        echo "Ошибка: пользователь не найден."; 
        exit(); 
    }

    $name = htmlspecialchars($user['name']); 
    $phone = htmlspecialchars($user['phone']); 
    $role = htmlspecialchars($user['role']);

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
    <title>You're my princess - Профиль</title>
    <link rel="stylesheet" href="profile.css">
    <style>
        .details p {
            text-decoration: none;
        }
    </style>
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
                <?php if ($role == 'Администратор'): ?>
                    <li><a href="admin-dashboard.html">Админ панель</a></li>
                <?php endif; ?>
                <li><a href="view-appointments.php">Мои записи</a></li>
                <li><a href="login.html">Выход</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Ваш Профиль</h1>
        <div class="profile-details">
            <img src="empty.jpg" alt="Profile Picture" class="profile-pic">
            <div class="details">
                <h2><?php echo $name; ?></h2>
                <h2><?php echo $role; ?></h2>
                <p>Электронная почта: <?php echo htmlspecialchars($email); ?></p>
                <p>Телефон: <?php echo $phone; ?></p>
            </div>
        </div>
        <button onclick="window.location.href='#'">Редактировать Профиль</button>
    </div>
    <footer>
        <p>© 2024 You're My Princess. Все права защищены.</p>
    </footer>
</body>
</html>