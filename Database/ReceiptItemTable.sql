-- Active: 1728990721892@@127.0.0.1@3306
USE grocery_store;

-- Create the ReceiptItem table
CREATE TABLE ReceiptItemTable (
    ReceiptItemID INT AUTO_INCREMENT PRIMARY KEY,
    ReceiptID INT,
    ProductID INT NOT NULL,
    ProductPrice DECIMAL(10, 2) NOT NULL,
    Quantity INT NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID),
    FOREIGN KEY (ReceiptID) REFERENCES ReceiptTable(ReceiptID)
);


DROP TABLE ReceiptItemTable;
DELETE FROM ReceiptItemTable;























