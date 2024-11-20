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

INSERT INTO StockOrderHistory (ProductID, Quantity, OrderDate)
VALUES
(1, 50, '2024-01-01'),
(2, 30, '2024-01-02'),
(3, 20, '2024-01-03'),
(4, 40, '2024-01-04'),
(5, 25, '2024-01-05'),
(6, 35, '2024-01-06'),
(7, 15, '2024-01-07'),
(8, 60, '2024-01-08'),
(9, 45, '2024-01-09'),
(10, 70, '2024-01-10'),
(11, 55, '2024-01-11'),
(12, 65, '2024-01-12'),
(13, 40, '2024-01-13'),
(14, 50, '2024-01-14'),
(15, 30, '2024-01-15'),
(16, 25, '2024-01-16'),
(17, 45, '2024-01-17'),
(18, 55, '2024-01-18'),
(19, 60, '2024-01-19'),
(20, 30, '2024-01-20'),
(21, 35, '2024-01-21'),
(22, 40, '2024-01-22'),
(23, 50, '2024-01-23'),
(24, 20, '2024-01-24'),
(25, 60, '2024-01-25'),
(26, 45, '2024-01-26'),
(27, 70, '2024-01-27'),
(28, 30, '2024-01-28'),
(29, 55, '2024-01-29'),
(30, 40, '2024-01-30'),
(31, 65, '2024-01-31'),
(32, 35, '2024-02-01'),
(33, 50, '2024-02-02'),
(34, 45, '2024-02-03'),
(35, 60, '2024-02-04'),
(36, 50, '2024-02-05'),
(37, 30, '2024-02-06'),
(38, 70, '2024-02-07');



















