<?php
    require_once "session.php";
    require_once "static.php";
?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 350px; padding: 10px; margin: 0 auto; margin-top: 50px;}
            .bottom{ position:absolute; bottom:10; left: 10px;}
            
        </style>
</head>
<body>
    <div class = "wrapper">
        <form method = "POST">
        <div class = "form-group"> 
            <label for = "currentpassword"> Current Password </label>
            <input type = "password" name = "currentpassword" class = 'form-control'> </br>
            <label for = "newpassword"> New password </label>
            <input type = "password" name = "newpassword" class = 'form-control'> </br>
            <label for = "newpassword2"> Confirm New password </label>
            <input type = "password" name = "newpassword2" class = 'form-control'></br>
        </div>

            <input type = "submit" value = "Change password" class = "btn btn-primary"> <br/>
        </form>
    </div>
        
    <?php
        require_once "db_connection.php";

        $sql = "SELECT password from users 
                WHERE userID = '".$_SESSION['id']."';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // if the password entered matches the current password execute query
        if(isset($_POST['currentpassword']))
        {
            if($_POST['currentpassword']==$row['password'] && $_POST['newpassword']==$_POST['newpassword2'])
            {
                $sql = "UPDATE users
                        SET password = '".$_POST['newpassword']."'
                        WHERE username = '".$_SESSION['username']."';";
                //runs query
                $result = mysqli_query($conn, $sql);
                echo "Password changed succesfully";
                echo "<a href ='mainpage.php'> Back </a>";
                
            }
            // if new passwords do not match
            if($_POST['newpassword']!=$_POST['newpassword2'])
            {
                echo "<p style ='color: red;'> The new passwords do not match </p>";
            }
            else
            {
                echo "<p style ='color: red;'> current pasword incorrect </p>";
            }
        }
    ?>

</body>
</html>