<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: Home.php");
        exit;
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
    <?php
        //$_SESSION['active_user'] = 1;   //dummy session id. active_user tracks using user's ID. 
        $userid = $_SESSION['active_user'];
        include 'Database.php';
        $sql = "SELECT * FROM userstable WHERE ID = '"."$userid"."'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            {
                $username = $row["Username"];
                $email = $row["Email"];
                $password = $row["Password"];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if ($_POST['username'] != $username || $_POST['email'] != $email)
            {
                $newUsername = $_POST['username'];
                $newEmail = $_POST['email'];
    
                $sql = "UPDATE userstable SET Email = ?, Username = ? WHERE ID = ?"; //abstract
    
                if ($updateUser = $conn->prepare($sql)) //defines updateUser
                {
                    $updateUser->bind_param("ssi", $newEmail, $newUsername, $userid); 
                    /* the format of the input; 
                    recommended to guard it with prepare() instead of query() for security (updating database) */
    
                    $updateUser->execute();
                    $updateUser->close();
                }
                else 
                {
                    $_SESSION['error'] = "Error updating info.";
                }
            }
            if ($_POST['newpassword'] != $password)
            {
                if ($_POST['newpasswordConfirm'] == $_POST['newpassword'])
                {
                    $newPassword = $_POST['newpassword'];

                    $sql = "UPDATE userstable SET Password = ? WHERE ID = ?"; //abstract
    
                    if ($updatePassword = $conn->prepare($sql)) //defines updatePassword
                    {
                        $updatePasswprd->bind_param("si", $newPassword, $userid); 
                        /*the format of the input; 
                        recommended to guard it with prepare() instead of query() for security (updating database) */
        
                        $updatePassword->execute();
                        $updatePassword->close();
                    }
                    else 
                    {
                        $_SESSION['error'] = "Error updating info.";
                    }
                }
                else
                {
                    $_SESSION['error'] = "Password must match confirmation.";
                }
            }
                
        }
    ?>

    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">

    <nav class="navbar">
        <a href="Home.php">home</a>
        <a href="#features">features</a>
        <a href="#products">products</a>
        <a href="#categories">categories</a>
        <a href="#reviews">reviews</a>
    </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn"></div>
        <div class="fa fa-shopping-cart" id="cart-btn"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
        <?php
            echo '<label class="user"> '. $_SESSION['active_username'] . '</label>';
        ?>
    </div>
    </header>


    <!-- Home, outside of Navigation Side Bar -->

    <section class="home">

        <div class="container light-style flex-grow-1 container-p-y">

            <div class="card overflow-hidden">

                <div class="row no-gutters row-bordered row-border-light">

                    <div class="col-md-3 pt-0">

                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">General</a>
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">Edit Profile</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Change password</a>                   
                        </div>


                    </div>
                    
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src="images/Profile_Placeholder.png" alt="Profile Picture"
                                        class="d-block ui-w-80">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" class="account-settings-fileinput">
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" value=<?php echo $username ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" value=<?php echo $email ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" value="Company Ltd.">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" value=<?php echo $password ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="newpassword">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="newpasswordConfirm">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <label class="form-control">May 3, 1995</label> 
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">States, Area</label>
                                        <label class="form-control">Kuala Lumpur</label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <label class="form-control">+0 (123) 456 7891</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right mt-3">
                                <button type="button" class="btn">Save changes</button>&nbsp;
                                <button type="button" class="btn">Cancel</button>
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
