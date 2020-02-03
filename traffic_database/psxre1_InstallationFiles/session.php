<?php
    //start session
    session_start();
    // if not logged in redirect to login page
    if(!isset($_SESSION["loggedin"]))
    {
        header("location: login.php");
    }
?>