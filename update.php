<?php
require '../database/database.php';

$id = $_GET['id'];

if ( !empty($_POST)) { // if $_POST filled then process the form
	
	# same as create

	// initialize user input validation variables
	$customerError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$customer = $_POST['customer_id'];    // same as HTML name= attribute in put box
	$event = $_POST['event_id'];
	
	// validate user input
	$valid = true;
	if (empty($customer)) {
		$customerError = 'Please choose a customer';
		$valid = false;
	}
	if (empty($event)) {
		$eventError = 'Please choose an event';
		$valid = false;
	} 
		
	if ($valid) { // if valid user input update the database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE assignments set assign_per_id = ?, assign_event_id = ? WHERE assign_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($customer,$event,$id));
		Database::disconnect();
		header("Location: assignments.php");
	}
} else { // if $_POST NOT filled then pre-populate the form
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM assignments where assign_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$customer = $data['assign_per_id'];
	$event = $data['assign_event_id'];
	Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">
<?php require 'html_head.php'; ?>
<body>
    <div class="container">

		<div class="span10 offset1">
		
			<div class="row">
				<h3>Update Assignment</h3>
			</div>
	
			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
		
				<div class="control-group">
					<label class="control-label">Customer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY name ASC';
							echo "<select class='form-control' name='customer_id' id='customer_id'>";
							foreach ($pdo->query($sql) as $row) {
									if($row['customer_id']==$customer)
									    echo "<option selected value='" . $row['customer_id'] . " '> " . $row['name'] . "</option>";
								    else
								       echo "<option value='" . $row['customer_id'] . " '> " . $row['name'] . "</option>"; 
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">Event</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM events ORDER BY event_date ASC, event_time ASC';
							echo "<select class='form-control' name='event_id' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
							    if($row['event_id'] == $event)
    								echo "<option selected value='" . $row['event_id'] . " '> " . $row['event_date'] . " (" . $row['event_time'] . ") - " . $row['event_description'] . " (" . $row['event_location'] . ") " . "</option>";
								else
    								echo "<option value='" . $row['event_id'] . " '> " . $row['event_date'] . " (" . $row['event_time'] . ") - " . $row['event_description'] . " (" . $row['event_location'] . ") " . "</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>