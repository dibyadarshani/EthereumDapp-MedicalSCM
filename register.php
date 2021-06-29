<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="css/style1.css" />
</head>

<body>
    <?php
    include('partials/dbconnect.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $role = stripslashes($_REQUEST['role']);
        $role = mysqli_real_escape_string($con, $role);
        $emailchk = "SELECT * FROM `users` WHERE email='$email'";
        $exists = mysqli_query($con, $emailchk);
        $numexists = mysqli_num_rows($exists);
        if ($numexists > 0) {
            echo "<div class='form'>
                  <h3>Account associated with the provided email already exists.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>login</a> or Click here to 
                  <a href='register.php'>register</a> with another email id.</p>
                  </div>";
        } else {
            $query    = "INSERT into `users` (uname, pwd, email, role)
                        VALUES ('$username', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$email', '$role')";
            $result   = mysqli_query($con, $query);
            if ($result) {
                echo "<div class='form'>
                    <h3>You are registered successfully.</h3><br/>
                    <p class='link'>Click here to <a href='login.php'>Login</a></p>
                    </div>";
            } else {
                echo "<div class='form'>
                    <h3>Required fields are missing.</h3><br/>
                    <p class='link'>Click here to <a href='register.php'>register</a> again.</p>
                    </div>";
            }
        }
    } else {
    ?>
        <form class="form" action="" method="post">
            <h1 class="login-title">Registration</h1>
            <input type="text" maxlength="30" class="login-input" name="username" placeholder="Username" required />
            <input type="email" maxlength="50" class="login-input" name="email" placeholder="Email Address" required />
            <input type="password" maxlength="50" class="login-input" name="password" placeholder="Password" required />
            <select class="login-select" name="role" required>
                <option selected value="customer">Customer</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="manufacturer">Manufacturer</option>
                <option value="distributor">Distributor</option>
            </select>
            <input type="submit" name="submit" value="Register" class="login-button">
            <p class="link">Already have an account? <a href="login.php">Click to Login</a></p>
            <p class="link">Return to <a href="homepage.html">Homepage</a></p>
        </form>
    <?php
    }
    ?>
</body>

</html>