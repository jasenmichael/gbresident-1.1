 <?php require("../../assets/inc/password_protect.php"); ?> 

<!doctype html>
<html lang="en">
<head>


<!-- header here      -->
 <?php require("../../assets/inc/header.php"); ?> 

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

</head>
<body>

<!-- navbar here      -->
 <?php require("../../assets/inc/navbar.php"); ?> 

<!-- body (main content) here ----------------------->

  

<?php 
require_once('db-connection.php');

//save record to db if method is post
if( $_POST ) {
	//echo "<pre>";print_R($_POST);exit;
	foreach($_POST['name'] as $key => $name ) {
		$name = mysqli_real_escape_string($conn, addslashes($_POST['name'][$key]));
		$service = mysqli_real_escape_string($conn, addslashes($_POST['service'][$key]));
		$date = date('Y-m-d', strtotime( mysqli_real_escape_string($conn, ($_POST['date'][$key])) ));
		$hours = mysqli_real_escape_string($conn, ($_POST['hours'][$key]));
		$description = mysqli_real_escape_string($conn, addslashes($_POST['description'][$key]));
		
		$query1 = "INSERT INTO work_form (fk_user_id,service, date, hours, description) values('".$name."','".$service."','".$date."','".$hours."','".$description."')";
				
		$res = $conn->query($query1);
	}
	
	header("Location:work-form.php");
}
//remove record
if( $_GET ) {
	//echo "<pre>";print_R($_POST);
	$query1 = "delete from work_form where id = '".$_GET['id']."'";
				
	$res = $conn->query($query1);
	header("Location:work-form.php");
}

// $query = "select work_form.*, user.name from work_form inner join user on user.id = work_form.fk_user_id order by id desc";
 $query = "select user.* from user order by id desc";
$result = $conn->query($query);
$total_rows = $result->num_rows;

$query = "select * from user order by id desc";
$user_result = $conn->query($query);

//service array 
$service_arr = array('Educational Program', 'Building Maintenance', 'Property Maintenance', 'Administration' , 'Monthly General Meeting',
						'Committee meeting', "Board Meeting", "Budget Approved");
?>
<html>
<head>
<title>submit-hours</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<style>
#list {
	width: 100%;
}
	#list th, #list td {
		padding: 10px;
	}
	#remove-form { 
	display:inline;}
</style>
</head>
<body>




<div class="container">


<hr>
<br>
<div>
	<form id="work_form" method="post" action="">
		<table class="table" id="tbl" style="">
			<tbody>
				<tr>
					<th class="col2">Name</th>
					<th class="col2">Service</th>
					<th class="col2">Date</th>
					<th class="col2">Hours</th>
					<th class="col2">Description</th>
					<th class="col3"></th>
				</tr>
			</tbody>
			<tr class="tr_clone">
				<td>
					<select class="form-control" name="name[]" required>
						<?php while( $row = $user_result->fetch_assoc() ) { ?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
						<?php }?>
					</select>
				</td>
				<td>
					<select class="form-control" name="service[]" required>
						<?php for( $i = 0; $i < count($service_arr) ; $i++) { ?>
							<option value="<?php echo $service_arr[$i];?>"><?php echo $service_arr[$i];?></option>
						<?php }?>
					</select>
				</td>
				<td><input type='text'  class="form-control datepicker" placeholder="Enter date" required name="date[]" /></td>
				<td><input type='number' id="hours" step=".25" class="form-control" placeholder="Enter Hours" required name="hours[]" /></td>
				<td><input type='text' maxlength="30" id="description" class="form-control" placeholder="Enter description" name="description[]" /></td>
				<td class="cross"></td>
			</tr>
			<tr>
				<td colspan='6'><button id="add_more" class="btn btn-success" type="button">+</button></td>
			</tr>
			<tr>
				<td colspan='6'><button class="btn btn-primary" type="submit">Submit</button>
		<button type="reset" class="btn btn-default" id="cancel">Reset</button></td>
			</tr>
		</table>
		
	</form>
</div>
<hr>
<p style="text-align:center;">Hours submitted this month</p>


<hr>
<?php while ( $row_user = $result->fetch_assoc() ) { 

		$query = "select work_form.* from work_form where fk_user_id = '".$row_user['id']."' order by id desc";
		$result1 = $conn->query($query);
		$total_rows1 = $result1->num_rows;
		if( $total_rows1 > 0 ) {
		?>
	<h3> <?php echo $row_user['name'];?> </h3>
<div class="table-responsive">
	<table class="table table-striped" id="list" style="">
		<tbody>
			<tr>
				<th class="col2">Project</th>
				<th class="col2">Date</th>
				<th class="col2">Hours</th>
				<th class="col2">Description</th>
				<th class="col3">Action</th>
			</tr>
			
			
			<?php
				while ( $row = $result1->fetch_assoc() ) { ?>
				<tr class="row2">
					<td class=" email"><?php echo $row['service'];?></td>
					<td class=" date"><?php echo date('m/d/Y', strtotime($row['date']));?></td>
					<td class=" hours"><?php echo $row['hours'];?></td>
					<td class=" description"><?php echo $row['description'];?></td>
					<td class="col3 action-buttons">
						<!--<button class="edit" id="<?php echo $row['id'];?>">Edit</button>-->
						<form id="remove-form" style="float:left;" method="GET" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>" />
							<button type="submit" class="btn btn-danger remove" id="ca">Remove</button>
						</form>
						
					</td>
				</tr>
			<?php }
	?>

		</tbody>
	</table>
</div>
<?php }
} ?>

</div>


<center>
<hr>
<a href="residents-edit.php">add edit or remove residents</a>
<hr>

</center>
<br/>


<script>
$( function() {
    // $( ".datepicker" ).datepicker({  stepMonths: 0,minDate: 0, maxDate: "+1M" });
    
      // $( ".datepicker" ).datepicker( "option", "showAnim", 'slideDown' );
	  $(document).on("focus", ".datepicker", function(){
        $(this).datepicker({  stepMonths: 0,minDate: 0 });
		$( this ).datepicker( "option", "showAnim", 'slideDown' );
	  });

  } );
  
  
	
  $('body').on('click', '#remove_more', function() { 
		$(this).parent().parent().remove();
	});
	
	$('body').on('click', '#add_more', function() {
		var $tableBody = $('#tbl').find("tbody"),
		$trLast = $tableBody.find("tr.tr_clone:last");
		$trNew = $trLast.clone();
		$trNew.find(':text').val('');
		$trNew.find('.cross').html('<button id="remove_more" class="btn btn-danger" type="button">X</button>');
		$trLast.after($trNew);

		
		// var $tr    = $('.tr_clone');
		// var $clone = $tr.clone();console.log($tr);
		// $clone.find(':text').val('');
		// $clone.find('.cross').html('<button id="remove_more" class="btn btn-danger" type="button">X</button>');
		// $tr.after($clone);
	});
	
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
		$('#work_form').reset();
		
	});
</script>


<!-- body end here      -->

<!-- footer here      -->
      <footer class="text-center">
 <?php require("../../assets/inc/footer.php"); ?> 
      </footer>


<!-- I removed this and datepicker works again 
<script src="../../assets/js/vendor/jquery-1.11.2.min.js"></script>          
-->
<script src="../../assets/js/vendor/bootstrap.min.js"></script>



</body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
