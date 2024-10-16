<?php
include 'Database.php'; // include the database connection

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
    <link rel="stylesheet" href="ProductStyle.css">
</head>

<body>
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="#products">Products</a>
            <a href="#categories">Categories</a>
            <a href="#reviews">Reviews</a>
        </nav>
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
</body>
</html>