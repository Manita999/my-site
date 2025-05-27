<?php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Все поля обязательны для заполнения!";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают!";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен содержать минимум 6 символов!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Пользователь с таким именем или email уже существует!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            
            header("Location: login.php?registration=success");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | Творческая мастерская</title>
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
                <a href="login.php">Вход</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="auth-container">
            <h1 class="auth-title">Регистрация</h1>
            
            <?php if ($error): ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="auth-form" method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Подтвердите пароль</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit">Зарегистрироваться</button>
            </form>
            
            <div class="auth-footer">
                Уже есть аккаунт? <a href="login.php">Войдите</a>
            </div>
        </div>
    </main>
    
    <footer>
        <p>© 2025 GG. Все права защищены.</p>
    </footer>
</body>
</html>