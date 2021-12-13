<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id']) || $_SESSION['designation']!="Admin"){
        header('location: logout.php');
    }

    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    if(isset($_POST["paid"])){
        $application_id = $_POST["application_id"];
        $sql = "UPDATE payment SET pay_status = 'Paid', payment_date = CURDATE() WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
    }
    $month = date('m');
    $year = date('Y');
    if(isset($_POST["submit"])){
        $month = $_POST["month"];
        $year = $_POST["year"];
    }
    $date = "$year-$month-01";
    $from = $date;
    $sql = "SELECT LAST_DAY('$date') AS lastday";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $to = $row['lastday'];

    $sql = "SELECT * FROM Payment WHERE application_id IN (SELECT application_id FROM Application WHERE TIMESTAMPDIFF(DAY,'$from', arrival_date)  >= 0 AND TIMESTAMPDIFF(DAY,'$to', arrival_date) <= 0)";
    $result = mysqli_query($db, $sql);
    $total = 0;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $arr[] = [$row["application_id"], $row["room_bill"], $row["food_bill"], $row["room_bill"]+$row["food_bill"], $row["pay_status"],$row["payment_date"]];
        $total += $row["room_bill"]+$row["food_bill"];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
      tr.border td{
        border-bottom: 1pt solid #000000;
        border-top: 1pt solid #000000;
      }
    </style>
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
                    echo'<a class="nav-link" href="rooms.php">Rooms</a>
                    <a class="nav-link active" href="payments.php">Payments</a>
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
    <div class="container mt-3" style="max-width: 900px;">
        <h2 class="text-center">Payments</h2><br>
        <?php
        echo '
        <form action="" method="POST">
        <tr>
            <td width="200">&nbsp;</td>
            <td width="200"><b>Month(MM): </b></td>
            <td><input type="text" name="month" pattern="[0-9]{2}" value="'.$month.'"></td>
            <td width="200">&nbsp;&nbsp;&nbsp;</td>
            <td width="200"><b>Year(YYYY): </b></td>
            <td><input type="text" name="year" pattern="[0-9]{4}" value="'.$year.'"></td>
            <td width="200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><input name="submit" type="submit" value="Submit"></td>
        </tr>
        </form>
        <br>';
        echo "<table class='table table-hover'>";
        echo "<tr bgcolor='#D3D3D3'>";
        echo "<th scope='row'>Application ID</th>";
        echo "<th scope='row'>Room Bill (&#8377;)</th>";
        echo "<th scope='row'>Food Bill (&#8377;)</th>";
        echo "<th scope='row'>Total (&#8377;)</th>";
        echo "<th scope='row'>Status</th>";
        echo "<th scope='row'>Paid Date</th>";
        echo "</tr>";
        if(isset($arr)){
        foreach ($arr as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            if($row[4]=="Not Paid"){
                echo '<form action="" method="POST">
                <td><input name="application_id" type="hidden" value="'.$row[0].'" readonly></td>
                <td><input name="paid" type="submit" value="Paid"></td>
                </form>';
            }
            echo "</tr>";
        }
        }
        echo '<tr class="border">
        <td colspan="2">
        <td><b>Total Bills: </b></td>
        <td>'.$total.'</td>
        <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        </table>';
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>