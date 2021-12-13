<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location: logout.php');
    }

    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    $sql = "SELECT user_id as 'User ID',name as 'Name',designation as 'Designation',department as 'Department',phone as 'Phone No',email as 'Email' FROM iitp_user WHERE user_id = '$user_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $keys = array_keys($row);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                    <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
                    <a class="nav-link" href="application.php">Book Room</a>
                    <a class="nav-link" href="requests.php">Requests</a>
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
    <div class="container mt-3" style="background-color:; max-width: 800px;">
        <h2 class="text-center">Profile</h2><br>
        <?php
        echo "<table class='table table-hover' bgcolor='#D3D3D3'>";
        foreach ($keys as $key) {
            echo "<tr>";
            echo "<th scope='row'>$key</th>";
            echo "<td>$row[$key]</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>