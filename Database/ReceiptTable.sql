-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

-- Create the Receipt table
CREATE TABLE ReceiptTable (
    ReceiptID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Date DATE NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    voucherID INT,
    FOREIGN KEY (voucherID) REFERENCES VouchersTable(voucherID)
);

DROP TABLE ReceiptTable ;
DELETE FROM ReceiptTable ;























