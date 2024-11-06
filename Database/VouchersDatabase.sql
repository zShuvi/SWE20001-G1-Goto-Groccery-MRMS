-- Active: 1728464706565@@127.0.0.1@3306@grocery_store
USE grocery_store;
CREATE TABLE VouchersTable (
    VoucherID INT AUTO_INCREMENT PRIMARY KEY,
    VoucherName VARCHAR(255) NOT NULL,
    DiscountPercentage INT NOT NULL,
    ExpiryDate DATE NOT NULL,
    IsClaimed BOOLEAN DEFAULT 0,  -- 0 for available, 1 for owned
    ReqPoints INT,
    Code VARCHAR(12) NOT NULL
);

DROP Table voucherstable

INSERT INTO VouchersTable (VoucherName, DiscountPercentage, ExpiryDate, IsClaimed, ReqPoints, Code)
VALUES 
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('20% Off', 20, '2024-12-31', 0, 200, "123456"),
('30% Off', 30, '2024-12-31', 1, 300, "111111"),
('30% Off', 30, '2024-12-31', 0, 300, "111111"),
('Free Shit WOOO', 100, '2024-12-31', 0, 696969, "6969696969")

INSERT INTO VouchersTable (VoucherName, DiscountPercentage, ExpiryDate, IsClaimed, ReqPoints, Code)
VALUES 
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321"),
('10% Off', 10, '2024-12-31', 0, 100, "123321")