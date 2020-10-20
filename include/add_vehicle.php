<?php
    global $wpdb;
    $vehicle_table_name = $wpdb->prefix."vehicles";
    $vehicle_category_table_name = $wpdb->prefix."vehicle_categories";
    wp_enqueue_media();

    $id = $_GET['edit'];
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name WHERE id = $id " );
	
	$results_vehicle_categories = $wpdb->get_results( " SELECT * FROM  $vehicle_category_table_name" );
?>

<?php
    if(isset($_POST['submit']))
    {
        //$user_id = get_current_user_id();
        $vehicleName = $_POST['vehicleName']; 
        $vehicleImages = $_POST['vehicleImages']; 
        $vehicleType = $_POST['vehicleType']; 
        $vehicleDesp = $_POST['vehicleDesp']; 
        $vehicleMake = $_POST['vehicleMake']; 
        $vehicleModel = $_POST['vehicleModel']; 
        $vehiclePrice = $_POST['vehiclePrice']; 
		
		
        
		$query = $wpdb->update($vehicle_table_name, array('vehicleName' => $vehicleName, 'vehicleImages' => $vehicleImages, 'vehicleType' => $vehicleType, 'vehicleDesp' => $vehicleDesp, 'vehicleMake'=>$vehicleMake, 'vehicleModel' => $vehicleModel, 'vehiclePrice' => $vehiclePrice, 'vehicleStatus' => "0" ), 
			array( 'id' => $id )
		); 
		if($query == '1'){
		    $status_query = 2;
		}
        else {
            $sql = $wpdb->insert($vehicle_table_name, array('vehicleName' => $vehicleName, 'vehicleImages' => $vehicleImages, 'vehicleType' => $vehicleType, 'vehicleDesp' => $vehicleDesp, 'vehicleMake'=>$vehicleMake, 'vehicleModel' => $vehicleModel, 'vehiclePrice' => $vehiclePrice, 'vehicleStatus' => "0"  ) );
            if($sql == '1')
            {
                $status_query = 1;
                
            }
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
      
      <style>
        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
      </style>
      
    </head>
    <body>
        <div class="container">
		
		<div>
		<h4><?php if(isset($status_query) && $status_query == 1)  echo "Vehicle created successfully."; ?></h4>
		<h4><?php if(isset($status_query) && $status_query == 2)  echo "Vehicle updated successfully."; ?></h4>
		</div>
		
		
           <h2>Add Vehicle</h2>
            <form method="post" name="myform" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="col-md-10 form-group">
                        <label for="vehicleName">Name:</label>
                        <input type="text" class="form-control vehicleName" id="vehicleName" placeholder="Enter Vehicle Name" name="vehicleName" value="<?php echo $results[0]->vehicleName; ?>" required>
                    </div>
                    
					<div class="col-md-10 form-group">
                        <label for="vehicleType">Vehicle Type:</label>
						
						
						
                        <select name="vehicleType"  class="form-control vehicleType" id="vehicleType"  placeholder="Enter Vehicle Type" required>
						<option value="">Select Vehicle Type</option>
						
						<?php foreach($results_vehicle_categories as $vtype) { ?>
						<option value="<?php echo $vtype->vehicleType; ?>" <?php if($results[0]->vehicleType == $vtype->vehicleType ) echo "selected"; ?>><?php echo $vtype->vehicleType; ?></option>
						<?php } ?>
						</select>
                    </div>
					
                    <div class="col-md-10 form-group">
                        <label for="vehicleMake">Make:</label>
                        <input type="text" class="form-control vehicleMake" id="vehicleMake" placeholder="Enter Make" name="vehicleMake" value="<?php echo $results[0]->vehicleMake; ?>" required>
                    </div>
                    
                    <div class="col-md-10 form-group">
                        <label for="vehicleModel">Model:</label>
						<select class="form-control vehicleModel" name="vehicleModel" id="vehicleModel" required>
						<option value="">Select Model</option>
						<?php 
						
						$current_year = date(Y);
						
						for($i=2000; $i<=$current_year; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if($results[0]->vehicleModel == $i) echo "selected";?>>
						<?php echo $i; ?>
						</option>	
						<?php }
						
						?>
						
                        </select>
                    </div>

					<div class="col-md-10 form-group">
                        <label for="vehiclePrice">Price per Day($):</label>
                        <input type="number" class="form-control vehiclePrice" id="vehiclePrice" placeholder="Enter Vehicle Price" min=0 name="vehiclePrice" value="<?php echo $results[0]->vehiclePrice; ?>" required>
                    </div>
                    
                    <div class="col-md-10 form-group">
                        <label for="vehicleDesp">Description:</label>
                        <textarea name="vehicleDesp" rows="4" cols="50" class="form-control vehicleDesp" id="vehicleDesp" placeholder="Enter Vehicle Description" required><?php echo $results[0]->vehicleDesp; ?></textarea>
                    </div>
                    
                   <div class="col-md-10 form-group">
							<label for="vehicleImages">Add image:</label>
							<input type="text" class="form-control image col-10" name="vehicleImages" id="image" value="<?php echo $results['0']->vehicleImages; ?>" placeholder="Ajouter image" required>
							<button type="button" name="file" id="upload" class="upload btn btn-primary col-2"><span class="glyphicon glyphicon-upload"></span> Upload</button> 
					</div>	
					
                </div>
                
                <div class="col-md-12">
                    <?php if($_GET['edit'] == "") { ?><button type="submit" class="btn btn-success voucherSubmit" name="submit" style="margin-left: 15px;">Submit</button><?php } else { ?>
                    <button type="submit" class="btn btn-success voucherSubmit" name="submit" style="margin-left: 15px;">Update</button><?php } ?>
                </div>
            </form>
        </div>
    </body>
</html>
<script>
    /* Generate random code 
    function randomPassword(length) {
        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
        return pass;
    }
    
    function generate() {
        myform.row_password.value = randomPassword(myform.length.value);
    }*/
    
    /* Generate PDF */
    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };
    
    $('#cmd').click(function () {   
        doc.fromHTML($('#content').html(), 15, 15, {
            'width': 170,
                'elementHandlers': specialElementHandlers
        });
        doc.save('voucher-file.pdf');
    });
    
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

<script>
    jQuery(document).ready(function() {
    	var vid_thumb_file_frame;
    	 jQuery(".upload").on("click", function (event)
    	 { 
    	 event.preventDefault();
    	 vid_thumb_file_frame = wp.media.frames.vid_thumb_file_frame = wp.media
    	   ({
    		  button:
    			{
    			text: jQuery(this).data("uploader_button_text")
    			},
    		  multiple: true
    	   });
    	 vid_thumb_file_frame.on("select", function ()
    	 {
    		var selection = vid_thumb_file_frame.state().get("selection");
    		selection.map(function (attachment)
    		{
    		attachment = attachment.toJSON();
    		if (attachment.type === "image")
    		{
    		jQuery("#image").val(attachment.url);
    		}
    		});
    	 });
    	 vid_thumb_file_frame.open();
    	 });
    });
</script>



