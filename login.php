<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="css/style1.css" />
</head>

<body>
    <?php
    include('partials/dbconnect.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['email'])) {
        $email = stripslashes($_REQUEST['email']);    // removes backslashes
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $role = stripslashes($_REQUEST['role']);
        $role = mysqli_real_escape_string($con, $role);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE email='$email'
                    AND role='$role'";
        $result = mysqli_query($con, $query);
        $nrows = mysqli_num_rows($result);
        if ($nrows == 1) {
            $row = mysqli_fetch_assoc($result);
            $upwd = $row['pwd'];
            if (password_verify($password, $upwd)) {
                $username = $row['uname'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                if ($role == "customer") {
                    header("Location: customer.php");
                } else if ($role == "pharmacist") {
                    header("Location: pharmacist.php");
                } else if ($role == "manufacturer") {
                    header("Location: manufacturer.php");
                } else if ($role == "distributor") {
                    header("Location: distributor.php");
                }
            } else {
                echo "<div class='form'>
                  <h3>Incorrect password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>Incorrect email id.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        <form class="form" method="post" name="login">
            <h1 class="login-title">Login</h1>
            <input type="email" maxlength="50" class="login-input" name="email" placeholder="Email" autofocus="true" required />
            <input type="password" maxlength="50" class="login-input" name="password" placeholder="Password" required />
            <select class="login-select" name="role" required="">
                <option selected value="customer">Customer</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="manufacturer">Manufacturer</option>
                <option value="distributor">Distributor</option>
            </select>
            <input type="submit" value="Login" name="submit" class="login-button" />
            <p class="link">Don't have an account? <a href="register.php">Click to Register</a></p>
            <p class="link">Return to <a href="homepage.html">Homepage</a></p>
        </form>
    <?php
    }
    ?>
</body>

</html>