<!DOCTYPE html>
<html lang="en">
<body>

    <?php 
        $usr_name = $_POST["username"];
        $pwd = $_POST["password"];
        include 'Database.php'; // include the database connection
        $sql = "SELECT * FROM userstable WHERE username = '"."$usr_name"."'"; // get user
        $result = $conn->query($sql);

        if ($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            { 
                if ($usr_name == $row["Username"] && $pwd == $row["Password"])
                {
                    $_SESSION['logged_in'] = true;
                    header("Location: Home.html");
                    exit(); // Terminate the script here after redirect
                }
                else 
                {
                    //Wrong password
                    $_SESSION['logged_in'] = false;
                    header("Location: Login.html");
                    exit(); //need popup/label to tell user wrong password
                }
            }
        }
        else 
        {
            //User not found
            $_SESSION['logged_in'] = false;
            header("Location: Login.html");
            exit(); //need popup/label to say user not found
        }
    ?> 

</body>
</html>
