-- Active: 1728464706565@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE UsersTable (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Role VARCHAR(50) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Gender VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL, 
    Password VARCHAR(255) NOT NULL, 
    PhoneNumber  VARCHAR(50) NOT NULL, 
    DateOfBirth DATE NOT NULL
);

INSERT INTO UsersTable (Role, Username, Gender , Email, Password , PhoneNumber ,DateOfBirth)
VALUES 
('Member', 'Steve Jobs','M' , 'SteveJobs@gmail.com', 'NoAndroidOnlyApple','011-111-1111' ,  '1995-02-24'),
('Staff', 'StaffTest1', 'M' , 'StaffTest@gmail.com', 'Password1', '011-794-1874','2003-02-24'),
('JuniorAdmin', 'JuniorAdminTest', 'M' , 'JuniorAdmin@gmail.com', 'Password123', '016-999-1994',  '2000-02-24'),
('SeniorAdmin', 'SeniorAdminTest', 'M' , 'SeniorAdminTest@gmail.com', '321password123','012-144-3214', '2000-02-24');