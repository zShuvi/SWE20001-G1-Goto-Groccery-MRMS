<?php
include 'Database.php'; // include the database connection

session_start();

// Get the category from the URL
$category = isset($_GET['category']) ? explode(',', $_GET['category']) : [];

// Prepare SQL query based on selected category
if (count($category) > 1) {
    $escapedCategories = array_map(function($cat) use ($conn) {
        return mysqli_real_escape_string($conn, $cat);
    }, $category);
    $sql = "SELECT * FROM ProductTable WHERE Category IN ('" . implode("','", $escapedCategories) . "')";
} elseif (count($category) == 1) {
    $sql = "SELECT * FROM ProductTable WHERE Category = '" . mysqli_real_escape_string($conn, $category[0]) . "'";
} else {
    $sql = "SELECT * FROM ProductTable"; // get all products
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Products in <?php echo htmlspecialchars(implode(' & ', $category)); ?></title>
    <link rel="stylesheet" href="styles/ProductStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">

    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>
        <nav class="navbar">
            <a href="Home.php">Home</a>
            <a href="Home.php#features">Features</a>
            <a href="Product.php">Products</a>
            <a href="Home.php#reviews">Reviews</a>

        </nav>

        
        <div class="icons">
            <div class="fa fa-bars" id="menu-btn"></div>
            <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
            <div class="fa fa-user" id="user-btn">
                <ul id="dropdownList" class="dropdown-content">
                    <!-- Content will be populated by JavaScript -->
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <h2 class="ribbon-header">Products in <?php echo htmlspecialchars(implode(' & ', $category)); ?></h2>
        <div class="product-grid">

            <?php 
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                    echo '
                    <div class="product">  
                        <a href="ProductDetails.php?id=' . $row["ProductID"] . '">
                            <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                            <h2>' . $row["Name"] . '</h2>
                            <p class="price">RM' . $row["Price"] . '</p>
                        </a>
                    </div>';
                }
            } else {
                echo "No products found in this category!";
            }

            $conn->close(); // close the database connection
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Goto Grocery. All rights reserved.</p>
    </footer>

    <script src="scripts/dropdown.js"></script>
</body>
</html>
