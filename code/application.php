<?php
    include("connect.php");
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location: logout.php');
    }
    
    $user_id = $_SESSION['user_id'];
    $user_desg = $_SESSION['designation'];
    
    if(isset($_POST['submit']) || isset($_POST['print'])){
        $accom = mysqli_real_escape_string($db, $_POST["accom"]);
        $arrival = mysqli_real_escape_string($db, $_POST["arrival"]);
        $departure = mysqli_real_escape_string($db, $_POST["departure"]);
        $nog = (int)mysqli_real_escape_string($db, $_POST["nog"]);
        $pov = mysqli_real_escape_string($db, $_POST["pov"]);
        $payment = mysqli_real_escape_string($db, $_POST["payment"]);
        if(isset($_POST['print'])){
            $application_id = $_POST["application_id"];
        }
        if(isset($_POST['submit'])){
            $sql = "SELECT * FROM Application";
            $result = mysqli_query($db,$sql);
            $count = mysqli_num_rows($result);
            $application_id = sprintf('%04d', $count+1);
            $sql = "INSERT INTO Application VALUES('$application_id','$user_id','$nog','Pending','$accom',NULL,'$arrival','$departure','$pov','$payment',CURRENT_TIMESTAMP)";
            $result = mysqli_query($db,$sql);
        }

        $name_1 = mysqli_real_escape_string($db, $_POST["name_1"]);
        $desi_1 = mysqli_real_escape_string($db, $_POST["desi_1"]);
        $phone_1 = mysqli_real_escape_string($db, $_POST["phone_1"]);
        $email_1 = mysqli_real_escape_string($db, $_POST["email_1"]);
        $street_1 = mysqli_real_escape_string($db, $_POST["street_1"]);
        $city_1 = mysqli_real_escape_string($db, $_POST["city_1"]);
        $state_1 = mysqli_real_escape_string($db, $_POST["state_1"]);
        $pin_1 = mysqli_real_escape_string($db, $_POST["pin_1"]);
        if(isset($_POST['submit'])){
            $sql = "SELECT * FROM guest_details";
            $result = mysqli_query($db,$sql);
            $count = mysqli_num_rows($result);
            $guest_id = sprintf('%04d', $count+1);
            $sql = "INSERT INTO guest_details VALUES('$application_id','$guest_id','$name_1','$desi_1','$phone_1','$email_1','$street_1','$city_1','$state_1','$pin_1')";
            $result = mysqli_query($db,$sql);
        }
        $name_2 = $desi_2 = $phone_2 = $email_2 = $street_2 = $city_2 = $state_2 = $pin_2= "";
        if($nog==2){
            $name_2 = mysqli_real_escape_string($db, $_POST["name_2"]);
            $desi_2 = mysqli_real_escape_string($db, $_POST["desi_2"]);
            $phone_2 = mysqli_real_escape_string($db, $_POST["phone_2"]);
            $email_2 = mysqli_real_escape_string($db, $_POST["email_2"]);
            $street_2 = mysqli_real_escape_string($db, $_POST["street_2"]);
            $city_2 = mysqli_real_escape_string($db, $_POST["city_2"]);
            $state_2 = mysqli_real_escape_string($db, $_POST["state_2"]);
            $pin_2 = mysqli_real_escape_string($db, $_POST["pin_2"]);
            if(isset($_POST['submit'])){
                $guest_id = sprintf('%04d', $count+2);
                $sql = "INSERT INTO guest_details VALUES('$application_id','$guest_id','$name_2','$desi_2','$phone_2','$email_2','$street_2','$city_2','$state_2','$pin_2')";
                $result = mysqli_query($db,$sql);
            }
        }
    
        $v_bf = (int)mysqli_real_escape_string($db, $_POST["v_bf"]);
        $v_lh = (int)mysqli_real_escape_string($db, $_POST["v_lh"]);
        $v_dn = (int)mysqli_real_escape_string($db, $_POST["v_dn"]);
        $nv_bf = (int)mysqli_real_escape_string($db, $_POST["nv_bf"]);
        $nv_lh = (int)mysqli_real_escape_string($db, $_POST["nv_lh"]);
        $nv_dn = (int)mysqli_real_escape_string($db, $_POST["nv_dn"]);
        if(isset($_POST['submit'])){
            $sql = "INSERT INTO food_order VALUES('$application_id', '$v_bf', '$nv_bf', '$v_lh', '$nv_lh', '$v_dn', '$nv_dn')";
            $result = mysqli_query($db, $sql);
        }
    }
    elseif(isset($_POST["view"])){
        $application_id = $_POST["application_id"];
        $sql = "SELECT * FROM Application WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $nog = $row["no_of_guests"];
        $accom = $row["category"];
        if($row["status"]=="Accepted"){
            $room_no = $row["room_id"];
        }
        $arrival = $row["arrival_date"];
        $departure = $row["departure_date"];
        $pov = $row["purpose"];
        $payment = $row["payment_by"];
        $sql = "SELECT * FROM guest_details WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $name_1 = $row["guest_name"];
        $desi_1 = $row["guest_desg"];
        $phone_1 = $row["guest_ph"];
        $email_1 = $row["email"];
        $street_1 = $row["flat_street_no"];
        $city_1 = $row["city"];
        $state_1 = $row["state"];
        $pin_1 = $row["pincode"];
        $name_2 = $desi_2 = $phone_2 = $email_2 = $street_2 = $city_2 = $state_2 = $pin_2= "";
        if($nog==2){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $name_2 = $row["guest_name"];
            $desi_2 = $row["guest_desg"];
            $phone_2 = $row["guest_ph"];
            $email_2 = $row["email"];
            $street_2 = $row["flat_street_no"];
            $city_2 = $row["city"];
            $state_2 = $row["state"];
            $pin_2 = $row["pincode"];
        }
        $sql = "SELECT * FROM food_order WHERE application_id = '$application_id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $v_bf = $row["veg_bf"];
        $v_lh = $row["veg_lh"];
        $v_dn = $row["veg_dn"];
        $nv_bf = $row["non_veg_bf"];
        $nv_lh = $row["non_veg_lh"];
        $nv_dn = $row["non_veg_dn"];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
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
                    <a class="nav-link active" href="application.php">Book Room</a>
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
    <div class="container border border-3 p-3" style="background-color:#EADDCA; max-width: 880px;">
    <form action="" method="POST">
    <table width="100%" align="center" cellpadding="3" cellspacing="3" border="0">
    <tbody>
    <?php
        if(!(isset($_POST['submit']) || isset($_POST['print']) || isset($_POST['view']))){
        echo '
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Guest Information</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        
        <tr>
            <td width="200">Guest 1 Name: </td>
            <td><input name="name_1" type="text" required></td>
            <td width="200">Guest 2 Name:</td>
            <td><input name="name_2" type="text" ></td>
        </tr>
        <tr>
            <td width="200">Designation:</td>
            <td><input name="desi_1" type="text" required></td>
            <td width="200">Designation:</td>
            <td><input name="desi_2" type="text"></td>
        </tr>
        <tr>
            <td width="200">Phone Number:</td>
            <td><input name="phone_1" type="tel" required></td>
            <td width="200">Phone Number:</td>
            <td><input name="phone_2" type="tel"></td>
      
        </tr>
        <tr>
            <td width="200">Email:</td>
            <td><input name="email_1" type="email"  required></td>
            <td width="200">Email:</td>
            <td><input name="email_2" type="email"></td>
        </tr>
        <tr>
            <td width="200">Flat/Street No:</td>
            <td><input name="street_1" type="text" required></td>
            <td width="200">Flat/Street No:</td>
            <td><input name="street_2" type="text"></td>
        </tr>
        <tr>
        <td width="200">City:</td>
            <td><input name="city_1" type="text"  required></td>
            <td width="200">City:</td>
            <td><input name="city_2" type="text"></td>
        </tr>
        <tr>
            <td width="200">State:</td>
            <td><input name="state_1" type="text" required></td>
            <td width="200">State:</td>
            <td><input name="state_2" type="text"></td>
        </tr>
        <tr>
            <td width="200">Pincode:</td>
            <td><input name="pin_1" type="text" required></td>
            <td width="200">Pincode:</td>
            <td><input name="pin_2" type="text"></td>
        </tr>
        <tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        </tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Details</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td>No. of Guests:</td>
            <td>
                <select name="nog" required>
                    <option value="">Please choose an option</option>
                    <option>1</option>
                    <option>2</option>
                </select>
            </td>
            <td width="200">Accomodation Type:</td>
            <td>
                <select name="accom" required>
                    <option value="">Please choose an option</option>
                    <option>Attached Bathroom</option>
                    <option>Non Attached Bathroom</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="200">Date of Arrival:</td>
            <td><input name="arrival" type="date" required></td>
            <td width="200"> Date of Departure:</td>
            <td><input name="departure" type="date" required></td>
        </tr>
        <tr>
            <td>Purpose of visit:</td>
            <td>
                <select name="pov" required>
                    <option value="">Please choose an option</option>
                    <option>Official</option>
                    <option>Personal</option>
                </select>
            </td>
            <td width="200">Payment by:</td>
            <td>
                <select name="payment" required>
                    <option value="">Please choose an option</option>
                    <option>Institute</option>
                    <option>Project Fund</option>
                    <option>Indentor</option>
                    <option>Guest</option>
                </select>
            </td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Food Details</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <tr align="left">
     	    <th>Food Type</th>
     	    <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
        </tr>
        <tr>
      	    <td>Vegitarian Food:</td>
            <td><input name="v_bf" type="number"></td>
		    <td><input name="v_lh" type="number"></td>
      	    <td><input name="v_dn" type="number"></td>
        </tr>
		<tr>
        	<td>Non-Vegitarian Food:</td>
            <td><input name="nv_bf" type="number"></td>
		    <td><input name="nv_lh" type="number"></td>
      	    <td><input name="nv_dn" type="number"></td>
        </tr>';
        }
        else{
        echo '
        <h2 align="center">Successfully submitted<h2>
        <tr>
            <td width="200"><b>Application ID: </b></td>
            <td><input name="application_id" type="text" value="'.$application_id.'" readonly></td>';
            if(isset($room_no)){
                echo '
                <td width="200"><b>Room No: </b></td>
                <td><input name="room_no" type="text" value="'.$room_no.'" readonly></td>';
            }
        echo'</tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Guest Information</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <tr>
            <td width="200">Guest 1 Name: </td>
            <td><input name="name_1" type="text" value="'.$name_1.'" readonly></td>
            <td width="200">Guest 2 Name:</td>
            <td><input name="name_2" type="text" value="'.$name_2.'" readonly></td>
        </tr>
        <tr>
            <td width="200">Designation:</td>
            <td><input name="desi_1" type="text" value="'.$desi_1.'" readonly></td>
            <td width="200">Designation:</td>
            <td><input name="desi_2" type="text" value="'.$desi_2.'" readonly></td>
        </tr>
        <tr>
            <td width="200">Phone Number:</td>
            <td><input name="phone_1" type="tel" value="'.$phone_1.'" readonly></td>
            <td width="200">Phone Number:</td>
            <td><input name="phone_2" type="tel" value="'.$phone_2.'" readonly></td>
      
        </tr>
        <tr>
            <td width="200">Email:</td>
            <td><input name="email_1" type="email" value="'.$email_1.'" readonly></td>
            <td width="200">Email:</td>
            <td><input name="email_2" type="email" value="'.$email_2.'" readonly></td>
        </tr>
        <tr>
            <td width="200">Flat/Street No:</td>
            <td><input name="street_1" type="text" value="'.$street_1.'" readonly></td>
            <td width="200">Flat/Street No:</td>
            <td><input name="street_2" type="text" value="'.$street_2.'" readonly></td>
        </tr>
        <tr>
        <td width="200">City:</td>
            <td><input name="city_1" type="text" value="'.$city_1.'" readonly></td>
            <td width="200">City:</td>
            <td><input name="city_2" type="text" value="'.$city_2.'" readonly></td>
        </tr>
        <tr>
            <td width="200">State:</td>
            <td><input name="state_1" type="text" value="'.$state_1.'" readonly></td>
            <td width="200">State:</td>
            <td><input name="state_2" type="text" value="'.$state_2.'" readonly></td>
        </tr>
        <tr>
            <td width="200">Pincode:</td>
            <td><input name="pin_1" type="text" value="'.$pin_1.'" readonly></td>
            <td width="200">Pincode:</td>
            <td><input name="pin_2" type="text" value="'.$pin_2.'" readonly></td>
        </tr>
        <tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        </tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Details</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td>No. of Guests:</td>
            <td><input name="nog" type="text" value="'.$nog.'" readonly></td>
            <td width="200">Accomodation Type:</td>
            <td><input name="accom" type="text" value="'.$accom.'" readonly></td>
        </tr>
        <tr>
            <td width="200">Date of Arrival:</td>
            <td><input name="arrival" type="date" value="'.$arrival.'" readonly></td>
            <td width="200"> Date of Departure:</td>
            <td><input name="departure" type="date" value="'.$departure.'" readonly></td>
        </tr>
        <tr>
            <td>Purpose of visit:</td>
            <td><input name="pov" type="text" value="'.$pov.'" readonly></td>
            <td width="200">Payment by:</td>
            <td><input name="payment" type="text" value="'.$payment.'" readonly></td>
        </tr> 
        <!-- <tr>
            <td>
                <div id="pov1" style="display:none;">
                    <label for="POV">Describe Official Purpose</label>
                    <input type="text" name="pov_data" placeholder="Describe Official Purpose">
                </div>
                <div id="pov2" style="display:none;">
                    <label for="POV">Describe Personal relation</label>
                    <input type="text" name="pov_data" placeholder="Describe Personal Relation">
                </div>
                <script>
	                $("#pov").on("change",function(){
                        if( $(this).val()==="Official"){
                            $("#pov1").show()
		                    $("#pov2").hide()
                        }
                        else{
                            $("#pov2").show()
                            $("#pov1").hide()
                        }
                    });
	            </script>
            </td>
        </tr>
        <tr>  
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
            <div id="pco" style="display:none;">
                <label for="PCN">Project Code Number</label>
                <input type="text" name="pco_data" placeholder="Enter Project Code Number">
            </div>
            <script>
	            $("#payment_mode").on("change",function(){
                    if( $(this).val()==="Project_Fund"){
                        $("#pco").show()
                    }
                    else{
                        $("#pco").hide()
                    }
                });
	        </script>
            </td>
        </tr>  -->
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Food Details</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <tr align="left">
     	    <th>Food Type</th>
     	    <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
        </tr>
        <tr>
      	    <td>Vegitarian Food:</td>
            <td><input name="v_bf" type="number" value="'.$v_bf.'" readonly></td>
		    <td><input name="v_lh" type="number" value="'.$v_lh.'" readonly></td>
      	    <td><input name="v_dn" type="number" value="'.$v_dn.'" readonly></td>
        </tr>
		<tr>
        	<td>Non-Vegitarian Food:</td>
            <td><input name="nv_bf" type="number" value="'.$nv_bf.'" readonly></td>
		    <td><input name="nv_lh" type="number" value="'.$nv_lh.'" readonly></td>
      	    <td><input name="nv_dn" type="number" value="'.$nv_dn.'" readonly></td>
        </tr>';
        }
        ?>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <tr>
            <td colspan="2" style="color: #fff; background: #75C5DF; text-align: left"><strong>Indentor Information</strong></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>
        <?php
        echo '
        <tr>
            <td>Emp. Id:</td>
            <td><input name="i_emp_id" type="text" value="'.$_SESSION["user_id"].'" readonly></td>
            <td width="200">Indentor Name:</td>
            <td><input name="i_name" type="text" value="'.$_SESSION["name"].'" readonly></td>
        </tr>
        <tr>
            <td>Designation:</td>
            <td><input name="i_desi" type="text" value="'.$_SESSION["designation"].'" readonly></td>
            <td width="200">Department:</td>
            <td><input name="i_dept" type="text" value="'.$_SESSION["department"].'" readonly></td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td><input name="i_phone" type="tel" value="'.$_SESSION["phone"].'" readonly></td>
            <td width="200">Email:</td>
            <td><input name="i_email" type="email" value="'.$_SESSION["email"].'" readonly></td>
        </tr>';
        if(isset($_POST['submit'])||isset($_POST['print'])||isset($_POST['view'])){
        echo '
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Signature of the concerned HOD/HOS <br>
            (in case the purpose of visit is official)</td>
            <td colspan="2">Signature of the Indentor with Date</td>
        </tr>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Approval of the Registrar</td>
            <td colspan="2">Signature of Incharge Guest House with Date</td>
        </tr>
        </tbody>
        </table>
        <br><br>
        <div align = "center"><input type="button" onclick="window.print();return false;" value="Print"></div>';
        }
        else{
        echo '
        </tbody>
        </table>
        <br><br>
        <div align = "center"><input name="submit" type="submit" value="Submit"></div>
        ';
        }
        ?>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>