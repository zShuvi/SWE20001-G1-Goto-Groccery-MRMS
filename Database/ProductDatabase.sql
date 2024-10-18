USE grocery_store;

CREATE TABLE ProductTable (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Category VARCHAR(255) NOT NULL,
    Quantity INT,
    Price DECIMAL(10, 2) NOT NULL,
    Image VARCHAR(255),
    Description TEXT
);

DROP TABLE ProductTable;
DELETE FROM ProductTable;

INSERT INTO ProductTable (Name, Category, Quantity, Price, Image, Description)
VALUES 
('Australian Carrot', 'Vegetable', 20, 4.00, '/ProductImage/Australian_Carrot.png', 'Fresh Australian carrots for a healthy snack.'),
('Ayataka Green Tea', 'Beverage', 20, 5.00, '/ProductImage/Ayataka_Green_Tea.png', 'Refreshing Ayataka green tea, perfect for any time.'),
('Broccoli', 'Vegetable', 20, 4.30, '/ProductImage/Broccoli.png', 'Crisp and fresh broccoli, great for salads or cooking.'),
('Brown Sugar', 'PantryStaple', 20, 5.50, '/ProductImage/BrownSugar.png', 'Rich and sweet brown sugar for your baking needs.'),
('Buttercup Unsalted Luxury Spread', 'Dairy', 20, 7.00, '/ProductImage/Buttercup_Unsalted_Luxury_Spread.png', 'Unsalted luxury butter spread, ideal for baking.'),
('Cadbury Dairy Chocolate Milk', 'Snacks', 20, 3.70, '/ProductImage/Cadbury_Dairy_Chocolate_Milk.png', 'Delicious Cadbury chocolate in a creamy bar.'),
('Chesdale Cheddar Cheese', 'Dairy', 20, 6.00, '/ProductImage/Chesdale_Cheddar_Cheese.png', 'Smooth Chesdale cheddar slices for sandwiches.'),
('Chesdale Cheddar Cheese Large', 'Dairy', 20, 8.50, '/ProductImage/Chesdale_Cheddar_Cheese_Large.png', 'Large pack of Chesdale cheddar cheese for family use.'),
('Chicken Broth', 'PantryStaple', 20, 4.50, '/ProductImage/ChickenBroth.png', 'Rich and flavorful chicken broth for soups and cooking.'),
('Chicken Sausage', 'FrozenFood', 20, 7.50, '/ProductImage/ChickenSausage.png', 'Tasty chicken sausages, perfect for quick meals.'),
('Coco Cola 1.5L', 'Beverage', 20, 4.50, '/ProductImage/Coco_Cola_1.5L.png', 'Classic Coca-Cola for a refreshing drink.'),
('Dairy Farmer Thick and Creamy Yoghurt', 'Dairy', 20, 5.70, '/ProductImage/DairyFarmer_Thick_and_Creamy_Yoghurt.png', 'Thick and creamy yoghurt for a rich flavor.'),
('Dole Banana', 'Fruit', 20, 3.50, '/ProductImage/Dole_Banana.png', 'Fresh bananas perfect for snacking.'),
('Dutch Lady Full Cream Milk', 'Dairy', 20, 6.50, '/ProductImage/Dutch_Lady_Full_CreamMilk.png', 'Creamy full cream milk for your daily needs.'),
('Dutch Lady Milk', 'Dairy', 20, 6.00, '/ProductImage/Dutch_Lady_Milk.png', 'Fresh Dutch Lady milk for all your drinks and recipes.'),
('Envy Apple', 'Fruit', 20, 3.70, '/ProductImage/Envy_Apple.png', 'Crisp and sweet Envy apples.'),
('Farm Fresh Chocolate Milk 2L', 'Dairy', 20, 7.30, '/ProductImage/Farm_Fresh_Chocolate_Milk_2L.png', 'Rich and creamy chocolate milk for a delicious treat.'),
('Farm Fresh Pure Fresh Milk 2L', 'Dairy', 20, 6.50, '/ProductImage/Farm_Fresh_Pure_Fresh_Milk_2L.png', 'Pure fresh milk from Farm Fresh for your daily nutrition.'),
('Ferrero Nutella', 'Snacks', 20, 7.50, '/ProductImage/Ferrero_Nutella.png', 'Ferrero Nutella, the perfect chocolate spread.'),
('Fiji Water', 'Beverage', 20, 4.00, '/ProductImage/Fiji_Water.png', 'Premium natural Fiji water for hydration.'),
('Granny Smith Apple', 'Fruit', 20, 3.70, '/ProductImage/GrannySmith_Apple.png', 'Tart and crisp Granny Smith apples.'),
('Hash Brown', 'FrozenFood', 20, 5.50, '/ProductImage/HashBrown.png', 'Crispy and golden hash browns for breakfast.'),
('Hawaiian Chicken Pizza', 'FrozenFood', 20, 11.00, '/ProductImage/HawaiianChicken_Pizza.png', 'Tasty Hawaiian chicken pizza with juicy toppings.'),
('HEINZ Ketchup', 'PantryStaple', 20, 5.00, '/ProductImage/HEINZ_Ketchup.png', 'Classic HEINZ ketchup for all your meals.'),
('Hock Soon Eggs', 'Dairy', 20, 5.50, '/ProductImage/HockSoon_Eggs.png', 'Farm fresh eggs from Hock Soon.'),
('Julies Peanut Butter', 'Snacks', 20, 5.70, '/ProductImage/Julies_PeanutButter.png', 'Creamy peanut butter spread from Julies.'),
('Kenkori Eggs', 'Dairy', 20, 5.50, '/ProductImage/Kenkori_Eggs.png', 'Free-range eggs from Kenkori farm.'),
('Lays Potato Chips', 'Snacks', 20, 4.00, '/ProductImage/Lays_PotatoChips.png', 'Crispy Lays potato chips in a variety of flavors.'),
('Lettuce', 'Vegetable', 20, 4.30, '/ProductImage/Lettuce.png', 'Fresh and crisp lettuce for salads and sandwiches.'),
('Massimo Sandwich Loaf', 'PantryStaple', 20, 5.00, '/ProductImage/Massimo_Sandwich_Loaf.png', 'Soft Massimo sandwich bread loaf for sandwiches.'),
('NutriPlus Jumbo Eggs', 'Dairy', 20, 6.50, '/ProductImage/NutriPlus_Jumbo_Eggs.png', 'Jumbo eggs for a hearty breakfast.'),
('Potatoes', 'Vegetable', 20, 4.50, '/ProductImage/Potatoes.png', 'Fresh potatoes, great for roasting or mashing.'),
('Snicker Chocolate Bar Box', 'Snacks', 20, 12.50, '/ProductImage/Snicker_Chocolate_Bar_Box.png', 'A box of delicious Snickers chocolate bars.'),
('Snicker Bar', 'Snacks', 20, 3.70, '/ProductImage/SnickerBar.png', 'Single Snickers chocolate bar.'),
('Sprite', 'Beverage', 20, 4.00, '/ProductImage/Sprite.png', 'Refreshing Sprite soda with a lemon-lime flavor.'),
('Spritzer Water', 'Beverage', 20, 3.40, '/ProductImage/Spritzer_Water.png', 'Pure Spritzer water for hydration.'),
('Sunglo Greek Yoghurt', 'Dairy', 20, 6.00, '/ProductImage/Sunglo_Greek_Yoghurt.png', 'Thick and creamy Greek yoghurt from Sunglo.'),
('Vegetable', 'Vegetable', 20, 3.50, '/ProductImage/Vegetetable.png', 'Fresh seasonal vegetables for cooking.');






















