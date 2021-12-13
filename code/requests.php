<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location: logout.php');
    }

    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    if(isset($_POST["accept"])){
        $application_id = $_POST["application_id"];
        $sql = "UPDATE Application SET status = 'Accepted' WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
    }
    elseif(isset($_POST["reject"])){
        $application_id = $_POST["application_id"];
        $sql = "UPDATE Application SET status = 'Rejected' WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
    }
    
    if($user_desg == "Admin"){
        $sql = "SELECT * FROM Application";
    }
    else{
        $sql = "SELECT * FROM Application WHERE user_id = '$user_id'";
    }
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $arr[] = [$row['application_id'],$row['time'],$row['status']];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E90FF;">
        <div class="container-fluid">
            <img src="../pics/IITP.svg" alt="IIT Patna" width="40">&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="profile.php">Profile</a>
                    <a class="nav-link" href="application.php">Book Room</a>
                    <a class="nav-link active" href="requests.php">Requests</a>
                    <a class="nav-link" href="prices.php">Prices</a>
                    <?php
                    if($user_desg=="Admin"){
                    echo'<a class="nav-link" href="rooms.php">Rooms</a>
                    <a class="nav-link" href="payments.php">Payments</a>
                    <a class="nav-link" href="expenditures.php">Expenditures</a>';
                    }
                    ?>
                    <a class="nav-link" href="update.php">Update Profile</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
                &nbsp;<a href="logout.php"><button class="btn btn-dark" type="submit">Sign Out</button></a>
        </div>
    </nav>
    <br>
    <div class="container mt-3" style="max-width: 900px;">
        <h2 class="text-center">Applications</h2><br>
        <?php
        echo "<table class='table table-hover'>";
        echo "<tr bgcolor='#D3D3D3'>";
        echo "<th scope='row'>Application ID</th>";
        echo "<th scope='row'>Submitted Time</th>";
        echo "<th scope='row'>Status</th>";
        echo "</tr>";
        if(isset($arr)){
        foreach ($arr as $row) {
            echo '
            <tr>
            <td>
            <form id="'.$row[0].'" action="application.php" method="POST">
            <input type="hidden" name="application_id" value="'.$row[0].'" readonly>
            <input type="hidden" name="view" readonly>
            <a href="javascript:{}" style="text-decoration: none;" onclick="document.getElementById(\''.$row[0].'\').submit(); return false;"><b>'.$row[0].'</b></a>
            </td>
            </form>
            <td>'.$row[1].'</td>
            <td>'.$row[2].'</td>';
            if($user_desg=="Admin" && $row[2]=="Pending"){
            echo '
            <a href>
            <form action="" method="POST">
            <td><input name="application_id" type="hidden" value="'.$row[0].'" readonly></td>
            <td><input name="accept" class="btn btn-success" type="submit" value="Accept"></td>
            <td><input name="reject" class="btn btn-danger"  type="submit" value="Reject"></td>
            </form>';
            }
            echo '</tr>';
        }
        }
        ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>