-- Active: 1728464706565@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE UsersTable (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Role VARCHAR(50) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL, 
    Password VARCHAR(255) NOT NULL,
    DateOfBirth DATE NOT NULL
);

INSERT INTO UsersTable (Role, Username, Email, Password,DateOfBirth)
VALUES 
('Member', 'Steve Jobs', 'SteveJobs@gmail.com', 'NoAndroidOnlyApple', '1995-02-24'),
('Staff', 'StaffTest1', 'StaffTest@gmail.com', 'Password1', '2003-02-24'),
('JuniorAdmin', 'JuniorAdminTest', 'JuniorAdmin@gmail.com', 'Password123', '2000-02-24'),
('SeniorAdmin', 'SeniorAdminTest', 'SeniorAdminTest@gmail.com', '321password123', '2000-02-24');