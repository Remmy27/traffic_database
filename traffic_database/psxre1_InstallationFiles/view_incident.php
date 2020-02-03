<?php
    require_once "session.php";
    require_once "static.php";
?>
<head>
<title> Incidents </title>
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
        <h1> Search by driver</h1>
        <!-- Driver and Vehicle form -->
        <form method = "GET">
            <label> Driver </label>
            <select  name = "driverslicence" list = "names" class = "form-control" id ="name" onchange="this.form.submit()">  
                <?php 
                    require_once "db_connection.php";

                    $sql = "SELECT * FROM people;";
                    $result = mysqli_query($conn, $sql);
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
            <br>
        <?php
        if(isset($_GET['driverslicence']))
        {
            //stripping the string containing name and licence to just get licence
            $licence = substr($_GET['driverslicence'],0 , 16);
            $sql = "SELECT *, i.Incident_ID as incident from incident i
                    join people p
                    on p.People_ID = i.People_ID
                    join vehicle v
                    on v.Vehicle_ID = i.Vehicle_ID
                    join offence o 
                    on o.Offence_ID = i.Offence_ID
                    left join fines f
                    on f.Incident_ID = i.Incident_ID
                    where People_licence like '$licence%';";
            
            $result = mysqli_query($conn, $sql);
            echo mysqli_error($conn);
            if(mysqli_num_rows($result)!=0)
            {

                echo "<table class = 'table table-striped' style = 'background-color: white'>";
                echo "<tr> 
                        <th> Name </th>
                        <th> Vehicle </th>
                        <th> Licence </th>
                        <th> Offence </th>
                        <th> Date </th>
                        <th> Report </th>
                        <th> Fine amount </th>
                        <th> Fine Points </th>
                    </tr>";
                while($row = mysqli_fetch_assoc($result))
                {
                    echo "<tr>";
                    echo "<td><a href = 'People.php?search={$row['People_name']}&radio=Name'>".$row['People_name']."</a></td>";
                    echo "<td>".$row['Vehicle_type']."</td>";
                    echo "<td>".$row['Vehicle_licence']."</td>";
                    echo "<td>".$row['Offence_description']."</td>";
                    echo "<td>".$row['Incident_Date']."</td>";
                    echo "<td>".$row['Incident_Report']."</td>";
                    echo "<td>".$row['Fine_Amount']."</td>";
                    echo "<td>".$row['Fine_Points']."</td>";
                    echo "<td>".$row['incident']."</td>";
                    

                    //delete button asks user for confirmation then redirects to delete file
                    echo "<td><td><a onClick=\"javascript: return confirm('Are you Sure?');\" href='delete.php?id={$row['incident']}&type=incident'> Delete </a></td></td>";
                    echo "<td> <a href= \"edit_incident.php?incident={$row['incident']}\"> Edit </a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>";
                echo "<a href = 'incident.php?driverslicence=$licence'> Add incident </a>";

            }
            else
            {
                echo "There are no incidents ";
                echo "<a href = 'incident.php?driverslicence=$licence'> Add incident </a>";
            }
            
            
        }


        ?>
        
</body>