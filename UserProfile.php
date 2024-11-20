<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: Home.php");
        exit;
    }

    //$_SESSION['active_user'] = 1;   //dummy session id. active_user tracks using user's ID. 
$userid = $_SESSION['active_user'];

include 'Database.php';

// Get every users information from the table with an ID
$sql = "SELECT * FROM userstable WHERE ID = '"."$userid"."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1)
    {
        while($row = $result->fetch_assoc())
        {
            $username = $row["Username"];
            $email = $row["Email"];
            $role = $row["Role"];
            $password = $row["Password"];
            $profile = $row["ProfileImagePath"];

            if($row["Gender"] == 'M'){
                $gender = "Male";
            } else{
                $gender = "Female";
            }

            $phone_number = $row["PhoneNumber"];
            $date_of_birth = $row["DateOfBirth"];
        }
    }




// If any form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Get info whether the submitted form is for password or for info
    $form_type = $_POST["form_type"];

    // If the submitted form section is for General Info
    if ($form_type == "general_info"){

        // Image 
        if (isset($_FILES['image'])  && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $uploadDirectory = "images/ProfileImage/";
            $fileTempPath = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES["image"]["name"]);
            $destinationPath = $uploadDirectory . $fileName;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $error = "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size (limit to 2MB)
            if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
                $error = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow only specific file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                $error = "Sorry, only JPG, JPEG, & PNG files are allowed.";
                $uploadOk = 0;
            }
        
            // Check if the directory exists, if not, create it
            if (!is_dir($uploadDirectory)) {
                if (!mkdir($uploadDirectory, 0777, true)) {
                    $error = "Failed to create upload directory.";
                }
            }
        
                // Check if uploadOk is set to 1
        if ($uploadOk == 1) {
            // Move the file and check if it was successful
            if (move_uploaded_file($fileTempPath, $destinationPath)) {
        
                // Update the database with the new image path
                $sql = "UPDATE userstable SET ProfileImagePath = ? WHERE ID = ?";
        
                if ($updateImage = $conn->prepare($sql)) {
                    $updateImage->bind_param("si", $destinationPath, $userid);
                    if ($updateImage->execute()) {
                        $profile = $destinationPath;
                        error_log("Image uploaded successfully to: " . $destinationPath);
                    } else {
                        $error = "Error updating image in the database.";
                    }
                    $updateImage->close();
                } else {
                    $error = "Failed to prepare image update statement.";
                }
        
            } else {
                $error = "Failed to upload profile image.";
            }
        }
        
        }



        // Other Information
        if ($_POST['username'] != $username || $_POST['email'] != $email || $_POST['gender'] != $gender || $_POST['phone_number'] != $phone_number || $_POST['date_of_birth'] != $date_of_birth)
        {

            $newUsername = $_POST['username'];
            $newEmail = $_POST['email'];
            $newGender = $_POST['gender'];
            $newPhoneNumber = $_POST['phone_number'];
            $newDateOfBirth = $_POST['date_of_birth'];

            

            $sql = "UPDATE userstable SET Email = ?, Username = ?, Gender = ?, PhoneNumber = ?, DateOfBirth = ? WHERE ID = ?";


            if ($updateUser = $conn->prepare($sql)) //defines updateuser
            {
                $updateUser->bind_param("sssssi", $newEmail, $newUsername, $newGender, $newPhoneNumber, $newDateOfBirth, $userid);
                /* the format of the input;     
                recommended to guard it with prepare() instead of query() for security (updating database) */

                $updateUser->execute();
                $updateUser->close();


                // Update the session variable
                $_SESSION['active_name'] = $newUsername;

                $username = $newUsername;
                $email = $newEmail;

                if($newGender == 'M'){
                    $gender = "Male";
                } else{
                    $gender = "Female";
                }

                $phone_number = $newPhoneNumber;
                $date_of_birth = $newDateOfBirth;

            }
            else 
            {
                $_SESSION['error'] = "Error updating info.";
            } 
        }


    } else if ($form_type == "password_update"){

        if ($_POST['currentpassword'] != $password){

            $error = "Wrong Password";
            
        } else {

            if ($_POST['newpassword'] != $password)
            {
                if ($_POST['newpasswordConfirm'] == $_POST['newpassword'])
                {
                    $newPassword = $_POST['newpassword'];

                    $sql = "UPDATE userstable SET Password = ? WHERE ID = ?"; //abstract

                    if ($updatePassword = $conn->prepare($sql)) //defines updatePassword
                    {
                        $updatePassword->bind_param("si", $newPassword, $userid); 
                        /* the format of the input; 
                        recommended to guard it with prepare() instead of query() for security (updating database) */

                        $updatePassword->execute();
                        $updatePassword->close();

                        $error = "Password Changed.";
                    }
                    else 
                    {
                        $error = "Error updating info.";
                    }
                }
                else
                {
                    $error = "Password must match confirmation.";
                }
            }
        }
    }            
}    
    
