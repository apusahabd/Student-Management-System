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
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"><link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#example').DataTable();
			} );
		</script>
	</head>
	<body>
		<div class="container main_area">
			<div class="row  border rounded border-info mt-3 mb-3 pb-3">
				<div class="col-md-12 bg-info">
					<div class="row">
						<div class="col-md-11 pt-1">
							<div class="form-title text-center text-white">
								<h3>All Student</h3>
							</div>
						</div>
						<div class="col-md-1">
							<a href="login.php"><button class="btn btn-outline-white float-right mt-1 mb-1" type="submit">Login</button></a>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="mt-3">
						<table id="example" class="table table-hover table-bordered text-center">
							<thead>
								<tr>
									<th scope="col">Name</th>
									<th scope="col">Roll</th>
									<th scope="col">Email</th>
									<th scope="col">Gender</th>
									<th scope="col">Phone</th>
									<th scope="col">District</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									include_once('config.php');
									$qry = "SELECT * FROM `info`";
									$run = mysqli_query($con,$qry);
										while($info = mysqli_fetch_assoc($run)) :
								?>
								<tr>
									<td class="text-left"><?php echo $info['Name'];?></td>
									<td><?php echo $info['Roll'];?></td>
									<td class="text-left"><?php echo $info['Email'];?></td>
									<td><?php echo $info['Gender'];?></td>
									<td><?php echo $info['Phone'];?></td>
									<td><?php echo $info['District'];?></td>
									<td><a href="allstudent.php" data-toggle="modal" data-target="#exampleModal<?php echo $info['ID'];?>" class="badge badge-info">View</a></td>
								</tr>
								<?php
									endwhile;
								?>
							</tbody>
						</table>
						<?php include_once('config.php');
							$qry = "SELECT * FROM `info`";
							$run = mysqli_query($con,$qry);
							while($info = mysqli_fetch_assoc($run)) :
						?>
						<div class="modal fade" id="exampleModal<?php echo $info['ID'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title text-info" id="exampleModalLabel">Student Information</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="row"> 
											<div class="col-md-4"></div>
										<div class="col-md-4">
											<img src="upload/<?php echo $info['Image'];?>" style="width:135px;height:150px;"class="img-thumbnail border-info mb-3" alt="Student Photo" />
										</div>
										<div class="col-md-4"></div>
										</div>
										<table class="table table-striped table-sm table-bordered">
											<tr>
												<th class="text-right">Student Name</th>
												<td><?php echo $info['Name'];?></td>
											</tr>
											<tr>
												<th class="text-right">Father's Name</th>
												<td><?php echo $info['F_Name'];?></td>
											</tr>
											<tr>
												<th class="text-right">Mother's Name</th>
												<td><?php echo $info['M_Name'];?></td>
											</tr>
											<tr>
												<th class="text-right">Roll</th>
												<td><?php echo $info['Roll'];?></td>
											</tr>
											<tr>
												<th class="text-right">Email</th>
												<td><?php echo $info['Email'];?></td>
											</tr>
											<tr>
												<th class="text-right">Date of Birth</th>
												<td><?php echo $info['DOB'];?></td>
											</tr>
											<tr>
												<th class="text-right">Gender</th>
												<td><?php echo $info['Gender'];?></td>
											</tr>
											<tr>
												<th class="text-right">Religion</th>
												<td><?php echo $info['Religion'];?></td>
											</tr>
											<tr>
												<th class="text-right">Phone No</th>
												<td><?php echo $info['Phone'];?></td>
											</tr>
											<tr>
												<th class="text-right">District</th>
												<td><?php echo $info['District'];?></td>
											</tr>
											<tr>
												<th class="text-right">Address</th>
												<td><?php echo $info['Address'];?></td>
											</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>