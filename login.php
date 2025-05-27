<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: profile.php");
        exit();
    } else {
        $error = "Неверное имя пользователя или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | GG </title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .auth-title {
            color: #ff0066;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-form .form-group {
            margin-bottom: 20px;
        }
        
        .auth-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .auth-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        
        .auth-form button {
            width: 100%;
            padding: 12px;
            background: #ff66b2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .auth-form button:hover {
            background: #ff3385;
        }
        
        .auth-error {
            color: #ff0000;
            margin-bottom: 20px;
            padding: 10px;
            background: #ffeeee;
            border-radius: 4px;
            text-align: center;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 20px;
        }
        
        .auth-footer a {
            color: #ff0066;
            text-decoration: none;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
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
                <a href="login.php" class="active">Вход</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="auth-container">
            <h1 class="auth-title">Вход в личный кабинет</h1>
            
            <?php if ($error): ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="auth-form" method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit">Войти</button>
            </form>
            
            <div class="auth-footer">
                Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a>
            </div>
        </div>
    </main>
    
    <footer>
        <p>© 2025 GG. Все права защищены.</p>
    </footer>
</body>
</html>