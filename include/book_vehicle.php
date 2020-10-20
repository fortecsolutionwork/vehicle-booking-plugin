<?php
    global $wpdb;
    define('WP_USE_THEMES', false);
    //require_once( $_SERVER['DOCUMENT_ROOT'].'/freshp/wp-load.php' );
    require_once( $_SERVER['DOCUMENT_ROOT'].'/freshp/wp-load.php' );
	
    $vehicle_category_table_name = $wpdb->prefix."vehicle_categories";
    wp_enqueue_media();

    $id = $_GET['edit'];
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name WHERE id = $id " );
	$results_vehicle_categories = $wpdb->get_results( " SELECT * FROM  $vehicle_category_table_name" );
?>

<?php
    if(isset($_POST['submit']))
    {
		
		$vehicle_booking_table_name = $wpdb->prefix."vehicle_bookings";
		
        $user_id = get_current_user_id();
        $firstname = $_POST['firstname']; 
        $lastname = $_POST['lastname']; 
        $email = $_POST['email']; 
        $phone = $_POST['phone']; 
        $vehicleType = $_POST['vehicleType']; 
        $vehicleMake = $_POST['vehicleMake']; 
        $vehicleModel = $_POST['vehicleModel'];
        $vehiclePrice = $_POST['vehiclePrice']; 
        $vehicleBookingPrice = $_POST['vehicleBookingPrice'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $total_days = $_POST['total_days'];
        $message = $_POST['message']; 
		
		
            $sql = $wpdb->insert($vehicle_booking_table_name, array(
				'user_id' => $user_id, 
				'firstname' => $firstname, 
				'lastname' => $lastname, 
				'email' => $email, 
				'phone' => $phone, 
				'vehicleType' => $vehicleType, 
				'vehicleMake'=>$vehicleMake, 
				'vehicleModel' => $vehicleModel, 
				'vehiclePrice' => $vehiclePrice, 
				'total_price' => $vehicleBookingPrice, 
				'datefrom' => $from_date, 
				'dateto' => $to_date, 
				'total_days' => $total_days, 
				'message' => $message, 
				'status' => "0") );
            if($sql == '1')
            {
				
				/* mail function start */	
        	$to = get_option('admin_email');
             
            
			
			$message = '<table>';
			$message .= '<tr><td>Name</td><td></td></tr>';
			$message .= '<tr><td>Email</td><td></td></tr>';
			$message .= '<tr><td>Phone</td><td></td></tr>';
			$message .= '<tr><td>Booked Vehicle Type</td><td></td></tr>';
			$message .= '<tr><td>Booked Vehicle Make</td><td></td></tr>';
			$message .= '<tr><td>Booked Vehicle Model</td><td></td></tr>';
			$message .= '<tr><td>Booked Vehicle Price</td><td></td></tr>';
			$message .= '<tr><td>Booking Dated</td><td></td></tr>';
			$message .= '<tr><td>Total Days</td><td></td></tr>';
			$message .= '<tr><td>Total Price</td><td></td></tr>';
			$message .= '<tr><td>Message</td><td></td></tr>';
			$message .= '<div class="" style="padding-bottom: 5%;">';
			$message .= '</table>';
			
			
			// Email subject and body text.
            $subject = 'New Booking';
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
            $sent_message = wp_mail( $to, $subject, $message, $headers);
			
			//customer email
			
			$to_c = $email;
             
            if($status == 0) { $status = "Pending"; } 
					if($status == 1) { $status =  "Approved";  } 
						if($status == 2) { $status =  "Reject"; }  
							if($status == 3) { $status =  "On the way";  } 
								if($status == 4) { $status =  "Completed"; } 
							
			
			$message_c = 'Your Booking request has been placed with Pending status. Thank you for booking with us.';
			
			
			
			// Email subject and body text.
            $subject_c = 'Booking request placed successfully';
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
            $sent_message_c = wp_mail( $to_c, $subject_c, $message_c, $headers);
				
               $status_query = 1;
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
      <style>
        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
      </style>
      
    </head>
    <body>
        <div class="container">
		
		<div>
		<h4><?php if(isset($status_query) && $status_query == 1)  echo "Booking request placed successfully."; ?></h4>
		</div>
		
           <h2>Book Vehicle</h2>
            <form method="post" name="myform" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="col-md-5 form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control firstname" id="firstname" placeholder="Enter First Name" name="firstname" value="<?php echo $results[0]->firstname; ?>" required>
                    </div>
					
					<div class="col-md-5 form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control lastname" id="lastname" placeholder="Enter Last Name" name="lastname" value="<?php echo $results[0]->lastname; ?>" required>
                    </div>
					
					<div class="col-md-10 form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control email" id="email" placeholder="Enter Email Id" name="email" value="<?php echo $results[0]->email; ?>" required>
                    </div>
					
					<div class="col-md-10 form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control phone" id="phone" placeholder="Enter Phone Number" name="phone" value="<?php echo $results[0]->phone; ?>" required>
                    </div>
                    
					<div class="col-md-10 form-group">
                        <label for="vehicleType">Vehicle Type:</label>
						
						
						
                        <select name="vehicleType"  class="form-control vehicleType" id="vehicleType"  placeholder="Enter Vehicle Type" onchange="select_type(this.value)" required>
						<option value="">Select Vehicle Type</option>
						
						<?php foreach($results_vehicle_categories as $vtype) { ?>
						<option value="<?php echo $vtype->vehicleType; ?>"><?php echo $vtype->vehicleType; ?></option>
						<?php } ?>
						</select>
                    </div>
					
                    <div class="col-md-10 form-group">
                        <label for="vehicleMake">Make:</label>
						
						<select name="vehicleMake"  class="form-control vehicleMake" id="vehicleMake" onchange="select_make(this.value)" disabled required>
						<option value="">Select Vehicle Make</option>
						
						
						</select>
                    </div>
					
					<div class="col-md-10 form-group">
                        <label for="vehicleModel">Model:</label>
						<select class="form-control vehicleModel" name="vehicleModel" id="vehicleModel" onchange="select_model(this.value)" disabled required>
						<option value="">Select Model</option>
                        </select>
                    </div>
  
					<div class="col-md-10 form-group">
                        <label for="datepickerfrom">Select Booking Dates:</label>
                    </div>
					
					<div class="col-md-5 form-group">
                        <label for="datepickerfrom">From:</label>
						<input type="date" id="datepickerfrom" class="form-control" style="padding:0px" name="from_date"  onchange="calculate_booking_days()" min="<?php echo date("Y-m-d"); ?>" disabled>
                    </div>
					
					<div class="col-md-5 form-group">
                        <label for="datepickerto">To:</label>
						<input type="date" id="datepickerto" class="form-control" style="padding:0px" name="to_date"  onchange="calculate_booking_days()" min="<?php echo date("Y-m-d"); ?>" disabled>
                    </div>
					
					<div class="col-md-5 form-group">
					 <label  id="total_days1"></label>
					 <input type="hidden" name="total_days" id="total_days">
					</div>
					
					
					<div class="col-md-12">
                    <button type="button" class="btn btn-success voucherSubmit" name="submit" onclick="calculate_price()">Calculate Price</button>
					</div>
					
					<div class="col-md-10 form-group">
                        <label for="message">Message:</label>
                        <textarea type="text" class="form-control message" col="50" rows="4" id="message" placeholder="Message" name="message"> </textarea>
                    </div>
                    

					<div class="col-md-10 form-group" id="vehicleDetails">
                        
					</div>	
					
                </div>
                
                <div class="col-md-12">
                    <button id="request_booking" type="submit" class="btn btn-success voucherSubmit" name="submit" disabled>Request Booking</button>
                </div>
            </form>
        </div>
    </body>
</html>




<script>

//ajax model
 function select_type(vehicleType) { 
 
 
	  if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
 } else {
    // code for old IE browsers
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
 
  if (vehicleType == '') { 
    //document.getElementById("txtHint").innerHTML = "";
	document.getElementById("vehicleMake").disabled = true;
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("vehicleMake").disabled = false;
        document.getElementById("vehicleMake").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "<?php echo plugin_dir_url( __FILE__ ); ?>getmakeinfo.php?q=" + vehicleType+"&type=type", true);
    xmlhttp.send();
  }
} 


//ajax make
 function select_make(vehicleMake) {
	 
	 vehicleType = document.getElementById("vehicleType").value;
	 
	 
	   if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
 } else {
    // code for old IE browsers
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
	 
  if (vehicleMake == '') { 
    //document.getElementById("vehicleModel").innerHTML = "";
	document.getElementById("vehicleModel").disabled = true;
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("vehicleModel").disabled = false;
		 document.getElementById('datepickerfrom').disabled = false;
		 document.getElementById('datepickerto').disabled = false;
        document.getElementById("vehicleModel").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "<?php echo plugin_dir_url( __FILE__ ); ?>getmakeinfo.php?q=" + vehicleMake+"&vehicleType="+vehicleType+"&type=make", true);
    xmlhttp.send();
  }
} 


//ajax Booking dates
function calculate_booking_days() {
	 
	 var from = document.getElementById('datepickerfrom').value;
	 
	if(from) {	
	document.getElementById('datepickerto').disabled = false;
	document.getElementById('datepickerto').min = from;
	}
	
	 var to = document.getElementById('datepickerto').value;
	 
	 
	 
	 if(from > to) {
	to = document.getElementById('datepickerto').value = document.getElementById('datepickerto').max;
	 }
	
		
	 if(from <= to) { 
	
  if (window.XMLHttpRequest) {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
 } else {
    // code for old IE browsers
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
   
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("total_days1").innerHTML = "Booking for "+this.responseText+" Day(s)";
     document.getElementById("total_days").value = this.responseText;
    }
  };
  
  xhttp.open("GET", "<?php echo plugin_dir_url( __FILE__ ); ?>getmakeinfo.php?q=" + vehicleModel+"&type=date&from="+from+"&to="+to, true);
  xhttp.send();
	 }
}

//ajax calculate_price
  function calculate_price() {
	  
	  vehicleModel = document.getElementById("vehicleModel").value;
	  vehicleType = document.getElementById("vehicleType").value;
	  vehicleMake = document.getElementById("vehicleMake").value;
	  total_days = document.getElementById("total_days").value;
	  
	  
	  if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
 } else {
    // code for old IE browsers
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
	  
  if (vehicleModel == '') { 
    //document.getElementById("vehiclePrice").innerHTML = "";
	document.getElementById("request_booking").disabled = true;
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("vehicleDetails").innerHTML = this.responseText;
        document.getElementById("request_booking").disabled = false;
      }
    };
    xmlhttp.open("GET", "<?php echo plugin_dir_url( __FILE__ ); ?>getmakeinfo.php?q=" + vehicleModel+"&vehicleType="+vehicleType+"&vehicleMake="+vehicleMake+"&total_days="+total_days+"&type=model", true);
    xmlhttp.send();
  }
}  
</script>



