<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль | Творческая мастерская</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-title {
            color: #ff0066;
            margin: 0;
        }
        
        .logout-btn {
            background: #ff0066;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #e6005c;
        }
        
        .profile-info {
            margin-bottom: 30px;
        }
        
        .profile-info p {
            margin: 15px 0;
            font-size: 18px;
        }
        
        .profile-info strong {
            color: #ff0066;
            min-width: 200px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <img src="images/logo.png" alt="Логотип" class="logo">
            <nav>
                <a href="index.html">Главная</a>
                <a href="courses.html">Курсы</a>
                <a href="services.html">Услуги</a>
                <a href="profile.php" class="active">Профиль</a>
                <a href="logout.php" class="logout-btn">Выйти</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="profile-container">
            <div class="profile-header">
                <h1 class="profile-title">Личный кабинет</h1>
            </div>
            
            <div class="profile-info">
                <p><strong>Имя пользователя:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Дата регистрации:</strong> <?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
    </main>
    
    <footer>
        <p>© 2025 GG. Все права защищены.</p>
    </footer>
</body>
</html>