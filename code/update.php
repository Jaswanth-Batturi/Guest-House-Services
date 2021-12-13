<?php
   require "connect.php";
   session_start();
   if(!isset($_SESSION['user_id'])){
    header('location: logout.php');
   }  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_id = mysqli_real_escape_string($db,$_POST['user_id']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT * FROM iitp_user WHERE user_id = '$user_id' and password = '$password'";
      $result = mysqli_query($db,$sql);
      $count = mysqli_num_rows($result);
      
      if($count == 1) {
         $phone = mysqli_real_escape_string($db,$_POST['phone']);
         $email = mysqli_real_escape_string($db,$_POST['email']);
         $sql = "UPDATE iitp_user SET phone = '$phone', email = '$email' WHERE user_id = '$user_id'";
         $result = mysqli_query($db,$sql);
         $status = 1;
      }
      else {
         $status = 0;
      }
   }
   $user_id = $_SESSION['user_id'];
   $user_desg = $_SESSION['designation'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body >
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
                    <a class="nav-link" href="expenditures.php">Expenditures</a>';
                    }
                    ?>
                    <a class="nav-link active" href="update.php">Update Profile</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
                &nbsp;<a href="logout.php"><button class="btn btn-dark" type="submit">Sign Out</button></a>
        </div>
    </nav>
    <br>
  <div class="container border border-3 p-3" style="background-color:#D0D0D0; max-width: 450px;">
    <div align = 'center' style = "background-color:#333333; color:#FFFFFF; padding:7px;"><h2>Update</h2></div><br>
    <?php
    if (isset($status) && $status==1) {
      echo '<div class="alert alert-success" role="alert">';
      echo '<span><i class="bi-check-circle-fill"></i></span> ';
      echo "Your details are successfully updated";
      echo '</div>';
    }
    else if (isset($status) && $status==0) {
      echo '<div class="alert alert-danger" role="alert">';
      echo '<span><i class="bi bi-exclamation-triangle-fill"></i></span> ';
      echo "Your User ID or Password is invalid";
      echo '</div>';
    }
    ?>
    <form action="" method="POST">
      <div class="form-floating mb-3">
        <input type="text" name="user_id" class="form-control" id="user_id" placeholder="user_id" required>
        <label for="user_id">User ID</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
      <div class="form-floating mb-3">
        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone" required>
        <label for="phone">New Phone No</label>
      </div>
      <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
        <label for="email">New Email</label>
      </div>
      <div class="d-grid gap-2">
        <br><button class="btn btn-primary" type="submit">Submit</button><br>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>