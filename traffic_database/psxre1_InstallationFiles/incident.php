<?php
    require_once "session.php";
    require_once "static.php";
?>
<html>
<head>
    <title> Add Incident </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 800; padding: 10px; margin: 0 auto;}
            .form-col { column-count: 2;}
            .bottom{ position:absolute; bottom:10; left: 10px;}
                    
        </style>
</head>
<body>
    <div class = "wrapper">
        <h1> Incident Report </h1>
        <!-- Driver and Vehicle form -->
        <form method = "GET">
            <div class = "form-col">
                <label> Driver </label>
                <select  name = "driverslicence" list = "names" class = "form-control" id ="name" onchange="this.form.submit(); alert('Please select a vehicle!')">  
                    <?php 
                        require_once "db_connection.php";

                        $sql = "SELECT * FROM people;";
                        $result = mysqli_query($conn, $sql);
                        //stripping the driverslicence get value to only get the licence
                        $licence = substr($_GET['driverslicence'], 0, 16);

                        // lists the current drivers in the database
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            // if the posted licence is equal to the licence in the row it is made to be the default
                            if($licence == substr($row['People_licence'], 0, 16))
                            {
                                echo "<option selected = 'selected'>".$row['People_licence']. ': '.$row['People_name']."</option>";
                            }
                            else
                            {
                                echo "<option>".$row['People_licence']. ': '.$row['People_name']."</option>";
                            }
                        }
                    ?>
                </select>
                <p> New Driver? <a href ="adddriver.php"> Add Driver </a> </p>
                <label> Vehicle </label>
                <select  name = "vehicles" list = "vehicles" class = "form-control" id ="vehicle" onchange="this.form.submit()"> 
                    <option selected = "selected"></option>
                    <?php 

                        $licence = substr($_GET['driverslicence'], 0, 16);
                        //stripping the vehicle licence get value to only get vehicle licence
                        $vlicence = substr($_GET['vehicles'], 0, 7);

                        $sql = "SELECT * FROM vehicle v
                                join ownership o 
                                on v.Vehicle_ID = o.Vehicle_ID
                                join people p
                                on o.People_ID = p.People_ID
                                where p.People_ID = (SELECT People_ID from people where People_licence like '$licence%');";
                        $result = mysqli_query($conn, $sql);

                        // lists the current vehicles for that driver in the database
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            if($vlicence == substr($row['Vehicle_licence'], 0, 7))
                            {
                                echo "<option selected = 'selected'>".$row['Vehicle_licence']. ': '.$row['Vehicle_type']."</option>";
                            }
                            else 
                            {
                                echo "<option>".$row['Vehicle_licence']. ': '.$row['Vehicle_type']."</option>";
                            }
                            
                        }
                    ?>
                </select>
                <p> New Vehicle? <a href = "add_vehicle.php"> Add Vehicle </a> </p>
            </div>

        </form>
        <!-- Offence, date, time and statement form -->
        <form method = "POST" id = "fullform">
            <div class = "form-col">
                <label for="offence"> Offence </label>
                <select name = "offences" list = "offences" class = "form-control" id = "offence">
                    <?php
                    // Offence dropdown list
                        $sql = "SELECT * from offence;";
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<option>".$row['Offence_description']."</option>";
                        }
                        
                    ?>
                </select>
                <div class = "form-col">
                    <!-- Time and Date -->
                    <label for = "time"> Time </label>
                    <input type = "time" class = "form-control" id="time" name ="time" value="<?php echo date('H:i'); ?>">
                    <label for = "date"> Date </label>
                    <input type = "date" class = "form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <br>
            <label for = "statement">Report</label>
            <textarea rows = "5" name="statement" class = "form-control" placeholder = "Enter Statement details here...">
            </textarea><br>
            
            <?php
                // if the vehicle value has been set show post button 
                if(isset($_GET['vehicles'])&&$_GET['vehicles']!="")
                {
                    echo "<input type = 'submit' value = 'Post' class = 'btn btn-primary'>";
                }
            ?>
            <?php
                if(isset($_POST['statement']))
                {
                    $sql = "INSERT into incident (Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID, Time)
                            VALUES
                            ((SELECT Vehicle_ID from vehicle where Vehicle_licence like '$vlicence'),
                            (SELECT People_ID from people where People_licence like '$licence%'),
                            '".$_POST['date']."',
                            '".$_POST['statement']."',
                            (SELECT Offence_ID from offence where Offence_description = '".$_POST['offences']."'),
                            '".$_POST['time']."');";

                    $result = mysqli_query($conn,$sql);
                    
                    //show sql error (for testing purposes)
                    echo mysqli_error($conn);
                    echo "<br>";
                    echo "<br>";
                    echo "Statement added"; 
                }

            ?>
        </form>

    </div>

</body>