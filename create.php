<?php 

require '../database/database.php';

if ( !empty($_POST)) {

	// initialize user input validation variables
	$personError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$person = $_POST['person'];    // same as HTML name= attribute in put box
	$event = $_POST['event'];
	
	// validate user input
	$valid = true;
	if (empty($person)) {
		$personError = 'Please choose a volunteer';
		$valid = false;
	}
	if (empty($event)) {
		$eventError = 'Please choose an event';
		$valid = false;
	} 
		
	// insert data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO assignments (assign_per_id,assign_event_id) values(?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($person,$event));
		Database::disconnect();
		header("Location: assignments.php");
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<?php require 'html_head.php'; ?>

<body>
    <div class="container">
    
		<div class="span10 offset1">
			<div class="row">
				<h3>Assign a Customer to an Event</h3>
			</div>
	
			<form class="form-horizontal" action="create.php" method="post">
		
				<div class="control-group">
					<label class="control-label">Customer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY name ASC';
							echo "<select class='form-control' name='person' id='customer_id'>";
							foreach ($pdo->query($sql) as $row) {
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
							echo "<select class='form-control' name='event' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
								echo "<option value='" . $row['event_id'] . " '> " . $row['event_date'] . " (" . $row['event_time'] . ") - " .
								trim($row['event_description']) . " (" . 
								trim($row['event_location']) . ") " .
								"</option>";
							}
								
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
						<a class="btn" href="assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
    </div> <!-- end div: class="container" -->

  </body>
</html>