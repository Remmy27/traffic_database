<?php
    require_once "session.php";
    require_once "static.php";
?>
<html>
<head>
<title> People </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 800; padding: 10px; margin: 0 auto;}
            .bottom{ position:absolute; bottom:10; left: 10px;}
                    
        </style>
</head>

<body>
    <div class = "wrapper">
        <form method = "POST">
        <div class = "form-group"> 
            <label for = "fullname"> Full name </label>
            <input type = "text" name = "fullname" class = 'form-control'> </br>
            <label for = "address"> Address </label>
            <input type = "text" name = "address" class = 'form-control'> </br>
            <label for = "driverslicence"> Drivers Licence </label>
            <input type = "text" name = "driverslicence" class = 'form-control'></br>
        </div>
            <input type = "submit" value = "Add Driver" class = "btn btn-primary"> <br/>
        </form>
    

        <?php

            require_once "db_connection.php";
            //if the data is posted
            if(isset($_POST['fullname']))
            {
                $sql = "INSERT into people (People_name, People_address, People_licence)
                        VALUES
                        ('".$_POST['fullname']."', '".$_POST['address']."', '".$_POST['driverslicence']."')";
                
                $result = mysqli_query($conn, $sql);
                
                echo mysqli_error($conn);
                // redirect to add vehicle page
                header("location: add_vehicle.php");
                echo "Driver added"; 

            }
            
        ?>
    </div>


</body>