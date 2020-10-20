<?php
    global $wpdb;
    $vehicle_table_name = $wpdb->prefix."vehicle_categories";
    wp_enqueue_media();

    $id = $_GET['edit'];
	
	if(isset($_GET['edit']))
	$results_cat_edit = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name where id=$id" );
	
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name" );
	
	
	//delete category
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
        $vehicleType = $_POST['vehicleType'];
		
		
        
		$query = $wpdb->update($vehicle_table_name, array('vehicleType' => $vehicleType), 
			array( 'id' => $id )
		); 
		if($query == '1'){
		    $status_query = 2;
             
		}
        else {
            $sql = $wpdb->insert($vehicle_table_name, array('vehicleType' => $vehicleType) );
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
           <h2>Vehicle Type</h2>
		  
		  <div>
		<h4><?php if(isset($status_query) && $status_query == 1)  echo "Category created successfully."; ?></h4>
		<h4><?php if(isset($status_query) && $status_query == 2)  echo "Category updated successfully."; ?></h4>
		<h4><?php if(isset($status_query) && $status_query == 3)  echo "Category deleted successfully."; ?></h4>
		</div>
		  
		  <div class="form-group col-lg-12 col-12  float-left" style="margin-top:20px;">
            <form method="post" name="myform" enctype="multipart/form-data">
                    
					<div class="col-md-10 form-group">
                        <label for="vehicleType">Vehicle Type:</label>
                        <input name="vehicleType"  class="form-control vehicleType" id="vehicleType" value="<?php echo $results_cat_edit[0]->vehicleType; ?>" placeholder="Enter Vehicle Type" required>
                    </div>
					
                
                <div class="col-md-12">
                    <?php if($_GET['edit'] == "") { ?><button type="submit" class="btn btn-success voucherSubmit" name="submit">Add Vehicle Type</button><?php } else { ?>
                    <button type="submit" class="btn btn-success voucherSubmit" name="submit" >Update Vehicle Type</button><?php } ?>
                </div>
            </form>
        </div>
		
		<div class="col-lg-12 col-12 float-left"  style="margin-top:20px;">
		<table id="example" class="table table-striped table-bordered" style="margin-top:20px; width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehical Type</th>
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
						<td><?php echo $vehicleValue->vehicleType; ?></td>
                        <td>
                            <a href="admin.php?page=add_categories&&edit=<?php echo $vehicleValue->id; ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                            <a href="admin.php?page=add_categories&&delete=<?php echo $vehicleValue->id; ?>"><button type="button" class="btn btn-danger" >Delete</button></a>
                        </td>
                    </tr>
                    <?php 
                        $i++; } 
                    ?>
                </tbody>
            </table>
		
		</div>
		</div>
    </body>
</html>