?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Home Page">
	<meta name="keywords" content="Goto Grocery, Home" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">  
	<link href="styles/userprofile_style.css" rel="stylesheet">
</head>



<body>
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">

    <nav class="navbar">
            <a href="Home.php">Home</a>
            <a href="Home.php#features">Features</a>
            <a href="Product.php">Products</a>
            <a href="Home.php#reviews">Reviews</a>
            <a href="OrderHistory.php">Order History</a>
    </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn">
            <ul class="dropdown-content">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Product.php">Products</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
            </ul>
        </div>
        <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
    </div>
    </header>


    <!-- Home, outside of Navigation Side Bar -->

    <section class="home">

        <?php
            if (isset($error)){
                echo "<script>alert('$error');</script>";
            }
            unset($error);
        ?>

        <div class="container light-style flex-grow-1 container-p-y">

            <div class="card overflow-hidden">

                <div class="row no-gutters row-bordered row-border-light">

                    <div class="col-md-3 pt-0">

                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-info">Edit Information</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Change Password</a>                   
                        </div>


                    </div>
                    
                    <div class="col-md-9">
                        <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src=<?php echo "$profile"; ?> alt="Profile Picture" id="profile-image" class="d-block ui-w-80" onerror="this.src='images/Profile_Placeholder.png';">
                
                                </div>
                                <hr class="border-light m-0" >
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username: <?php echo $username ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Role: <?php echo $role ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email: <?php echo $email ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gender: <?php echo $gender ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone Number: <?php echo $phone_number ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Date of Birth: <?php echo $date_of_birth ?></label>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="account-info">

                            <!-- FORM METHOD -->
                            <form method="POST" action="#" enctype="multipart/form-data" class="form">
                                <!-- Hidden input show we know it's for general infor form -->
                                <input type="hidden" name="form_type" value="general_info">


                                    <div class="card-body media align-items-center">
                                        <img src= <?php echo "$profile"; ?> alt="Profile Picture" id="profile-image" class="d-block ui-w-80" onerror="this.src='images/Profile_Placeholder.png';">
                                        <div class="media-body ml-4">
                                            <label class="btn btn-outline-primary">
                                                Upload new photo
                                            <input type="file" name="image"  class="account-settings-fileinput">
                                            </label>
                                            <br>
                                            <label>*Only JPEG, JPG, and PNG [2MB Max]*</label>
                                        </div>
                                    </div>

                                <div class="card-body pb-2">
                                
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" name="username" value="<?php echo $username; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Gender</label>
                                        <div class="gender">
                                            <input type="radio" id="check-male" name="gender" value="M" <?php if ($gender == 'Male') echo 'checked'; ?> />
                                            <label for="check-male">Male</label>
                                            <span>&nbsp;</span>
                                            <input type="radio" id="check-female" name="gender" value="F" <?php if ($gender == 'Female') echo 'checked'; ?> />
                                            <label for="check-female">Female</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control mb-1" name="date_of_birth" value=<?php echo $date_of_birth ?>>
                                    </div>
                                </div>


                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                    
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value=<?php echo $email ?>>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone_number" value=<?php echo $phone_number ?>>
                                    </div>
                                    
                                </div>
                                <div class="text-right mt-3">
                                <button type="submit" name="submit" class="btn">Save changes</button>&nbsp;
                                <button type="reset" class="btn">Cancel</button>
                                </div>

                                </form>
                            </div>

                            <div class="tab-pane fade" id="account-change-password">
                                <form method="POST" action="#account-change-password" class="form">

                                <div class="card-body pb-2">

                                
                                <input type="hidden" name="form_type" value="password_update">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" name="currentpassword" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" name="newpassword" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" name="newpasswordConfirm" class="form-control">
                                    </div>
                                
                                </div>

                                <div class="text-right mt-3">
                                <button type="submit" class="btn">Save changes</button>&nbsp;
                                <button type="reset" class="btn">Cancel</button>
                                </div>

                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="container">
            


        </div>
        
    </section>

    
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Customer Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Social Media</h4>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-subscribe">
                <h4>Subscribe to Our Newsletter</h4>
                <input type="email" placeholder="Your email...">
                <button>Subscribe</button>
            </div>
        </div>
    </footer>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script src="scripts/dropdown.js"></script>
</body>



</html>
