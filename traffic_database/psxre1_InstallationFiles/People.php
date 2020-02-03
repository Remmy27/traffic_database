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
    <h1> People Database </h1>
    <div>
        <form method ="GET">
                <input type="text" name="search" class="form-control"> 
                <br>
                <input type="radio" name="radio" value="Name" checked = "checked"> Search by Name
                <input type="radio" name="radio" value="Licence">Search by Licence
                <input type = "submit" value = "Submit" class = "btn btn-primary"> <br>
                
        </form>
    <script>
    function showvehicles(ID)
    {

    }
    </script>
        
    </div>
    <?php
        require_once "db_connection.php";
        
        //if the form has been submitted
        if(isset($_GET['search']))
        {
            //if there is something in search bar and the search by name button is selected
            if($_GET['search']!="" && $_GET['radio']=="Name")
            {
                $sql = "SELECT * FROM people
                        WHERE People_name LIKE '%".$_GET['search']."%'";
            }
            else
            {
                // if search by licence is selected
                if($_GET['search']!="" && $_GET['radio']=="Licence")
            {
                $sql = "SELECT * FROM people
                        WHERE People_licence LIKE '%".$_GET['search']."%'";
            }
            }
            
            $result = mysqli_query($conn, $sql);
            
            // if there are results
            if(mysqli_num_rows($result) > 0)
            {
                echo "<table class = 'table table-striped' style = 'background-color: white'>";  // start table
                echo "<tr><th>Name</th><th>Address</th><th>Driving Licence no.</th></tr>"; // table header
                while($row = mysqli_fetch_assoc($result))
                {
                    echo "<tr>";
                    echo "<td>".$row['People_name']."</td>";
                    echo "<td>".$row['People_address']."</td>";
                    echo "<td>".$row['People_licence']."</td>";
                    // link to vehicles owned by that person
                    echo "<td> <a href = \"Vehicle.php?search=$row[People_name]&radio=Driver\"> Vehicles </a></td>"; 
                    echo "<td> <a href = \"view_incident.php?driverslicence=$row[People_licence]\"> Incidents </a></td>";
                    //link to add incident report for that person
                    echo "<td> <a href = \"incident.php?driverslicence=$row[People_licence]\"> Add incident </a></td>";
                    //if admin give delete person option
                    if($_SESSION['admin']==1)
                    {
                        echo "<td><td><a onClick=\"javascript: return confirm('Are you Sure?');\" href='delete.php?id=".$row['People_ID']."&type=people'> Delete </a></td></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            else
            {
                echo "Search returned zero results </br> <a href = 'adddriver.php'> Add Driver </br>";
            }
        }
    ?>
    </div>

</body>
</html>