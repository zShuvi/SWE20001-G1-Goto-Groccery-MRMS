-- Active: 1728990721892@@127.0.0.1@3306@grocery_store
USE grocery_store;
CREATE TABLE VoucherOwn (
    VoucherOwnID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Voucher_ID INT NOT NULL,
    Used BOOLEAN DEFAULT 0,  -- 1 for used,0 for not used
    VoucherCode VARCHAR(12) NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES UsersTable(ID),
    FOREIGN KEY (Voucher_ID) REFERENCES VouchersTable(VoucherID)
);

DROP Table VoucherOwn
