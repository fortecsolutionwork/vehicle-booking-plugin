<?php
    global $wpdb;
    $vehicle_table_name = $wpdb->prefix."vehicle_bookings";
    
    if(isset($_GET['delete']) && $_GET['delete'] != ""){
        $delete = $wpdb->delete( $vehicle_table_name , array( 'id' => $_GET['delete'] ), array( '%d' )); 
        
        if($delete == 1){
            $status_query = 3;
        }
    }
?>

<?php
    if(isset($_POST['submit']))
    {
		
		$vehicle_booking_table_name = $wpdb->prefix."vehicle_bookings";
		
        
        $booking_id = $_POST['booking_id']; 
        $email = $_POST['email']; 
        $status = $_POST['bookingStatus']; 
		
		
            $sql = $wpdb->update($vehicle_booking_table_name, array('status' => $status ), array( 'id' => $booking_id ) );
            if($sql == '1')
            {
				
				/* mail function start */	
        	$to = $email;
             
            if($status == 0) { $status = "Pending"; } 
					if($status == 1) { $status =  "Approved";  } 
						if($status == 2) { $status =  "Reject"; }  
							if($status == 3) { $status =  "On the way";  } 
								if($status == 4) { $status =  "Completed"; } 
							
			if( $status ==  "Completed" )
			$message = 'Your Booking status has been changed to '.$status.'. Thank you for booking us.';
			else
			$message = 'Your Booking status has been changed to '.$status.'.';
			
			
			// Email subject and body text.
            $subject = 'Booking Status Changed';
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
            $sent_message = wp_mail( $to, $subject, $message, $headers);
				
				
                echo "Status Updated Successfully"; 
            }
       }
    

?>

<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
        <!-- Bootstrap table script and css -->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
        
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
      
      <style>
        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
      </style>
      
    </head>
    <body>
        <div class="col-md-12" style="margin-top: 20px;">
            <?php
            	if ($_GET['Msg'])
            	{
            ?>
            	<div id="myElem" style="text-align: center;font-size: 17px;width: 50%;background: #dff0d8;margin: 0 auto; border: 1px solid #dff0d8; margin-bottom: 10px;padding: 10px;">
            		 Success! Vehicle Deleted Successfully
            	</div>
            	<script>
            		$(function() {
            			$("#myElem").show();
            			setTimeout(function() { $("#myElem").hide(); }, 5000);
            		});
            	</script>
            <?php
            	}
            if($_GET['Message']){
            ?>
            	<div id="myElem" style="text-align: center;font-size: 17px;width: 50%;background: #dff0d8;margin: 0 auto; border: 1px solid #dff0d8; margin-bottom: 10px;padding: 10px;">
            		 Success! Vehicle Data Inserted Successfully
            	</div>
            	<script>
            		$(function() {
            			$("#myElem").show();
            			setTimeout(function() { $("#myElem").hide(); }, 5000);
            		});
            	</script>
            <?php
            }
            if($_GET['UpMessage']) {
            ?>
            	<div id="myElem" style="text-align: center;font-size: 17px;width: 50%;background: #dff0d8;margin: 0 auto; border: 1px solid #dff0d8; margin-bottom: 10px;padding: 10px;">
            		 Success! Vehicle Data Updated Successfully
            	</div>
            	<script>
            		$(function() {
            			$("#myElem").show();
            			setTimeout(function() { $("#myElem").hide(); }, 5000);
            		});
            	</script>
            <?php    
            }
            ?>
        </div>
        
        <div id="content" style="margin-top: 50px;">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Booked Vehicle Type</th>
                        <th>Booked Vehicle Make</th>
                        <th>Booked Vehicle Model</th>
                        <th>Booked Vehicle Price</th>
                        <th>Booking Dated</th>
                        <th>Total Days</th>
                        <th>Total Price</th>
                        <th>Message</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
                        $vehicleResult = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name " ); $i=1;
                        foreach ($vehicleResult as $vehicleValue)
                        { 
                    ?> 
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $vehicleValue->firstname." ".$vehicleValue->lastname; ?></td>
                        <td><?php echo $vehicleValue->email; ?></td>
                        <td><?php echo $vehicleValue->phone; ?></td>
                        <td><?php echo $vehicleValue->vehicleType; ?></td>
                        <td><?php echo $vehicleValue->vehicleMake; ?></td>
						<td><?php echo $vehicleValue->vehicleModel; ?></td>
                        <td><?php echo $vehicleValue->vehiclePrice; ?></td>
						<td><b>From:</b> <?php echo $vehicleValue->datefrom; ?><br> <b>To:</b><?php echo $vehicleValue->dateto; ?></td>
                        <td><?php echo $vehicleValue->total_days; ?></td>
						<td><?php echo $vehicleValue->total_price; ?></td>
						<td><?php echo $vehicleValue->message; ?></td>
						<td><?php if($vehicleValue->status == 0) echo "Pending"; 
							if($vehicleValue->status == 1) echo "Approved";  
							if($vehicleValue->status == 2) echo "Reject";  
							if($vehicleValue->status == 3) echo "On the way";  
							if($vehicleValue->status == 4) echo "Completed"; ?></td>
                        <td>
						
						<form action="" method="post">
						
						<select name="bookingStatus"  class="form-control bookingStatus" id="bookingStatus" required>
						
						<option value="0" <?php if($vehicleValue->status == 0) echo "Selected"; ?>>Pending</option>
						<option value="1" <?php if($vehicleValue->status == 1) echo "Selected"; ?>>Approved</option>
						<option value="2" <?php if($vehicleValue->status == 2) echo "Selected"; ?>>Reject</option>
						<option value="3" <?php if($vehicleValue->status == 3) echo "Selected"; ?>>On the way</option>
						<option value="4" <?php if($vehicleValue->status == 4) echo "Selected"; ?>>Completed</option>
						
						</select>
						
							<input type="hidden" value="<?php echo $vehicleValue->id; ?>" name="booking_id">
                            <button type="submit" name="submit" class="btn btn-danger">Update Status</button>
                        </form>
                        </td>
                    </tr>
                    <?php 
                      $i++;  } 
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

<script>

  
    
    /* data table code */
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'pdf'
            ]
        } );
    } );
    </script>