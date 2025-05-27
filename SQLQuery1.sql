-- Создаем базу данных
CREATE DATABASE creative_workshop;
GO

-- Используем новую базу данных
USE creative_workshop;
GO

-- Создаем таблицу пользователей
CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY, -- Автоинкрементное поле
    username NVARCHAR(50) NOT NULL UNIQUE,
    email NVARCHAR(100) NOT NULL UNIQUE,
    password NVARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO