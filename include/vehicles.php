<?php
    global $wpdb;
    $vehicle_table_name = $wpdb->prefix."vehicles";
    
    if(isset($_GET['delete']) && $_GET['delete'] != ""){
        $delete = $wpdb->delete( $vehicle_table_name , array( 'id' => $_GET['delete'] ), array( '%d' )); 
        
        if($delete == 1){
            header( 'Location: admin.php?page=all_vehicles&&Msg=true' );
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
            	 if(isset($status_query) && $status_query == 3)
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
             if(isset($status_query) && $status_query == 1) 
			 {
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
             if(isset($status_query) && $status_query == 2) {
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
                        <th>Vehicle Name</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle Make</th>
                        <th>Vehicle Model</th>
                        <th>Vehicle Price per Day</th>
						<th>Vehicle Description</th>
						<th>Images</th>
						<th>Single Vehicle Shortcode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
                        $vehicleResult = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name " ); $i = 1;
                        foreach ($vehicleResult as $vehicleValue)
                        { 
                    ?> 
                    <tr>
                        <td><?php echo $i; ?></td>
						<td><?php echo $vehicleValue->vehicleName; ?></td>
						<td><?php echo $vehicleValue->vehicleType; ?></td>
                        <td><?php echo $vehicleValue->vehicleMake; ?></td>
                        <td><?php echo $vehicleValue->vehicleModel; ?></td>
                        <td><?php echo $vehicleValue->vehiclePrice; ?></td>
						<td><?php echo $vehicleValue->vehicleDesp; ?></td>
                        <td><img src="<?php echo $vehicleValue->vehicleImages; ?>" style="width: 100px; height: 100px;"></td>
                        <td><?php echo $vehicleValue->vehicleName; ?><br>
						[vehicle_code id=<?php echo $vehicleValue->id; ?>]</td>
                        <td>
                            <a href="admin.php?page=add_vehicle&&edit=<?php echo $vehicleValue->id; ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                            <a href="admin.php?page=all_vehicles&&delete=<?php echo $vehicleValue->id; ?>"><button type="button" class="btn btn-danger" style="margin-top: 10px;">Delete</button></a>
                        </td>
                    </tr>
                    <?php 
                        $i++; } 
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
