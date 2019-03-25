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
			else if(strlen($roll)!==4){
				$err_msg['roll'] = "Please enter 4 number";
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
			
			if(!$err_msg['name'] and !$err_msg['roll'] and !$err_msg['email'] and !$err_msg['phone'] and!$err_msg['address'] and !$err_msg['dob'] and !$err_msg['gender'] and !$err_msg['image']){
			
			$location = time(). rand()."-".$_FILES['image']['name'];
			
			move_uploaded_file($_FILES['image']['tmp_name'], "upload/".$location);
			}
			}	
			else{
				$err_msg['image'] = "Upload jpg, png or gif file";
			}
			}
		
		
		}
		
		function valitation($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		include_once('config.php');
			$id = $_GET['id'];
			$qry = "SELECT * FROM `info` WHERE ID = '$id'";
			$run = mysqli_query($con,$qry);
			$info = mysqli_fetch_assoc($run);
			
			if(isset($_POST['update'])){
			if(!$err_msg['name'] and !$err_msg['f_name'] and !$err_msg['m_name'] and !$err_msg['roll'] and !$err_msg['email'] and !$err_msg['dob'] and !$err_msg['gender'] and !$err_msg['religion'] and !$err_msg['phone'] and !$err_msg['district'] and !$err_msg['address'] and !$err_msg['image']){
				
			if($_FILES['image']['name']) {
			$uqry="UPDATE `info` SET `Name`='$name', `F_Name`='$f_name', `M_Name`='$m_name', `Roll`='$roll', `Email`='$email', `DOB`='$dob', `Gender`='$gender', `Religion`='$religion', `Phone`='$phone', `District`='$district', `Address`='$address', `Image` ='$location' WHERE `ID` = '$id'";
			} else{
				$uqry="UPDATE `info` SET `Name`='$name', `F_Name`='$f_name', `M_Name`='$m_name', `Roll`='$roll', `Email`='$email', `DOB`='$dob', `Gender`='$gender', `Religion`='$religion', `Phone`='$phone', `District`='$district', `Address`='$address' WHERE `ID` = '$id'";
			}
			
			$run = mysqli_query($con,$uqry);
			if($run){
					$submit_msg = '<span style="color:green;font-style:italic;">Data update successful.</span>';
				}
				}
				else{
					$submit_msg = '<span style="color:#f00;font-style:italic;">Data update fail.</span>';
				}
				//header('refresh:2;url=');
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
					<div class="form-title text-center bg-info text-white pt-2">
						<h3>Update Student Info</h3>
					</div>
					<div class="row">
						<div class="col-md-10">
							<ul class="nav nav-tabs" style="border-bottom:none;">
							  <li class="nav-item text-body">
								<a class="nav-link text-body" href="insert.php">Add New Student</a>
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
							<form class="was-validated" action="edit.php?id=<?php echo $info['ID'];?>" method="post" enctype="multipart/form-data">
								<div class="row"> 
									<div class="col-md-6">
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Full Name</div>
											</div>
											<input type="text" class="form-control" name="name" value="<?php echo $info['Name'];?>" required />
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Father's Name</div>
											</div>
											<input type="text" class="form-control" name="f_name" value="<?php echo $info['F_Name'];?>" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['f_name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Mother's Name</div>
											</div>
											<input type="text" class="form-control" name="m_name" value="<?php echo $info['M_Name'];?>" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['m_name']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Roll</div>		  
											</div>
											<input type="text" class="form-control" name="roll" value="<?php echo $info['Roll'];?>" required>
											
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['roll']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Email Address</div>
											</div>
											<input type="text" class="form-control" name="email" value="<?php echo $info['Email'];?>" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['email']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Date of Birth</div>
											</div>
											<input type="text" class="form-control" placeholder="MM / DD / YYYY" name="dob" id="datepicker2" value="<?php echo $info['DOB'];?>" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['dob']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Gender</div>
											</div>
											<select class="custom-select" name="gender" id="" required>
												<option value="">--- Select One ---</option>
												<option value="Male" <?php if($info['Gender']=='Male'){echo "selected";}?>>Male</option>
												<option value="Female" <?php if($info['Gender']=='Female'){echo "selected";}?>>Female</option>
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
											<option value="Islam" <?php if($info['Religion']=='Islam'){echo "selected";}?>>Islam</option>
											<option value="Hinduism" <?php if($info['Religion']=='Hinduism'){echo "selected";}?>>Hinduism</option>
											<option value="Christianity" <?php if($info['Religion']=='Christianity'){echo "selected";}?>>Christianity</option>
											<option value="Buddhism" <?php if($info['Religion']=='Buddhism'){echo "selected";}?>>Buddhism</option>
											<option value="Other" <?php if($info['Religion']=='Other'){echo "selected";}?>>Other</option>
										</select>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['religion']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Phone No.</div>
											</div>
											<input type="text" class="form-control" name="phone" value="<?php echo $info['Phone'];?>" required>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['phone']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">District</div>
											</div>
											<select class="custom-select" name="district" id="" required>
												<option value="">--- Select One ---</option>
												<option value="Bagerhat" <?php if($info['District']=='Bagerhat'){echo "selected";}?>>Bagerhat</option>
												<option value="Bandarban" <?php if($info['District']=='Bandarban'){echo "selected";}?>>Bandarban</option>
												<option value="Barguna" <?php if($info['District']=='Barguna'){echo "selected";}?>>Barguna</option>
												<option value="Barishal" <?php if($info['District']=='Barishal'){echo "selected";}?>>Barishal</option>
												<option value="Bhola" <?php if($info['District']=='Bhola'){echo "selected";}?>>Bhola</option>
												<option value="Bogura" <?php if($info['District']=='Bogura'){echo "selected";}?>>Bogura</option>
												<option value="Brahmanbaria" <?php if($info['District']=='Brahmanbaria'){echo "selected";}?>>Brahmanbaria</option>
												<option value="Chandpur" <?php if($info['District']=='Chandpur'){echo "selected";}?>>Chandpur</option>
												<option value="Chapainawabganj" <?php if($info['District']=='Chapainawabganj'){echo "selected";}?>>Chapainawabganj</option>
												<option value="Chattogram" <?php if($info['District']=='Chattogram'){echo "selected";}?>>Chattogram</option>
												<option value="Chuadanga" <?php if($info['District']=='Chuadanga'){echo "selected";}?>>Chuadanga</option>
												<option value="Coxsbazar" <?php if($info['District']=='Coxsbazar'){echo "selected";}?>>Coxsbazar</option>
												<option value="Cumilla" <?php if($info['District']=='Cumilla'){echo "selected";}?>>Cumilla</option>
												<option value="Dhaka" <?php if($info['District']=='Dhaka'){echo "selected";}?>>Dhaka</option>
												<option value="Dinajpur" <?php if($info['District']=='Dinajpur'){echo "selected";}?>>Dinajpur</option>
												<option value="Faridpur" <?php if($info['District']=='Faridpur'){echo "selected";}?>>Faridpur</option>
												<option value="Feni" <?php if($info['District']=='Feni'){echo "selected";}?>>Feni</option>
												<option value="Gaibandha" <?php if($info['District']=='Gaibandha'){echo "selected";}?>>Gaibandha</option>
												<option value="Gazipur" <?php if($info['District']=='Gazipur'){echo "selected";}?>>Gazipur</option>
												<option value="Gopalganj" <?php if($info['District']=='Gopalganj'){echo "selected";}?>>Gopalganj</option>
												<option value="Habiganj" <?php if($info['District']=='Habiganj'){echo "selected";}?>>Habiganj</option>
												<option value="Jamalpur" <?php if($info['District']=='Jamalpur'){echo "selected";}?>>Jamalpur</option>
												<option value="Jashore" <?php if($info['District']=='Jashore'){echo "selected";}?>>Jashore</option>
												<option value="Jhalakathi" <?php if($info['District']=='Jhalakathi'){echo "selected";}?>>Jhalakathi</option>
												<option value="Jhenaidah" <?php if($info['District']=='Jhenaidah'){echo "selected";}?>>Jhenaidah</option>
												<option value="Joypurhat" <?php if($info['District']=='Joypurhat'){echo "selected";}?>>Joypurhat</option>
												<option value="Khagrachhari" <?php if($info['District']=='Khagrachhari'){echo "selected";}?>>Khagrachhari</option>
												<option value="Khulna" <?php if($info['District']=='Khulna'){echo "selected";}?>>Khulna</option>
												<option value="Kishoreganj" <?php if($info['District']=='Kishoreganj'){echo "selected";}?>>Kishoreganj</option>
												<option value="Kurigram" <?php if($info['District']=='Kurigram'){echo "selected";}?>>Kurigram</option>
												<option value="Kushtia" <?php if($info['District']=='Kushtia'){echo "selected";}?>>Kushtia</option>
												<option value="Lakshmipur" <?php if($info['District']=='Lakshmipur'){echo "selected";}?>>Lakshmipur</option>
												<option value="Lalmonirhat" <?php if($info['District']=='Lalmonirhat'){echo "selected";}?>>Lalmonirhat</option>
												<option value="Madaripur" <?php if($info['District']=='Madaripur'){echo "selected";}?>>Madaripur</option>
												<option value="Magura" <?php if($info['District']=='Magura'){echo "selected";}?>>Magura</option>
												<option value="Manikganj" <?php if($info['District']=='Manikganj'){echo "selected";}?>>Manikganj</option>
												<option value="Meherpur" <?php if($info['District']=='Meherpur'){echo "selected";}?>>Meherpur</option>
												<option value="Moulvibazar" <?php if($info['District']=='Moulvibazar'){echo "selected";}?>>Moulvibazar</option>
												<option value="Munshiganj" <?php if($info['District']=='Munshiganj'){echo "selected";}?>>Munshiganj</option>
												<option value="Mymensingh" <?php if($info['District']=='Mymensingh'){echo "selected";}?>>Mymensingh</option>
												<option value="Naogaon" <?php if($info['District']=='Naogaon'){echo "selected";}?>>Naogaon</option>
												<option value="Narail" <?php if($info['District']=='Narail'){echo "selected";}?>>Narail</option>
												<option value="Narayanganj" <?php if($info['District']=='Narayanganj'){echo "selected";}?>>Narayanganj</option>
												<option value="Narsingdi" <?php if($info['District']=='Narsingdi'){echo "selected";}?>>Narsingdi</option>
												<option value="Natore" <?php if($info['District']=='Natore'){echo "selected";}?>>Natore</option>
												<option value="Netrokona" <?php if($info['District']=='Netrokona'){echo "selected";}?>>Netrokona</option>
												<option value="Nilphamari" <?php if($info['District']=='Nilphamari'){echo "selected";}?>>Nilphamari</option>
												<option value="Noakhali" <?php if($info['District']=='Noakhali'){echo "selected";}?>>Noakhali</option>
												<option value="Pabna" <?php if($info['District']=='Pabna'){echo "selected";}?>>Pabna</option>
												<option value="Panchagarh" <?php if($info['District']=='Panchagarh'){echo "selected";}?>>Panchagarh</option>
												<option value="Patuakhali" <?php if($info['District']=='Patuakhali'){echo "selected";}?>>Patuakhali</option>
												<option value="Pirojpur" <?php if($info['District']=='Pirojpur'){echo "selected";}?>>Pirojpur</option>
												<option value="Rajbari" <?php if($info['District']=='Rajbari'){echo "selected";}?>>Rajbari</option>
												<option value="Rajshahi" <?php if($info['District']=='Rajshahi'){echo "selected";}?>>Rajshahi</option>
												<option value="Rangamati" <?php if($info['District']=='Rangamati'){echo "selected";}?>>Rangamati</option>
												<option value="Rangpur" <?php if($info['District']=='Rangpur'){echo "selected";}?>>Rangpur</option>
												<option value="Satkhira" <?php if($info['District']=='Satkhira'){echo "selected";}?>>Satkhira</option>
												<option value="Shariatpur" <?php if($info['District']=='Shariatpur'){echo "selected";}?>>Shariatpur</option>
												<option value="Sherpur" <?php if($info['District']=='Sherpur'){echo "selected";}?>>Sherpur</option>
												<option value="Sirajganj" <?php if($info['District']=='Sirajganj'){echo "selected";}?>>Sirajganj</option>
												<option value="Sunamganj" <?php if($info['District']=='Sunamganj'){echo "selected";}?>>Sunamganj</option>
												<option value="Sylhet" <?php if($info['District']=='Sylhet'){echo "selected";}?>>Sylhet</option>
												<option value="Tangail" <?php if($info['District']=='Tangail'){echo "selected";}?>>Tangail</option>
												<option value="Thakurgaon" <?php if($info['District']=='Thakurgaon'){echo "selected";}?>>Thakurgaon</option>
											</select>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['district']; ?></div>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
											  <div class="input-group-text">Address</div>
											</div>
											<textarea class="form-control" name="address" style="height:86px"  required><?php echo $info['Address'];?></textarea>
										</div>
										<div  class="text-center text-danger mb-2" style="font-style: italic;"><?php echo $err_msg['address']; ?></div>
										<?php if($info['Image']) : ?>
										<div class="row">
											<div class="col-md-2">
												<img src="upload/<?php echo $info['Image']; ?>" alt="Profile Picture" class="img-thumbnail border-success">
											</div>
											<div class="col-md-10">
												<div class="row">
													<div class="col-md-12">
													<div class="custom-file">
													  <input type="file" class="custom-file-input" name="image" />
													  <label class="custom-file-label" for="customFile">Choose Photo</label>
													</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 mt-2">
														<div  class="text-center text-success" style="font-style: italic;"><?php echo $submit_msg; ?></div>
													</div>
												</div>
											</div>
										</div>									
										<?php endif; ?>
										<div  class="text-center text-danger" style="font-style: italic;"><?php echo $err_msg['image'];?></div>
										<button type="submit" name="update" class="btn btn-info mb-3 float-right">Update</button>
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
