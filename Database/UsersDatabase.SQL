-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE UsersTable (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Role VARCHAR(50) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Gender VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL, 
    Password VARCHAR(255) NOT NULL, 
    PhoneNumber  VARCHAR(50) NOT NULL, 
    DateOfBirth DATE NOT NULL,
    Points INT,
    ProfileImagePath VARCHAR(255) DEFAULT 'images/Profile_Placeholder.png' -- New column with default value
);

DROP TABLE UsersTable;

INSERT INTO UsersTable (Role, Username, Gender, Email, Password, PhoneNumber, DateOfBirth, Points)
VALUES 
('Member', 'Steve Jobs', 'M', 'SteveJobs@gmail.com', 'NoAndroidOnlyApple', '011-111-1111', '1995-02-24', 1000),
('Staff', 'StaffTest1', 'M', 'StaffTest@gmail.com', 'Password1', '011-794-1874', '2003-02-24', 1000),
('JuniorAdmin', 'JuniorAdminTest', 'M', 'JuniorAdmin@gmail.com', 'Password123', '016-999-1994', '2000-02-24', 1000),
('SeniorAdmin', 'SeniorAdminTest', 'M', 'SeniorAdminTest@gmail.com', '321password123', '012-144-3214', '2000-02-24', 1000),
('Member', 'AliceWonder', 'F', 'alice.wonder@gmail.com', 'WonderPassword', '012-345-6789', '1992-06-15', 1500),
('Staff', 'JohnDoe01', 'M', 'john.doe01@gmail.com', 'jdpassword01', '019-234-5678', '1990-08-12', 1200),
('JuniorAdmin', 'MarkSmith', 'M', 'mark.smith@gmail.com', 'smith1234', '017-876-5432', '1995-05-30', 800),
('SeniorAdmin', 'EmmaStone', 'F', 'emma.stone@gmail.com', 'passwordEmma', '016-112-2334', '1988-02-28', 2000),
('Member', 'LucasBrown', 'M', 'lucas.brown@gmail.com', 'brown123', '013-567-8901', '1996-04-19', 1100),
('Staff', 'SophiaJones', 'F', 'sophia.jones@gmail.com', 'passwordSophia', '015-654-3210', '2001-01-07', 950),
('JuniorAdmin', 'TomMiller', 'M', 'tom.miller@gmail.com', 'tom12345', '017-233-3445', '1997-09-12', 1000),
('SeniorAdmin', 'OliviaClark', 'F', 'olivia.clark@gmail.com', 'clark123', '018-567-8903', '1985-03-22', 2200),
('Member', 'LiamTaylor', 'M', 'liam.taylor@gmail.com', 'passwordLiam', '016-789-1230', '1993-11-10', 1250),
('Staff', 'CharlotteDavis', 'F', 'charlotte.davis@gmail.com', 'password1234', '017-245-6789', '2002-06-30', 950),
('JuniorAdmin', 'JamesWilson', 'M', 'james.wilson@gmail.com', 'jamespass123', '019-432-5678', '1994-12-18', 950),
('SeniorAdmin', 'IsabellaMoore', 'F', 'isabella.moore@gmail.com', 'isabella123', '013-876-5431', '1987-07-24', 2500),
('Member', 'EthanAnderson', 'M', 'ethan.anderson@gmail.com', 'ethan1234', '017-987-6540', '1998-09-05', 1050),
('Staff', 'MiaThomas', 'F', 'mia.thomas@gmail.com', 'miapassword', '018-765-4321', '1999-03-10', 1150),
('JuniorAdmin', 'AidenMartinez', 'M', 'aiden.martinez@gmail.com', 'aiden123', '016-234-5671', '2000-07-25', 900),
('SeniorAdmin', 'HarperJackson', 'F', 'harper.jackson@gmail.com', 'jackson321', '014-987-6542', '1986-11-05', 2700),
('Member', 'GraceHarris', 'F', 'grace.harris@gmail.com', 'gracepassword', '016-345-6789', '1992-08-18', 1300);


UPDATE UsersTable 
SET Points = 6000 
WHERE Username = 'SeniorAdminTest';