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
        <form action="#" class="form">
            <h1>Sign Up <i class='bx bxs-user'></i></h1>
            <div class="input-box">
                <label>Full Name</label>
                <input type="text" placeholder="Enter full name" required/>
            </div>

            <div class="input-box">
                <label>Email Address </label>
                <input type="text" placeholder="Enter email address" required/>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Phone Number </label>
                    <input type="text" placeholder="Enter phone number" required/>
                </div>

                <div class="input-box">
                    <label>Birth Date</label>
                    <input type="text" placeholder="Enter birth date" required/>
                </div>
            </div>

            <div class="gender-box">
                <h3>Gender</h3>
                <div class="gender-option">
                    <div class="gender">
                        <input type="radio" id="check-male" name="gender" checked />
                        <label for="check-male">Male</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-female" name="gender" checked />
                        <label for="check-female">Female</label>
                    </div>
                </div>
            </div>

            <div class="input-box address">
                <label>Address</label>
                <input type="text" placeholder="Enter street address" required/>
                <input type="text" placeholder="Enter street address line 2" required/>
                <input type="text" placeholder="Enter your state" required/>
                <div class="column">
                <input type="text" placeholder="Enter your city" required/>
                <input type="text" placeholder="Enter postal code" required/>
                </div>
            </div>

            <button>Submit</button>

        </form>
    </div>

</body>

</html>
