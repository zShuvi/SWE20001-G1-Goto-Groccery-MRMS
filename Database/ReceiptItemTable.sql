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

-- Insert sample data into ReceiptItem
INSERT INTO ReceiptItemTable (ReceiptItemID, ReceiptID, ProductID, ProductPrice, Quantity)
VALUES
    (1, 1, 1001, 50.00, 2),
    (2, 1, 1002, 25.00, 2),
    (3, 2, 1003, 125.00, 1),
    (4, 2, 1004, 125.00, 1);

DROP TABLE ReceiptItemTable;
DELETE FROM ReceiptItemTable;























