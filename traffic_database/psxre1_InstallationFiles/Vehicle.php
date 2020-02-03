<?php
    require_once "session.php";
    require_once "static.php";
?>
<html>
<head>
<title> Vehicles </title>
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
        <h1> Vehicle Database </h1>
            <form method ="GET">
                    <input type="text" name="search" class="form-control" placeholder = "Enter Vehicle details"> 
                    <br>
                    <input type="radio" name="radio" value="Licence" checked = "checked"> Search by Licence
                    <input type="radio" name="radio" value="Driver" > Search by Driver
                    <input type = "submit" value = "Submit" class = "btn btn-primary"> <br>
            </form>
    <?php
        
        require_once "db_connection.php";
        // if the text in the search bar has been posted
        if(isset($_GET['search']))
        {
            // if the licence radio button has been selected search by licence
            if($_GET["search"]!="" && $_GET['radio']=='Licence')
            {   
                $sql = "SELECT v.Vehicle_type, v.Vehicle_colour, v.Vehicle_licence, p.People_name, p.People_address, p.People_licence, v.Vehicle_ID as ID 
                from vehicle v 
                left join ownership o 
                on v.Vehicle_ID = o.vehicle_ID
                join people p 
                on p.People_ID = o.People_ID
                where v.Vehicle_licence like '%".$_GET['search']."%'";
            }
            else
            {
                // if the driver radio button has been selected search by driver
                if($_GET["search"]!="" && $_GET['radio']=='Driver')
                {
                    $sql = "SELECT v.Vehicle_type, v.Vehicle_colour, v.Vehicle_licence, p.People_name, p.People_address, p.People_licence, v.Vehicle_ID as ID 
                            from vehicle v 
                            left join ownership o 
                            on v.Vehicle_ID = o.vehicle_ID
                            join people p 
                            on p.People_ID = o.People_ID
                            where p.People_Name like '%".$_GET['search']."%'";
                }
            }
            
            $result = mysqli_query($conn, $sql);

            // if a result is returned show table
            if(mysqli_num_rows($result) > 0)
            {
                echo "<table class = 'table table-striped' style = 'background-color: white'>";  // start table
                //table headers
                echo "<tr>
                    <th>Vehicle type</th>
                    <th>Colour</th>
                    <th>Vehicle licence</th>
                    <th>Driver name</th>
                    <th>Driver address</th>
                    <th>Drivers licence no.</th>
                    </tr>"; 
                while($row = mysqli_fetch_assoc($result))
                {
                    // table rows
                    echo "<tr>";
                    echo "<td>".$row['Vehicle_type']."</td>";
                    echo "<td>".$row['Vehicle_colour']."</td>";
                    echo "<td>".$row['Vehicle_licence']."</td>";
                    echo "<td><a href = 'People.php?search={$row['People_name']}&radio=Name'>".$row['People_name']."</a></td>";
                    echo "<td>".$row['People_address']."</td>";
                    echo "<td>".$row['People_licence']."</td>";
                    echo "<td><td><a onClick=\"javascript: return confirm('This would also delete all incidents and relating to this vehicle. Are you Sure?');\" href='delete.php?id={$row['ID']}&type=vehicle'> Delete </a></td></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            else
            {
                echo "Search returned zero results </br>";
            }
        }
    ?>
    <a href = "add_vehicle.php"> Add New Vehicle </a> </br>
    </div>
</body>
</html>
