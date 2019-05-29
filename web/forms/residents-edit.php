 <?php require("../../assets/inc/password_protect.php"); ?>





<?php 
require_once('db-connection.php');

//save record to db if method is post
if( $_POST ) {
	//echo "<pre>";print_R($_POST);
	$name = mysqli_real_escape_string($conn, addslashes($_POST['name']));
	$email = mysqli_real_escape_string($conn, addslashes($_POST['email']));
	//check if adding user
	if( !isset($_POST['edit_id']) )
	{
		$query1 = "INSERT INTO user (name,email) values('".$name."','".$email."')";
				
		$res = $conn->query($query1) or die($conn->error);
	}
	else {
		$query1 = "update user set name = '".$name."', email = '".$email."' where id = '".$_POST['edit_id']."'";
				
		$res = $conn->query($query1);
	}
	
	header("Location:residents-edit.php");
}

//remove record
if( $_GET ) {
	//echo "<pre>";print_R($_POST);
	$query1 = "delete from user where id = '".$_GET['id']."'";
				
	$res = $conn->query($query1);
	header("Location:residents-edit.php");
}



$query = "select * from user order by id desc";
$result = $conn->query($query);
$total_rows = $result->num_rows;
?>


<!doctype html>
<html lang="en">
<head>


<!-- header here      -->
 <?php require("../../assets/inc/header.php"); ?>


<title>edit-residents</title>
<link rel="stylesheet" href="../../assets/css/bootstrap.css">


<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<style>

	#remove-form { 
	display:inline;}
</style>


</head>
<body>

<!-- navbar here      -->
 <?php require("../../assets/inc/navbar.php"); ?> 

<!-- body (main content) here ----------------------->



<div class="container">
<hr>
<br>
	<form id="add_edit_user" method="POST" action="">
		<div class="form-group">
			<label>Name</label>
			<input class="form-control" type='text' id="name" placeholder="Enter Name" required name="name" />
		</div>
		<div class="form-group">
			<label>Email</label>
			<input class="form-control" type='email' id="email" placeholder="Enter Email" required name="email" />
		</div>
		<button class="btn btn-primary" type="submit">Submit</button>
		<button class="btn btn-default" type="reset" id="cancel">Reset</button>
	</form>

<hr>
<h3> All Users </h3>
<div class="table-responsive">
	<table id="list" style="" class="table table-striped">
		<tbody>
			<tr>
				<th class="">Name</th>
				<th class="">Email</th>
				<th class="">Action</th>
			</tr>
			<?php if( $total_rows < 1 ) {?>
				<tr> 
					<td style="text-align:center;" colspan="3">No Record Found </td>
				</tr>
			<?php } else {
				while ( $row = $result->fetch_assoc() ) { ?>
				<tr class="row2">
					<td class=" name"><?php echo $row['name'];?></td>
					<td class="= email"><?php echo $row['email'];?></td>
					<td class=" action-buttons">
						<button class="edit btn btn-primary" id="<?php echo $row['id'];?>">Edit</button>
						<form id="remove-form" method="get" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>" />
							<button type="submit" class="btn btn-danger remove" id="">Remove</button>
						</form>
						
					</td>
				</tr>
			<?php }
			 }?>

		</tbody>
	</table>
</div>
</div>

<script>
	$('body').on('submit', '#remove-form', function () {
		var conf = confirm('Are you sure you want to delete?');
		if( !conf ) {
			return false;
		}
	});
	
	$('body').on('click', '.edit', function () {
		var edit_id = $(this).attr('id');
		var name = $(this).parent().parent().find('td.name').text();
		var email = $(this).parent().parent().find('td.email').text();
		$('#name').val(name);
		$('#email').val(email);
		$('#add_edit_user').append('<input type="hidden" id="edit_id" name="edit_id" value="'+edit_id+'" />');
	})
	
	$('body').on('click', '#cancel', function () {
		$('#edit_id').remove();
		$('#add_edit_user').reset();
		
	});
</script>




<!-- body end here      -->

<!-- footer here      -->
      <footer class="text-center">
 <?php require("../../assets/inc/footer.php"); ?> 
      </footer>



<script src="../../assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/vendor/bootstrap.min.js"></script>



</body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
