USE grocery_store;

CREATE TABLE ProductTable (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Quantity INT,
    Price DECIMAL(10, 2) NOT NULL,
    Image VARCHAR(255),
    Description TEXT
);

INSERT INTO ProductTable (Name, Quantity, Price, Image, Description)
VALUES 
("Dutch Lady Milk", 25, 8.00, '/ProductImage/Dutch_Lady_Milk.png', "DutchLady Milk Description"),
("Cadbury Dairy Milk Chocolate", 25, 6.00, '/ProductImage/Cadbury_Dairy_Chocolate_Milk.png', "The Best Chocolate Ever"),
("Buttercup Unsalted Luxury Spread", 25, 3.00, '/ProductImage/Buttercup_Unsalted_Luxury_Spread.png', "Unsalted Butter"),
("Massimo Sandwich Loaf", 25, 6.25, '/ProductImage/Massimo_Sandwich_Loaf.png', "Massimo Sandwich Loaf"),
("Ferrero Nutella", 25, 18.25, '/ProductImage/Ferrero_Nutella.png', "Ferrero Nutella"),
("Julies Peanut Butter", 25, 8.50, '/ProductImage/Julies_PeanutButter.png', "Peanut butter"),
("Lays Potato Chips", 25, 6.25, '/ProductImage/Lays_PotatoChips.png', "Lays PotatoChips"),
("Coco Cola 1.5L", 25, 5.00, '/ProductImg/Coco_Cola_1.5L.png', "Coco Cola 1.5L");























