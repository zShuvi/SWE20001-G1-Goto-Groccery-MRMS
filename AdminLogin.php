<?php
    session_start();

    include 'Database.php';


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input from the form
    $usr_name = $_POST["username"];
    $pwd = $_POST["password"];

    // Prepare the SQL query to find the user with specific roles
    $sql = "SELECT * FROM userstable WHERE username = '$usr_name'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            { 
                if ($usr_name == $row["Username"] && $pwd == $row["Password"])
                {
                    if (in_array($row["Role"], ["Staff","JuniorAdmin","SeniorAdmin"]))
                    {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['active_user'] = $row["ID"];
                        $_SESSION['active_role'] = $row["Role"];
                        header("Location: AdminHome.php");
                        exit(); // Terminate the script here after redirect
                    }
                    else 
                    {
                        $_SESSION['logged_in'] = false;
                    $_SESSION['error'] = "Your account is not a staff account.";
                    header("Location: AdminLogin.php");
                    exit();
                    }
                }
                else 
                {
                    //Wrong password
                    $_SESSION['logged_in'] = false;
                    $_SESSION['error'] = "Invalid password. Please try again.";
                    header("Location: AdminLogin.php");
                    exit();
                    
                }
            }
        }
        else 
        {
            //User not found
            $_SESSION['logged_in'] = false;
            $_SESSION['error'] = "Invalid Username";
            header("Location: AdminLogin.php");
            exit();
        }
}

    /* Session cleanup: for logout redirecting to here */
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta name="description" content="Goto Grocery MRMS">
	<meta name="keywords" content="Admin Login Page" >
    <title>Admin Login Page for Goto Grocery MRMS</title>
    <link href="styles/adminlogin_style.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet" >
</head>

<body>

    <div class="design">
        <form method="POST" action="">
            <h1>Admin Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me </label>
                <a href="#">Forgot Password?</a>
            </div>

            <?php
                if (isset($_SESSION['error'])){
                    echo '<p id="error-message">' . htmlspecialchars($_SESSION['error']) . '</p>';
                }
                unset($_SESSION['error']);
            ?>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>

</body>

</html>
