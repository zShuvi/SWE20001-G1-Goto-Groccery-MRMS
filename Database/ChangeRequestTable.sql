-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;

CREATE TABLE ChangeRequestTable (
    RequestID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT NOT NULL,
    Username VARCHAR(255) NOT NULL,
    OriginalQuantity INT NOT NULL,
    NewQuantity INT NOT NULL,
    RequestStatus VARCHAR(20) NOT NULL DEFAULT 'Pending',  -- e.g., 'Pending', 'Approved', 'Rejected'
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID)
);


DROP TABLE ChangeRequestTable;
DELETE FROM ChangeRequestTable;























