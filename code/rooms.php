<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id']) || $_SESSION['designation']!="Admin"){
        header('location: logout.php');
    }

    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    $sql = "SELECT CURDATE()";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $from = $row['CURDATE()'];
    $to = $row['CURDATE()'];
    if(isset($_POST["submit"])){
        $from = $_POST["from"];
        $to = $_POST["to"];
    }
    $sql = "SELECT room_id FROM Rooms WHERE room_id NOT IN (SELECT DISTINCT room_id FROM Application WHERE status = 'Accepted' AND NOT (TIMESTAMPDIFF(DAY, '$from', departure_date) < 0 OR TIMESTAMPDIFF(DAY, '$to', arrival_date) > 0))";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $vacant[] = $row['room_id'];
    }
    $sql = "SELECT * FROM Rooms";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if(in_array($row['room_id'],$vacant)){
            $rooms[] = [$row['room_id'],$row['category'],'Vacant'];
        }
        else{
            $rooms[] = [$row['room_id'],$row['category'],'Occupied'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
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
                    <a class="nav-link" href="requests.php">Requests</a>
                    <a class="nav-link" href="prices.php">Prices</a>
                    <?php
                    if($user_desg=="Admin"){
                    echo'<a class="nav-link active" href="rooms.php">Rooms</a>
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
    <div class="container mt-3" style="max-width: 600px;">
        <h2 class="text-center">Rooms</h2>
        <?php
        echo '
        <form action="" method="POST">
        <tr>
            <td width="200"><b>FROM: </b></td>
            <td><input name="from" type="date" value="'.$from.'"></td>
            <td width="200"><b>TO:</b></td>
            <td><input name="to" type="date" value="'.$to.'"></td>
            <td width="200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><input name="submit" type="submit" value="Submit"></td>
        </tr>
        </form>
        <br>';
        echo "<table class='table table-hover'>";
        echo "<tr bgcolor='#D3D3D3'>";
        echo "<th scope='row'>Room No</th>";
        echo "<th scope='row'>Category</th>";
        echo "<th scope='row'>Status</th>";
        echo "</tr>";
        if(isset($rooms)){
        foreach ($rooms as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "</tr>";
        }
        }
        echo "</table>";
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>