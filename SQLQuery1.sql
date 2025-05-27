-- ������� ���� ������
CREATE DATABASE creative_workshop;
GO

-- ���������� ����� ���� ������
USE creative_workshop;
GO

-- ������� ������� �������������
CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY, -- ���������������� ����
    username NVARCHAR(50) NOT NULL UNIQUE,
    email NVARCHAR(100) NOT NULL UNIQUE,
    password NVARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO