<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Grid</title>
    <link rel="stylesheet" href="ProductPageStyle.css">

</head>
<body>
    <header>
        <h1>GotoGrocery Product Page</h1>
    </header>

    <div class="container">
        <div class="product-grid">
            <?php 
            include 'Database.php'; // include the database connection
            $sql = "SELECT * FROM ProductTable"; // get all products
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) { //Image not working//
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
                echo "No products found!";
            }
            $conn->close(); // close the database connection
            ?>
        </div>
    </div>

    <footer>
        <p></p>
    </footer>
</body>
</html>