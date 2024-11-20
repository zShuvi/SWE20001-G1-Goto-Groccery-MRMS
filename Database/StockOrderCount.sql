-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE StockOrderHistory (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    OrderDate DATE NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID),
    CONSTRAINT unique_product_date UNIQUE (ProductID, OrderDate)
);


DROP TABLE StockOrderHistory;
DELETE FROM StockOrderHistory;



















