<?php
//php for all delete queries
require_once "db_connection.php";
require_once "session.php";

//When the id parameter is set
if(isset($_GET['id']))
{
    //if type is incident delete the incident
    if($_GET['type']=='incident')
    {
        $sql = "DELETE from fines 
                WHERE Incident_ID = '".$_GET['id']."';
                DELETE from incident 
                WHERE Incident_ID = '".$_GET['id']."';";
    
        $result=mysqli_multi_query($conn, $sql);
        header("location: view_incident.php");
    }
    //Person delete only for admins
    elseif($_GET['type']=='people' && $_SESSION['admin']==1)
    {
        $sql = "DELETE from people 
                WHERE People_ID = '".$_GET['id']."';";
    
        $result=mysqli_query($conn, $sql);
        //if error it is due to foreign key constraint all vehicles must be deleted
        if(mysqli_error($conn))
        {
            echo "Please make sure all this Drivers vehicles are deleted first";
            echo "<a href = 'Vehicle.php?Vehicle.php'> Vehicles </a>";
        }
        if(!mysqli_error($conn))
        {
            header("location: People.php");
        }
        
    }
    //Vehicle delete
    elseif($_GET['type']=='vehicle')
    {
        //before a vehicle is deleted all incidents, fines and ownership must be deleted
        $sql = "DELETE from fines 
                WHERE Incident_ID = (SELECT Incident_ID from incident WHERE Vehicle_ID = '".$_GET['id']."');
                DELETE from incident 
                WHERE Vehicle_ID = '".$_GET['id']."';
                DELETE from ownership 
                WHERE Vehicle_ID = '".$_GET['id']."';
                DELETE from vehicle 
                WHERE Vehicle_ID = '".$_GET['id']."';";
    
        $result=mysqli_multi_query($conn, $sql);

        echo mysqli_error($conn);
        header("location: Vehicle.php");

    }

    //if type is user delete
    elseif($_GET['type']=='user')
    {
        $sql = "DELETE from users 
                WHERE userID = '".$_GET['id']."';";
    
        $result=mysqli_query($conn, $sql);
        mysqli_error($conn);
        header("location: create_user.php");
        
    }
    // if they are not an admin and enter the url manually for person delete
    else
    {
        echo "This is not authorised";
    }

    
    
}
?>