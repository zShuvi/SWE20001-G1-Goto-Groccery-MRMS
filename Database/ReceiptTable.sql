-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

-- Create the Receipt table
CREATE TABLE ReceiptTable (
    ReceiptID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Date DATE NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL
);


-- Insert sample data into Receipt
INSERT INTO Receipt (ReceiptID, UserID, Date, TotalPrice)
VALUES 
    (1, 101, '2024-10-30', 150.00),
    (2, 102, '2024-10-29', 250.00);

DROP TABLE ReceiptTable ;
DELETE FROM ReceiptTable ;























