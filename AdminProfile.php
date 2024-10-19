<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }

    
?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Products Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/adminprofile_style.css" rel="stylesheet">
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
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if ($_POST['username'] != $username || $_POST['email'] != $email)
            {
                $newUsername = $_POST['username'];
                $newEmail = $_POST['email'];
    
                $sql = "UPDATE userstable SET Email = ?, Username = ? WHERE ID = ?"; //abstract
    
                if ($updateUser = $conn->prepare($sql)) //defines updatePassword
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
    
                    if ($updatePassword = $conn->prepare($sql)) //defines updateUser
                    {
                        $updatePasswprd->bind_param("si", $newPassword, $userid); 
                        /* the format of the input; 
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

    <!-- Navigation Sidebar -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">

                <span class="image">
                    <img src="images/admin.png" alt="logo">
                </span>


                <div class="text header-text">
                    <span class="name"><?php echo $_SESSION['active_username']; ?></span>
                    <span class="profession"><?php echo $_SESSION['active_role']; ?></span>
                </div>

            </div>

            <i class='bx bx-chevron-right toggle'></i>

        </header>


        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                        <i class="bx bx-search icon"></i>
                        <input type="text" placeholder="Search.....">
                </li>

                <ul class="menu-links">

                    <li class="">
                        <a href="AdminHome.php">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="">
                        <a href="AdminProduct.php">
                            <i class="bx bx-box icon"></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>

                    

                    <li class="">
                        <a href="AdminReport.php">
                            <i class="bx bxs-report icon"></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>

                    <li class="">
                        <a href="AdminStockOrder.php">
                            <i class="bx bx-cart-add icon"></i>
                            <span class="text nav-text">Stock Ordering</span>
                        </a>
                    </li>


                    <li class="">
                        <a href="AdminNotification.php">
                            <i class="bx bx-bell icon"></i>
                            <span class="text nav-text">Notification</span>
                        </a>
                    </li>

                   
                    <li class="">
                        <a href="AdminProfile.php">
                            <i class="bx bxs-user-detail icon"></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">

                <li class="log">
                    <a href="AdminLogin.php?logout=true">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>

                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>


        </div>
    </nav>



    
    <!-- Home, outside of Navigation Side Bar -->

    <section class="home">

        <div class="container light-style flex-grow-1 container-p-y">

            <div class="text">Profile</div>

            <div class="card overflow-hidden">

                <div class="row no-gutters row-bordered row-border-light">

                    <div class="col-md-3 pt-0">

                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-info">Info</a>                   
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
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control"
                                            rows="5">Hi, my name is Joeeeeeeeee.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" class="form-control" value="May 3, 1995">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">States, Area</label>
                                        <select class="custom-select">
                                            <option>Johor</option>
                                            <option selected>Kuala Lumpur</option>
                                            <option>Kedah</option>
                                            <option>Kelantan</option>
                                            <option>Labuan</option>
                                            <option>Melaka</option>
                                            <option>Negeri Sembilan</option>
                                            <option>Pahang</option>
                                            <option>Penang</option>
                                            <option>Perak</option>
                                            <option>Perlis</option>
                                            <option>Putrajaya</option>
                                            <option>Selangor</option>
                                            <option>Sabah</option>
                                            <option>Sarawak</option>
                                            <option>Terengganu</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="+0 (123) 456 7891">
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

    


    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>



</html>
