-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE StockOrderHistory (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    OrderDate DATE NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID)
);



DROP TABLE StockOrderHistory;
DELETE FROM StockOrderHistory;

ALTER TABLE StockOrderHistory ADD CONSTRAINT unique_product_date UNIQUE (ProductID, OrderDate);




INSERT INTO StockOrderHistory (ProductID, Quantity, OrderDate)VALUES (40, 10, '2024-11-08')ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity);
INSERT INTO StockOrderHistory (ProductID, Quantity, OrderDate)VALUES (41, 6, '2024-11-08')ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity);

INSERT INTO StockOrderHistory (ProductID, Quantity, OrderDate)VALUES (43, 13, '2024-11-08')ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity);




















