<?php
    require_once "session.php";
    require_once "static.php";
    require_once "db_connection.php";
    //if not an admin redirect to mainpage
    if($_SESSION['admin']!=1)
    {
        header("location: mainpage.php");
    }
?>
<head>
<title> Users </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 800; padding: 10px; margin: 0 auto;}
            .bottom{ position:absolute; bottom:10; left: 10px;}
            .form-col { column-count: 2;}
            .small{ width:400; margin: auto}
                    
        </style>
</head>
<body>
    <div class = "wrapper">
        <div class = "small">
        <h1 style = 'text-align:center'> Users </h1>
        <?php
            $sql = "SELECT * from users 
                    WHERE userID != {$_SESSION['id']};";
            $result = mysqli_query($conn, $sql);
            echo mysqli_error($conn);
            echo "<table class = 'table table-striped' style = 'background-color: white;'>";
            echo "<tr><th> Username </th></tr>";
            
            while($row=mysqli_fetch_assoc($result))
            {
                echo "<tr><td> {$row['Username']} </td>
                    <td> <a onClick=\"javascript: return confirm('Are you Sure?');\" href = 'delete.php?id={$row['userID']}&type=user'> Delete </a></td></tr>";
            
            }
            echo "</table>";
        ?>
        </div>
        <h1> Create User </h1>
        <form method = "POST">
        <div class = "form-group"> 
            <label> Username </label>
            <input type = "text" name = "username" class = 'form-control'> </br>
            <label> Password </label>
            <input type = "password" name = "password" class = 'form-control'> </br>
            <label> Confirm Password </label>
            <input type = "password" name = "confpassword" class = 'form-control'></br>
        </div>

            <input type = "submit" value = "Create User" class = "btn btn-primary"> <br/>
        </form>
        <?php
            
            if(isset($_POST['password']))
            {
                if($_POST['password']==$_POST['confpassword'])
                {

                    $sql = "INSERT into users (Username, Password)
                            VALUES
                            ('".$_POST['username']."', '".$_POST['password']."');";

                    $result = mysqli_query($conn, $sql);
                    echo mysqli_error($conn);
                    echo "<br>";
                    echo "Account Created";
                }
                else
                {
                    echo "passwords dont match";
                }
            }

        ?>
    </div>
</body>