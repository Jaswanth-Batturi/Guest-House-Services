<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location: logout.php');
    }
    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];

    $sql = "SELECT * FROM room_rent";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    if($count==0){
        $sql = "INSERT INTO room_rent VALUES('Attached Bathroom',0),('Non Attached Bathroom',0)";
        $result = mysqli_query($db, $sql);
    }
    $sql = "SELECT * FROM food_price";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    if($count==0){
        $sql = "INSERT INTO food_price VALUES(0,0,0,0,0,0)";
        $result = mysqli_query($db, $sql);
    }
    if(isset($_POST["submit"])){
        $attached = $_POST["attached"];
        $non_attached = $_POST["non_attached"];
        $sql = "UPDATE room_rent SET rent = '$attached' WHERE category = 'Attached Bathroom'";
        $result = mysqli_query($db, $sql);
        $sql = "UPDATE room_rent SET rent = '$non_attached' WHERE category = 'Non Attached Bathroom'";
        $result = mysqli_query($db, $sql);
        $v_bf = $_POST["v_bf"];
        $v_lh = $_POST["v_lh"];
        $v_dn = $_POST["v_dn"];
        $nv_bf = $_POST["nv_bf"];
        $nv_lh = $_POST["nv_lh"];
        $nv_dn = $_POST["nv_dn"];
        $sql = "UPDATE food_price SET veg_bf = '$v_bf',veg_lh = '$v_lh',veg_dn = '$v_dn',non_veg_bf = '$nv_bf',non_veg_lh = '$nv_lh',non_veg_dn = '$nv_dn'";
        $result = mysqli_query($db, $sql);
    }

    $sql = "SELECT * FROM room_rent";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if($row["category"]=="Attached Bathroom"){
            $attached = $row["rent"];
        }
        else if($row["category"]=="Non Attached Bathroom"){
            $non_attached = $row["rent"];
        }
    }
    
    $sql = "SELECT * FROM food_price";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $v_bf = $row["veg_bf"];
    $v_lh = $row["veg_lh"];
    $v_dn = $row["veg_dn"];
    $nv_bf = $row["non_veg_bf"];
    $nv_lh = $row["non_veg_lh"];
    $nv_dn = $row["non_veg_dn"];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        input[readonly] {
        background-color: #DCDCDC;
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
                    <a class="nav-link active" href="prices.php">Prices</a>
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
    <div class="container border border-3 p-3" style="background-color:; max-width: 800px;">
    <form action="" method="POST">
    <table width="50%" align="center" cellpadding="3" cellspacing="3" border="0">
    <tbody>
    <?php
        if(!isset($_POST['update'])){
        echo '
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: center"><strong>Room Rent Per Day (&#8377;)</strong></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td width="200">Attached Bathroom</td>
            <td><input name="attached" type="int" value="'.$attached.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Non Attached Bathroom</td>
            <td><input name="non_attached" type="int" value="'.$non_attached.'"readonly></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: center"><strong>Food Prices (&#8377;)</strong></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td width="200">Veg Breakfast</td>
            <td><input name="v_bf" type="int" value="'.$v_bf.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Veg Lunch</td>
            <td><input name="v_lh" type="int" value="'.$v_lh.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Veg Dinner</td>
            <td><input name="v_dn" type="int" value="'.$v_dn.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Non Veg Breakfast</td>
            <td><input name="nv_bf" type="int" value="'.$nv_bf.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Non Veg Lunch</td>
            <td><input name="nv_lh" type="int" value="'.$nv_lh.'"readonly></td>
        </tr>
        <tr>
            <td width="200">Non Veg Dinner</td>
            <td><input name="nv_dn" type="int" value="'.$nv_dn.'"readonly></td>
        </tr>';
        }
        else{
        echo '
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: center"><strong>Room Rent Per Day (&#8377;)</strong></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td width="200">Attached Bathroom</td>
            <td><input name="attached" type="int" value="'.$attached.'"></td>
        </tr>
        <tr>
            <td width="200">Non Attached Bathroom</td>
            <td><input name="non_attached" type="int" value="'.$non_attached.'"></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: center"><strong>Food Prices (&#8377;)</strong></td>
        </tr>
        <td>&nbsp;&nbsp;</td>
        <tr>
            <td width="200">Veg Breakfast</td>
            <td><input name="v_bf" type="int" value="'.$v_bf.'"></td>
        </tr>
        <tr>
            <td width="200">Veg Lunch</td>
            <td><input name="v_lh" type="int" value="'.$v_lh.'"></td>
        </tr>
        <tr>
            <td width="200">Veg Dinner</td>
            <td><input name="v_dn" type="int" value="'.$v_dn.'"></td>
        </tr>
        <tr>
            <td width="200">Non Veg Breakfast</td>
            <td><input name="nv_bf" type="int" value="'.$nv_bf.'"></td>
        </tr>
        <tr>
            <td width="200">Non Veg Lunch</td>
            <td><input name="nv_lh" type="int" value="'.$nv_lh.'"></td>
        </tr>
        <tr>
            <td width="200">Non Veg Dinner</td>
            <td><input name="nv_dn" type="int" value="'.$nv_dn.'"></td>
        </tr>';
        }
        ?>
        </tbody>
        </table>
        <br><br>
        <?php
        if($user_desg=="Admin"){
            if(!isset($_POST['update'])){
            echo '
            <div align = "center" ><input style="background-color:#C6C6C6" name="update" type="submit" value="Update"></div>';
            }
            else{
            echo '
            <div align = "center"><input style="background-color:#C6C6C6" name="submit" type="submit" value="Submit"></div>';
            }
        }
        ?>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>