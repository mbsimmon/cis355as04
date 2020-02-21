<?php
require '../database/database.php';

$id = $_GET['id'];

if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record

	$id = $_POST['id'];
	
	// delete data
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "DELETE FROM assignments  WHERE assign_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	Database::disconnect();
	header("Location: assignments.php");
} 
else { // otherwise, pre-populate fields to show data to be deleted

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	# get assignment details
	$sql = "SELECT * FROM assignments where assign_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	# get volunteer details
	$sql = "SELECT * FROM customers where customer_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($data['assign_per_id']));
	$perdata = $q->fetch(PDO::FETCH_ASSOC);
	
	# get event details
	$sql = "SELECT * FROM events where event_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($data['assign_event_id']));
	$eventdata = $q->fetch(PDO::FETCH_ASSOC);
	
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
				<h3>Delete Assignment</h3>
			</div>
			<form class="form-horizontal" action="delete.php?id=<?php echo $id?>" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure you want to delete?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Yes</button>
					<a class="btn" href="assignments.php">No</a>
				</div>
			</form>
			
			<!-- Display same information as in file: read.php -->
			
			<div class="form-horizontal" >
			
				<div class="control-group">
					<label class="control-label"><b>Customer</b></label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $perdata['name'];?>
						</label>
					</div>
				</div>
				<br>
				<div class="control-group">
					<label class="control-label"><b>Event</b></label>
					<div class="controls">
						<label class="checkbox">
							<?php echo trim($eventdata['event_description']) . " (" . trim($eventdata['event_location']) . ") ";?>
						</label>
					</div>
				</div>
				<br>
				<div class="control-group">
					<label class="control-label"><b>Date, Time</b></label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $eventdata['event_date'] . ", " . $eventdata['event_time'];?>
						</label>
					</div>
				</div>
				
				<div class="form-actions">
					<a class="btn" href="assignments.php">Back</a>
				</div>
			
			</div> <!-- end div: class="form-horizontal" -->
			
		</div> <!-- end div: class="span10 offset1" -->
		
    </div> <!-- end div: class="container" -->
	
</body>
</html>