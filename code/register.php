<?php
   require "connect.php";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_id = mysqli_real_escape_string($db,$_POST['user_id']);
      
      $sql = "SELECT * FROM iitp_user WHERE user_id = '$user_id'";
      $result = mysqli_query($db,$sql);
      $count = mysqli_num_rows($result);
		
      if($count == 0) {
         $password = mysqli_real_escape_string($db,$_POST['password']);
         $name = mysqli_real_escape_string($db,$_POST['name']);
         $designation = mysqli_real_escape_string($db,$_POST['designation']);
         $department = mysqli_real_escape_string($db,$_POST['department']);
         $phone = mysqli_real_escape_string($db,$_POST['phone']);
         $email = mysqli_real_escape_string($db,$_POST['email']);
         $sql = "INSERT INTO iitp_user VALUES('$user_id','$password','$name','$designation','$department','$phone','$email')";
         $result = mysqli_query($db,$sql);
         $status = 1;
      }
      else {
         $status = 0;
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <style>
  body {
    height: 110vh;
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
  }
  </style>

</head>

<body class="d-flex justify-content-center align-items-center">
  <div class="container border border-3 p-3" style="background-color:#D0D0D0; max-width: 600px;">
    <div align = 'center' style = "background-color:#333333; color:#FFFFFF; padding:4px;"><h2>Register</h2></div><br>
    <?php
    if (isset($status) && $status==1) {
      echo '<div class="alert alert-success" role="alert">';
      echo '<span><i class="bi-check-circle-fill"></i></span> ';
      echo "Registration is Successful";
      echo '</div>';
    }
    else if (isset($status) && $status==0) {
      echo '<div class="alert alert-danger" role="alert">';
      echo '<span><i class="bi bi-exclamation-triangle-fill"></i></span> ';
      echo "User ID already exists.";
      echo '</div>';
    }
    ?>
    <form action="" method="POST">
      <div class="form-floating mb-3">
        <input type="text" name="user_id" class="form-control" id="user_id" placeholder="User ID" required>
        <label for="user_id">User ID</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
        <label for="name">Name</label>
      </div>
      <div class="form-floating mb-3">
        <select name="designation" class="form-select" id="designation" placeholder="designation" required>
                    <option value="">Designation</option>
                    <option>Student</option>
                    <option>Faculty</option>
        </select>
        <label for="department">Designation</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" name="department" class="form-control" id="department" placeholder="department" required>
        <label for="department">Department</label>
      </div>
      <div class="form-floating mb-3">
        <input type="tel" name="phone" class="form-control" id="phone" placeholder="phone" required>
        <label for="phone">Phone No</label>
      </div>
      <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
        <label for="email">Email</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="submit">Sign Up</button><br>
      </div>
    </form>
    Already have an account?&nbsp;<a href="login.php">Login here</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>