<?php
    session_start();
    // Destroy session
    if(isset($_SESSION['username'])) {
        // Redirecting To Home Page
        session_unset();
        session_destroy();
        header("Location: homepage.html");
    }
    else{
        header("Location: login.php");
    }
