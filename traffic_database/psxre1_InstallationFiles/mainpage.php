<?php
    require_once "session.php";
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 800; padding: 10px; margin: 0 auto; text-align: center}
            .links {border-style: solid; border-width: 2px; border-radius: 5px; border-color: black;
            padding: 5px; }
            
        </style>
</head>

<body> 
<div class = "wrapper">
    <?php
        echo "<h1>";
        echo "Hi " .$_SESSION['username'];
        echo "</h1>";
        echo "</br>";
        if($_SESSION['admin']==1)
        {
            echo "<a class = 'btn btn-primary btn-lg btn-block' href = 'create_user.php' role'button'> Officer accounts </a> </br>";
            
        }
    ?>

    <a class = "btn btn-primary btn-lg btn-block" href = "Vehicle.php" role="button"> Vehicle Database </a> </br>
    <a class = "btn btn-primary btn-lg btn-block" href = "People.php" role="button"> People Database </a> </br>
    <a class = "btn btn-primary btn-lg btn-block" href = "incident.php" role="button"> File Incident </a> </br>
    <a class = "btn btn-primary btn-lg btn-block" href = "view_incident.php" role="button"> Find Incident Report </a> </br>
    <a class = "btn btn-primary btn-lg btn-block" href = "logout.php" role="button"> Log out </a> </br>
    <a class = "btn btn-primary btn-lg btn-block" href = "passwordchange.php" role="button"> Change Password </a> </br>
</div>
</body>
</html>