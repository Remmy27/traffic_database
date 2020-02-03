<html>
<head>
    <meta charset="utf-8">
    <!-- using bootstrap for formatting -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 350px; padding: 10px; margin: 0 auto;}
            
        </style>
</head>

<body>
    <div class = "wrapper">
        <h1 style="text-align:center;">Traffic Database</h1>
        <form method = "POST">
            <div class = "form-group">
                <label for = "username">Username</label> 
                <input type="text" name="username" id = "username" class="form-control"><br/>
            </div>
            <div class = "form-group">
                <label for = "password">Password</label>
                <input type = "password" name = "password" class="form-control"><br/>
            </div>
                <button type = "submit" class="btn btn-primary">Log in</button><br/>
        </form>
        <?php
            //begin session
            session_start();
            
            // check if there is already a session if there is redirect to welcome page
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
            {
                header("location: mainpage.php");
                exit;
            }
            
            // connecting to db
            require_once "db_connection.php";

            
            // if username and password is not empty
            if(isset($_POST['username']))
            {
                if($_POST['username']!="" && $_POST['password']!="")
                {
                    $sql = "SELECT * FROM users  
                            WHERE Username = '".$_POST['username']."' 
                            AND Password = '".$_POST['password']."'"; 
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    // if returns a result username and password is correct
                    if(mysqli_num_rows($result)==1)
                    {
                        // starting session and creating session variables
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['password'] = $row['Password'];
                        $_SESSION['id'] = $row['userID'];
                        $_SESSION['admin'] = $row['Admin'];
                        
                        // redirect to main page
                        header("location: mainpage.php");
                    }
                    // if no result then it is incorrect
                    if(mysqli_num_rows($result)==0)
                    {
                        echo "Username or password is incorrect";
                    }
                    
                }
                else 
                {
                    echo "Please enter username or password";
                }
            }
            


        ?>
    </div>
</body>
</html>