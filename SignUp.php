<?php
// Start session
session_start();

include 'Database.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input from the form
    $usr_name = $_POST["username"];
    $email = $_POST["email"];
    $phonenumber = $_POST["phone_number"];
    $dob = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $pwd = $_POST["password"];
    $role = "Member";

    // Prepare the SQL query to create user
    $sql = "INSERT INTO userstable (Role, Username, Email, PhoneNumber, DateOfBirth, Gender, Password) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($createUser = $conn->prepare($sql)) //defines createUser
    {
        $createUser->bind_param("sssssss", $role, $usr_name, $email, $phonenumber, $dob, $gender, $pwd); 
        /* the format of the input; 
        recommended to guard it with prepare() instead of query() for security (updating database) */

        $createUser->execute();
        $createUser->close();

        Header("Location: Login.php");
    }
    else 
    {
        $_SESSION['error'] = "Error creating user.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta name="description" content="Goto Grocery MRMS">
	<meta name="keywords" content="Sign Up Page" >
    <title>Sign Up for Goto Grocery MRMS</title>
    <link href="styles/signup_style.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet" >
</head>

<body>

    <div class="design">
        <form method="POST" action="#" class="form">
            <h1>Sign Up <i class='bx bxs-user'></i></h1>
            <div class="input-box">
                <label>Full Name</label>
                <input type="text" placeholder="Enter full name" name="username" required/>
            </div>

            <div class="input-box">
                <label>Email Address </label>
                <input type="text" placeholder="Enter email address" name="email" required/>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Phone Number </label>
                    <input type="text" placeholder="Enter phone number" name="phone_number" required/>
                </div>

                <div class="input-box">
                    <label>Birth Date</label>
                    <input type="date" placeholder="Enter birth date" name="date_of_birth" required/>
                </div>
            </div>

            <div class="gender-box">
                <h3>Gender</h3>
                <div class="gender-option">
                    <div class="gender">
                        <input type="radio" id="check-male" name="gender" value="M" checked />
                        <label for="check-male">Male</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-female" name="gender" value="F" checked />
                        <label for="check-female">Female</label>
                    </div>
                </div>
            </div>

            <div class="input-box">
                <label>Password</label>
                <input type="password" id="password" placeholder="Create a password" name="password" pattern="^.{8,}$" 
                title="Must contain at least 8 or more characters" required />
            </div>

            <div class="input-box">
                <label>Confirm Password</label>
                <input type="password" id="confirm-password" placeholder="Confirm your password" pattern="^.{8,}$" 
                title="Must contain at least 8 or more characters" required />
                <p id="error-message">Passwords do not match!</p>
            </div>

            <button id="submit-btn">Submit</button>

        </form>
    </div>

    <script src="scripts/signup.js"></script>
    <script src="scripts/password_date_check.js"></script>
</body>
</html>
