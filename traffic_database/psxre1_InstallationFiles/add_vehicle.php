<?php
    require_once "session.php";
    require_once "static.php";
?>
<html>
<head>
<title> Add Vehicle </title>
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
        <h1> Add Vehicle </h1>
        <!--Add vehicle form -->
        <form method = "POST">
            <div class = "form-group">
                <label> Driver </label>
                <select  name = "driverslicence" list = "names" class = "form-control" id ="name"> 
                    <?php 
                        require_once "db_connection.php";

                        $sql = "SELECT * FROM people;";
                        $result = mysqli_query($conn, $sql);

                        // lists the current drivers in the database
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            echo "<option>".$row['People_licence']. ': '.$row['People_name']."</option>";
                        }
                    ?>
                </select> </br>
                <p> New Driver? <a href= "adddriver.php">  Add Driver </a> </p> <br>  
                <label for = "vehicletype"> Vehicle type </label>
                <input type = "text" name = "vtype" class = 'form-control' placeholder="Vehicle type"> </br>
                <label for = "colour"> Vehicle colour </label>
                <input type = "text" name = "colour" class = 'form-control' placeholder="Vehicle Colour"> </br>
                <label for = "licence"> Vehicle Licence </label>
                <input type = "text" name = "licence" class = 'form-control' placeholder="Vehicle Licence"></br>
            </div>
            <input type = "submit" value = "Add Vehicle" class = "btn btn-primary"> <br/>
        </form>
        <?php
        // checks if data has been posted
            if(isset($_POST['driverslicence']))
            {
                // gets the first 15 characters of the licence to use for sql query
                $licence = substr($_POST['driverslicence'], 0, 14);
                
                // strips the whitespace from the vehicle licence
                $vlicence = str_replace(' ','',$_POST['licence']);
                
                //sql query to check if vehicle already exists
                $sql1 = "select * from vehicle where Vehicle_licence = '$vlicence';";
                $result = mysqli_query($conn, $sql1);
                if(mysqli_num_rows($result)>=1)
                {
                    echo "Vehicle with this registration number already exists";
                }
                else
                {

                    $sql = "INSERT into vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence)
                            VALUES ('".$_POST['vtype']."', '".$_POST['colour']."', '$vlicence')";
                            ;
                    
                            //runs sql query
                    $result = mysqli_query($conn, $sql);

                    $sql2 = "INSERT into ownership (People_ID, Vehicle_ID)
                            VALUES (
                            (SELECT People_ID from people
                            WHERE People_licence like '$licence%'), 
                            (SELECT Vehicle_ID from vehicle 
                            WHERE Vehicle_licence = '$vlicence'))";
                    
                    $result2 = mysqli_query($conn, $sql2);
                    
                    // echos the error message
                    echo mysqli_error($conn); 
                    echo "<br>";
                    
                    echo "Vehicle added <br>" ;
                }
            } 
        ?> 
        <a href ="Vehicle.php"> Vehicle database </a>
    </div>

</body>
</html