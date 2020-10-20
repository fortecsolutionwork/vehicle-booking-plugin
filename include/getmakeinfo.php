<?php
    global $wpdb;
    define('WP_USE_THEMES', false);
    //require_once( $_SERVER['DOCUMENT_ROOT'].'/freshp/wp-load.php' );
    require_once( $_SERVER['DOCUMENT_ROOT'].'/freshp/wp-load.php' );
	
	
	if(isset($_GET['q']))
	{
		$type = $_GET['q'];
	}
	
	if(isset($_GET['vehicleType']))
	{
		$vehicleType = $_GET['vehicleType'];
	}
	
	if(isset($_GET['vehicleMake']))
	{
		$vehicleMake = $_GET['vehicleMake'];
	}
	
	if(isset($_GET['total_days']))
	{
		$total_days = $_GET['total_days'];
	}
	
	
   
	$vehicle_table_name = $wpdb->prefix."vehicles";
	
    wp_enqueue_media();

    $id = $_GET['edit'];
	if($_GET['type'] == "type") {
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name where vehicleType = '".$type."'" );
	} 
	if($_GET['type'] == "make") {
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name where  vehicleType = '".$vehicleType."' AND vehicleMake = '".$type."'" );
	}
	if($_GET['type'] == "model") {
	$results = $wpdb->get_results( " SELECT * FROM  $vehicle_table_name where vehicleType = '".$vehicleType."' AND vehicleMake = '".$vehicleMake."' AND vehicleModel = '".$type."'" );
	}

if($_GET['type'] == "type") {

?>

<option value="">Select Vehicle Make</option>
<?php foreach($results as $results) { ?>
<option value="<?php echo $results->vehicleMake; ?>" >
<?php echo $results->vehicleMake; ?>
</option>

<?php } 
}

if($_GET['type'] == "make") {

?>

<option value="">Select Model</option>
<?php foreach($results as $results) { ?>
<option value="<?php echo $results->vehicleModel; ?>" >
<?php echo $results->vehicleModel; ?>
</option>

<?php } 
}
if($_GET['type'] == "date") {

if(isset($_GET['from'])) {
	
	
$from = $_GET['from'];
$to = $_GET['to'];


$diff = date_diff(date_create($to), date_create($from));

echo $diff->format('%a');

}
else
{
	echo "";
}

}

if($_GET['type'] == "model") {
	
$price_one_day = $results[0]->vehiclePrice;
$price = $total_days * $price_one_day;
?>

	<div class="col-md-10 form-group">
                        <label for="vehiclePrice">Price per Day: <span> $<?php echo $results[0]->vehiclePrice; ?></span></label>
                        <input type="hidden" class="form-control vehiclePrice" id="vehiclePrice" placeholder="Enter Vehicle Price" min=0 name="vehiclePrice" value="<?php echo $results[0]->vehiclePrice; ?>" readonly required>
                    </div>
					
	<div class="col-md-10 form-group">
                        <label for="vehiclePrice">Price for <?php echo $total_days; ?> Day(s): <span> $<?php echo $price; ?></span></label>
                        <input type="hidden" class="form-control vehiclePrice" id="vehiclePrice" placeholder="Enter Vehicle Price" min=0 name="vehicleBookingPrice" value="<?php echo $price; ?>" readonly required>
                    </div>
                    
                    <div class="col-md-10 form-group">
                        <label for="vehicleDesp">Description: <span><?php echo $results[0]->vehicleDesp; ?></span></label>
                        <input type="hidden" name="vehicleDesp" class="form-control vehicleDesp" value="<?php echo $results[0]->vehicleDesp; ?>" id="vehicleDesp" placeholder="Enter Vehicle Description" required>
                    </div>
                    
                   <div class="col-md-10 form-group">
							<img class="img-responsive" name="vehicleImages" id="image" src="<?php echo $results['0']->vehicleImages; ?>" > 
	</div>	

<?php } 

?>