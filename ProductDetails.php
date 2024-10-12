<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Details</title>
    <link rel="stylesheet" href="ProductDetailsStyle.css">
</head>
<body>
    <header>
        <h1>GotoGrocery Product Details</h1>
    </header>

    <div class="container">
        <div class="product">
            <?php
            include 'Database.php'; // include the database connection
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                $sql = "SELECT * FROM ProductTable WHERE ProductID = $productId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output each data for every product
                    while($row = $result->fetch_assoc()) { // Image not working //
                        echo '
                        <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                        <div class="product-details">
                            <h2>' . $row["Name"] . '</h2>
                            <p class="price">RM' . $row["Price"] . '</p>
                            <p class="description">' . $row["Description"] . '</p>
                        </div>';
                    }
                } else {
                    echo "Product not found!";
                }
            } else {
                echo "No product selected!";
            }
            $conn->close(); // close the database connection
            ?>
        </div>
    </div>

    <footer>
        <p>Footer content</p>
    </footer>
</body>
</html>