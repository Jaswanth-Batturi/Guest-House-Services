<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id']) || $_SESSION['designation']!="Admin"){
        header('location: logout.php');
    }

    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    if(isset($_POST["update"])){
        $category = $_POST["category"];
        $date = $_POST["date"];
        $amount = $_POST["amount"];
        $sql = "INSERT INTO expenditure VALUES('$category','$date','$amount')";
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

    $sql = "SELECT * FROM expenditure WHERE TIMESTAMPDIFF(DAY,'$from', dt)  >= 0 AND TIMESTAMPDIFF(DAY,'$to', dt) <= 0";
    $result = mysqli_query($db, $sql);
    $total = 0;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $arr[] = [$row["category"], $row["dt"], $row["amount"]];
        $total += $row["amount"];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
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
                    <a class="nav-link" href="payments.php">Payments</a>
                    <a class="nav-link active" href="expenditures.php">Expenditures</a>';
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
    <div class="container mt-3" style="max-width: 700px;">
        <h2 class="text-center">Expenditures</h2><br>
        <?php
        echo '
        <form action="" method="POST">
        <tr>
            <td width="200"><b>Month(MM): </b></td>
            <td><input type="text" name="month" pattern="[0-9]{2}" value="'.$month.'"></td>
            <td width="200"><b>Year(YYYY): </b></td>
            <td><input type="text" name="year" pattern="[0-9]{4}" value="'.$year.'"></td>
            <td><input name="submit" type="submit" value="Submit"></td>
        </tr>
        </form>
        <br>';
        echo "<table class='table table-hover'>";
        echo "<tr bgcolor='#D3D3D3'>";
        echo "<th scope='row'>Category</th>";
        echo "<th scope='row'>Date (YYYY-MM-DD)</th>";
        echo "<th scope='row'>Amount (&#8377;)</th>";
        echo "</tr>";
        if(isset($arr)){
            foreach ($arr as $row) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "</tr>";
            }
        }
        echo '<tr class="border">
        <td colspan="1">
        <td><b>Total Bills: </b></td>
        <td>'.$total.'</td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td colspan="3"style="color: #fff; background: #75C5DF; text-align: center"><b>Fill New Expenditure</b><strong></strong></td>
        </tr>
        <form action="" method="POST">
        <tr>
            <td width="200">Category: </td>
            <td><input name="category" type="text" required></td>
        </tr>
        <tr>
            <td width="200">Date: </td>
            <td><input name="date" type="date" required></td>
        </tr>
        <tr>
            <td width="200">Amount: </td>
            <td><input name="amount" type="number" required></td>
        </tr>
        </table>
        <div align = "center"><input style="background-color:#C6C6C6" name="update" type="submit" value="Update"></div>
        </form>';
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>