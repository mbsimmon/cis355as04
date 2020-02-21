<!DOCTYPE html>
<html lang="en">
<?php require 'html_head.php'; ?>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Assignments</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Date</th>
		                  <th>Time</th>
		                  <th>Location</th>
		                  <th>Description</th>
		                  <th>Customer</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   require '../database/database.php';
					   $pdo = Database::connect();
					   $sql = "SELECT * FROM assignments 
						LEFT JOIN customers ON customers.customer_id = assignments.assign_per_id 
						LEFT JOIN events ON events.event_id = assignments.assign_event_id
						ORDER BY event_date ASC, event_time ASC, name ASC;";
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['event_date'] . '</td>';
							   	echo '<td>'. $row['event_time'] . '</td>';
							   	echo '<td>'. $row['event_location'] . '</td>';
						        echo '<td>'. $row['event_description'] . '</td>';
						        echo '<td>'. $row['name'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read.php?id='.$row['assign_id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['assign_id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['assign_id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
	            <a class="btn" href="../As3/customers.php">Create New Customer</a>
	            <a class="btn" href="../As3/events.php">Create New Event</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>