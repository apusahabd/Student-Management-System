<?php 
	session_start();
	if($_SESSION['logged_in']!=1){
		header("Location:login.php");
	}
	$err_msg['name'] = $err_msg['f_name'] = $err_msg['m_name'] = $err_msg['roll'] = $err_msg['email'] = $err_msg['dob'] = $err_msg['gender'] = $err_msg['religion'] = $err_msg['phone'] = $err_msg['district'] = $err_msg['address'] = $err_msg['image'] = $submit_msg ="";
	$name=$f_name=$m_name=$roll=$email=$dob=$gender=$religion=$phone=$district=$address=$image="";
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(empty($_POST["name"])){
		   $err_msg['name'] = "Name is required";
		}else{
			$name = valitation($_POST["name"]);
			// check if name only contains letters
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			  $err_msg['name'] = "Only letters allowed"; 
			}
		}
		if(empty($_POST["f_name"])){
		   $err_msg['f_name'] = "Father's Name is required";
		}else{
			$f_name = valitation($_POST["f_name"]);
			// check if name only contains letters
			if (!preg_match("/^[a-zA-Z ]*$/",$f_name)) {
			  $err_msg['f_name'] = "Only letters allowed"; 
			}
		}
		if(empty($_POST["m_name"])){
		   $err_msg['m_name'] = "Mother's Name is required";
		}else{
			$m_name = valitation($_POST["m_name"]);
			// check if name only contains letters
			if (!preg_match("/^[a-zA-Z ]*$/",$m_name)) {
			  $err_msg['m_name'] = "Only letters allowed"; 
			}
		}
		if(empty($_POST["roll"])){
		   $err_msg['roll'] = "Roll is required";
		}
		else{
			$roll = valitation($_POST["roll"]);
			// check if roll only numeric
			if (!is_numeric($roll)) {
			  $err_msg['roll'] = "Only number allowed"; 
			}
			elseif(strlen($roll)!==4){
				$err_msg['roll'] = "Please enter 4 number";
			}
			else{
				include_once('config.php');
				$query = mysqli_query($con,"SELECT `Roll` FROM `info` WHERE Roll='$roll'");
				if(mysqli_num_rows($query)){
					$err_msg['roll'] = "This roll already exists";
				}
			}
		}
		if(empty($_POST["email"])){
		   $err_msg['email'] = "Email is required";
		}
		else{
			$email = valitation($_POST["email"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$err_msg['email'] = "Invalid email format"; 
			}
			else{
				include_once('config.php');
				$query = mysqli_query($con,"SELECT `Email` FROM `info` WHERE Email='$email'");
				if(mysqli_num_rows($query)){
					$err_msg['email'] = "This email already exists";
				}
			}
		}	
		if(empty($_POST["phone"])){
		   $err_msg['phone'] = "Phone number is required";
		}
		else{
			$phone = valitation($_POST["phone"]);
			// check if phone only numeric
			if (!is_numeric($phone)) {
			  $err_msg['phone'] = "Only number allowed"; 
			}
			else if(strlen($phone)!==11){
				$err_msg['phone'] = "Please enter 11 number";
			}
			else{
				include_once('config.php');
				$query = mysqli_query($con,"SELECT `Phone` FROM `info` WHERE Phone='$phone'");
				if(mysqli_num_rows($query)){
					$err_msg['phone'] = "This number already exists";
				}
			}
		}
		if(empty($_POST["address"])){
		   $err_msg['address'] = "Address is required";
		}
		else{
		   $address = valitation($_POST["address"]);
		}
		if(empty($_POST["dob"])){
		   $err_msg['dob'] = "Date of birth is required";
		}
		else{
		   $dob = valitation($_POST["dob"]);
		}
		if(empty($_POST["religion"])){
		   $err_msg['religion'] = "Religion is required";
		}
		else{
		   $religion = valitation($_POST["religion"]);
		}
		if(empty($_POST["district"])){
		   $err_msg['district'] = "District is required";
		}
		else{
		   $district = valitation($_POST["district"]);
		}
		if(empty($_POST["gender"])){
		   $err_msg['gender'] = "Gender is required";
		}
		else {
		   $gender = valitation($_POST["gender"]);
		}
		$image = $_FILES['image']['name'];
		if($image){
			if(($_FILES['image']['size']>=(1024*1024))){
				$err_msg['image'] = "Upload maximum 1MB file";
			} 
			else if(($_FILES['image']['type']=="image/jpeg") or ($_FILES['image']['type']=="image/png") or ($_FILES['image']['type']=="image/gif")){
			
			if(!$err_msg['name'] and !$err_msg['roll'] and !$err_msg['email'] and !$err_msg['phone'] and!$err_msg['address'] and !$err_msg['dob'] and !$err_msg['gender'] and !$err_msg['religion'] and !$err_msg['image']){
			
			$location = time(). rand()."-".$_FILES['image']['name'];
			
			move_uploaded_file($_FILES['image']['tmp_name'], "upload/".$location);
			
			}
			}	
			else{
				$err_msg['image'] = "Upload jpg, png or gif file";
			}
		}
		else{
			$err_msg['image'] = "Photo is required";
		}
		}
		
		function valitation($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		if(isset($_POST['submit'])){
		include_once('config.php');		
		if(!$err_msg['name'] and !$err_msg['f_name'] and !$err_msg['m_name'] and !$err_msg['roll'] and !$err_msg['email'] and !$err_msg['dob'] and !$err_msg['gender'] and !$err_msg['religion'] and !$err_msg['phone'] and !$err_msg['district'] and !$err_msg['address'] and !$err_msg['image']){
		
		$qry = "INSERT INTO `info` (`Name`, `F_Name`, `M_Name`, `Roll`, `Email`, `DOB`, `Gender`, `Religion`, `Phone`, `District`, `Address`, `Image`) VALUES ('$name','$f_name','$m_name','$roll','$email','$dob','$gender','$religion','$phone','$district','$address','$location')";
		
		$run = mysqli_query($con,$qry);
		if($run){
			$submit_msg = '<span style="color:green;font-style:italic;">Data inserted successful.</span>';
		}
		}
		else{
			$submit_msg = '<span style="color:#f00;font-style:italic;">Data inserted fail.</span>';
		}
			//header('refresh:3; url=insert.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Student Management System">
		<meta name="author" content="Apu Saha">
		<link rel="icon" href="img/icon.png">
		<title>Student Management System</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/style.css" />
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"><link rel="stylesheet" href="style.css" />
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>
			  $(function() {
				$( "#datepicker2" ).datepicker();
			  });
		</script>
	</head>
	<body>
		<div class="container main_area">
			<div class="row  border rounded border-info mt-3"> 
				<div class="col-md-12 bg-info"> 
					<div class="form-title text-center text-white pt-2">
						<h3>Add New Student</h3>
					</div>
					<div class="row">
						<div class="col-md-10">
							<ul class="nav nav-tabs" style="border-bottom:none;">
							  <li class="nav-item text-body">
								<a class="nav-link active" href="insert.php">Add New Student</a>
							  </li>
							  <li class="nav-item ml-2">
								<a class="nav-link text-body" href="allstudent.php">All Student</a>
							  </li>
							</ul>
						</div>
						<div class="col-md-2">
							<a href="logout.php"><button class="btn btn-outline-white float-right" type="submit">Logout</button></a>
						</div>
					</div>
				</div>
				<div class="col-md-12"> 
					<div class="mt-3">
						<div class="form_content">
							<form class="was-validated" action="insert.php" method="post" enctype="multipart/form-data">
								<div class="row"> 
									<div class="col-md-6">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Full Name</div>
											</div>
											<input type="text" class="form-control" name="name" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Father's Name</div>
											</div>
											<input type="text" class="form-control" name="f_name" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['f_name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Mother's Name</div>
											</div>
											<input type="text" class="form-control" name="m_name" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['m_name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Roll</div>		  
											</div>
											<input type="text" class="form-control" name="roll" required>
											
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['roll']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Email Address</div>
											</div>
											<input type="text" class="form-control" name="email" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['email']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Date of Birth</div>
											</div>
											<input type="text" class="form-control" placeholder="MM / DD / YYYY" name="dob" id="datepicker2" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['dob']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Gender</div>
											</div>
											<select class="custom-select" name="gender" id="" required>
												<option value="">--- Select One ---</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['gender']; ?></div>
									</div>
									<div class="col-md-6"> 
										<div class="input-group mb-2">
										<div class="input-group-prepend">
										  <div class="input-group-text">Religion</div>
										</div>
										<select class="custom-select" name="religion" id="" required>
											<option value="">--- Select One ---</option>
											<option value="Islam">Islam</option>
											<option value="Hinduism">Hinduism</option>
											<option value="Christianity">Christianity</option>
											<option value="Buddhism">Buddhism</option>
											<option value="Other">Other</option>
										</select>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['religion']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Phone No.</div>
											</div>
											<input type="text" class="form-control" name="phone" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['phone']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">District</div>
											</div>
											<select class="custom-select" name="district" id="" required>
												<option value="">--- Select One ---</option>
												<option value="Bagerhat">Bagerhat</option>
												<option value="Bandarban">Bandarban</option>
												<option value="Barguna">Barguna</option>
												<option value="Barishal">Barishal</option>
												<option value="Bhola">Bhola</option>
												<option value="Bogura">Bogura</option>
												<option value="Brahmanbaria">Brahmanbaria</option>
												<option value="Chandpur">Chandpur</option>
												<option value="Chapainawabganj">Chapainawabganj</option>
												<option value="Chattogram">Chattogram</option>
												<option value="Chuadanga">Chuadanga</option>
												<option value="Coxsbazar">Coxsbazar</option>
												<option value="Cumilla">Cumilla</option>
												<option value="Dhaka">Dhaka</option>
												<option value="Dinajpur">Dinajpur</option>
												<option value="Faridpur">Faridpur</option>
												<option value="Feni">Feni</option>
												<option value="Gaibandha">Gaibandha</option>
												<option value="Gazipur">Gazipur</option>
												<option value="Gopalganj">Gopalganj</option>
												<option value="Habiganj">Habiganj</option>
												<option value="Jamalpur">Jamalpur</option>
												<option value="Jashore">Jashore</option>
												<option value="Jhalakathi">Jhalakathi</option>
												<option value="Jhenaidah">Jhenaidah</option>
												<option value="Joypurhat">Joypurhat</option>
												<option value="Khagrachhari">Khagrachhari</option>
												<option value="Khulna">Khulna</option>
												<option value="Kishoreganj">Kishoreganj</option>
												<option value="Kurigram">Kurigram</option>
												<option value="Kushtia">Kushtia</option>
												<option value="Lakshmipur">Lakshmipur</option>
												<option value="Lalmonirhat">Lalmonirhat</option>
												<option value="Madaripur">Madaripur</option>
												<option value="Magura">Magura</option>
												<option value="Manikganj">Manikganj</option>
												<option value="Meherpur">Meherpur</option>
												<option value="Moulvibazar">Moulvibazar</option>
												<option value="Munshiganj">Munshiganj</option>
												<option value="Mymensingh">Mymensingh</option>
												<option value="Naogaon">Naogaon</option>
												<option value="Narail">Narail</option>
												<option value="Narayanganj">Narayanganj</option>
												<option value="Narsingdi">Narsingdi</option>
												<option value="Natore">Natore</option>
												<option value="Netrokona">Netrokona</option>
												<option value="Nilphamari">Nilphamari</option>
												<option value="Noakhali">Noakhali</option>
												<option value="Pabna">Pabna</option>
												<option value="Panchagarh">Panchagarh</option>
												<option value="Patuakhali">Patuakhali</option>
												<option value="Pirojpur">Pirojpur</option>
												<option value="Rajbari">Rajbari</option>
												<option value="Rajshahi">Rajshahi</option>
												<option value="Rangamati">Rangamati</option>
												<option value="Rangpur">Rangpur</option>
												<option value="Satkhira">Satkhira</option>
												<option value="Shariatpur">Shariatpur</option>
												<option value="Sherpur">Sherpur</option>
												<option value="Sirajganj">Sirajganj</option>
												<option value="Sunamganj">Sunamganj</option>
												<option value="Sylhet">Sylhet</option>
												<option value="Tangail">Tangail</option>
												<option value="Thakurgaon">Thakurgaon</option>
											</select>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['district']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Address</div>
											</div>
											<textarea class="form-control" name="address" style="height:86px" required></textarea>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['address']; ?></div>
										<div class="input-group mb-2">
											<div class="custom-file">
											  <input type="file" class="custom-file-input" name="image" required>
											  <label class="custom-file-label" for="customFile">Choose Photo</label>
											</div>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['image']; ?></div>
										<div  class="text-center"><?php echo $submit_msg; ?></div>
										<button type="submit" name="submit" class="btn btn-info mb-4 float-right">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
