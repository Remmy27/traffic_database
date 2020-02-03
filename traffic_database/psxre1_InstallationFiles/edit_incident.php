<?php
    require_once "session.php";
    require_once "static.php";
?>
<head>
<title> Edit Incident </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{font: 14px sans-serif; 
                 background-color: powderblue;}
            .wrapper{ width: 800; padding: 10px; margin: 0 auto;}
            .bottom{ position:absolute; bottom:10; left: 10px;}
            .form-col { column-count: 2;}
                    
        </style>
</head>
<body>
<div class = "wrapper">
    <?php
        require_once "db_connection.php";
        if(isset($_GET['incident']))
        {
            $sql = "SELECT * from incident i
                    join people p
                    on p.People_ID = i.People_ID
                    join vehicle v
                    on v.Vehicle_ID = i.Vehicle_ID
                    join offence o 
                    on o.Offence_ID = i.Offence_ID
                    left join fines f
                    on f.Incident_ID = i.Incident_ID
                    where i.incident_ID = '".$_GET['incident']."'";
            
            $result = mysqli_query($conn, $sql);

            $row = mysqli_fetch_assoc($result);

            // form for updating the Report
            // Name of Driver
            echo "<h1> {$row['People_name']} </h1> <br>";
            echo "<form method = 'POST'>";
            echo "<div class = 'form-col'>";
            //read only inputs for Licence, Vehicle, time and date
            echo "<label> Licence </label>";
            echo "<input type='text' readonly class='form-control' value='{$row['People_licence']}'>";
            echo "<label> Vehicle </label>";
            echo "<input type='text' readonly class='form-control' value='{$row['Vehicle_type']}'> <br>";
            echo "</div>";
            echo "<label> Offence </label>";
            echo "<input type='text' readonly class='form-control' value='{$row['Offence_description']}'><br>";
            echo "<div class = 'form-col'>";
            echo "<label> Date </label>";
            echo "<input type='text' readonly class='form-control' value='{$row['Incident_Date']}'>";
            echo "<label> Time </label>";
            echo "<input type='text' readonly class='form-control' value='{$row['Time']}'><br>";
            echo "</div>";
            // if the user is an admin
            if($_SESSION['admin']==1)
            {
                //editable fine details for admin users
                echo "<div class = 'form-col'>";
                echo "<label> Fine Amount </label>";
                echo "<input type='text' class='form-control' value='{$row['Fine_Amount']}' name = 'fine_amount'>";
                echo "<label> Fine Points </label>";
                echo "<input type='text' class='form-control' value='{$row['Fine_Points']}' name = 'fine_points'><br>";
                echo "</div>";
            }
            else
            {
                //read only for non admins
                echo "<div class = 'form-col'>";
                echo "<label> Fine Amount </label>";
                echo "<input type='text' readonly class='form-control' value='{$row['Fine_Amount']}' name = 'fine_amount'>";
                echo "<label> Fine Points </label>";
                echo "<input type='text' readonly class='form-control' value='{$row['Fine_Points']}' name = 'fine_points'><br>";
                echo "</div>";
            }
            echo "<label>Report</label>
                <textarea rows = '5' name='statement' class = 'form-control'> {$row['Incident_Report']}
                </textarea><br>";
            echo "<input type = 'submit' value = 'Update' class = 'btn btn-primary'>";
            echo "<a href='view_incident.php' class = 'btn btn-primary' role = 'button'> Cancel </a>";
            echo "</form>";

            //if the statement has been posted
            if(isset($_POST['statement']))
            {
                // checking if fine has already been entered
                $sql = "Select * from fines where incident_ID = '".$_GET['incident']."';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                // if there is already a fine entered run this query
                if(mysqli_num_rows($result)==1)
                {
                    $sql = "UPDATE incident
                            SET Incident_Report = '".$_POST['statement']."'
                            WHERE Incident_ID = '".$_GET['incident']."';
                            UPDATE fines
                            SET Fine_Amount = {$_POST['fine_amount']}, Fine_Points = {$_POST['fine_points']}
                            WHERE Fine_ID = {$row['Fine_ID']}";
                
                    $result = mysqli_multi_query($conn,$sql);
                    echo mysqli_error($conn); 
                }
                else
                {
                    $sql = "UPDATE incident
                    SET Incident_Report = '".$_POST['statement']."'
                    WHERE Incident_ID = '".$_GET['incident']."';
                    Insert into fines (Fine_Amount, Fine_Points, Incident_ID)
                    VALUES
                    ({$_POST['fine_amount']},{$_POST['fine_points']},{$_GET['incident']});";

                    $result = mysqli_multi_query($conn,$sql);
                    echo mysqli_error($conn); 

                }

                

                //redirect back to view incident page 
                header("location: view_incident.php");


            }
        }

    ?>
</div>
</body>