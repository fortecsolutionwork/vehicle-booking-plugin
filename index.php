<?PHP
/*
Plugin Name:  Book Vehicles
Plugin URI:   http://fortecsolution.com/
Description:  Book Vehicles
Version:      1.0
Author:       Fortec Solution
Author URI:   http://fortecsolution.com/
License:      GPL2
*/

/*
* Plugin Activate Hook
*/
function bookVehicle_activate() {
    /* Add custom table */
    global $wpdb;
    $sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."vehicles`
    (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `vehicleName` longtext NOT NULL,
    `vehicleType` varchar(20) NOT NULL,
    `vehicleMake` longtext NOT NULL,
    `vehicleModel` varchar(20) NOT NULL,
    `vehiclePrice` longtext NOT NULL,
    `vehicleDesp` longtext NOT NULL,
    `vehicleImages` longtext NOT NULL,
    `vehicleCode` longtext NOT NULL,
    `vehicleStatus` longtext NOT NULL,
    PRIMARY KEY (`id`)
    )
    ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($sql);
       
    $sql1 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."vehicle_categories`
    (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `vehicleType` varchar(20) NOT NULL,
    `vehicleMake` longtext NOT NULL,
    `vehicleModel` varchar(20) NOT NULL,
    `vehicleStatus` longtext NOT NULL,
    PRIMARY KEY (`id`)
    )
    ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($sql1); 
	   
    $sql2 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."vehicle_bookings`
    (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `user_id` longtext NOT NULL,
    `firstname` longtext NOT NULL,
    `lastname` longtext NOT NULL,
    `email` longtext NOT NULL,
    `phone` varchar(20) NOT NULL,
    `vehicleType` longtext NOT NULL,
	`vehicleName` longtext NOT NULL,
	`vehicleMake` longtext NOT NULL,
	`vehicleModel` longtext NOT NULL,
	`vehiclePrice` longtext NOT NULL,
	`total_price` longtext NOT NULL,
	`datefrom` varchar(20) NOT NULL,
	`dateto` varchar(20) NOT NULL,
	`total_days` varchar(20) NOT NULL,
	`message` longtext NOT NULL,
	`status` varchar(10) NOT NULL,
    
    PRIMARY KEY (`id`)
    )
    ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($sql2);
	
	
}
register_activation_hook( __FILE__, 'bookVehicle_activate' );

/*
* Plugin Uninstall Hook
*/
function bookVehicle_uninstall() {
    /* Drop custom table */
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."vehicles" );
    $wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."vehicle_bookings" );

}
register_uninstall_hook(__FILE__, 'bookVehicle_uninstall');


/*
* Plugin Include Css & Js File
*/
function backend_js_css_for_create_form()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script("create_form-custom.js", plugins_url("assets/js/custom.js", __FILE__));
    wp_enqueue_script("create_form-bootstrap.js", plugins_url("assets/js/bootstrap.min.js", __FILE__));
    wp_enqueue_script("create_form-responsive_bootstrap.js", plugins_url("assets/js/jquery.min.js", __FILE__));	
    wp_enqueue_style("create_form-custom", plugins_url("assets/css/custom.css", __FILE__));
    wp_enqueue_style("create_form-dataTables.css", plugins_url("assets/css/bootstrap.css", __FILE__));
    wp_enqueue_style("create_form-datatables.css", plugins_url("assets/css/bootstrap.min.css", __FILE__));
}
add_action("init", "backend_js_css_for_create_form");

/*
* Include backend menu
*/
function add_vehicle_page()
{
    include_once plugin_dir_path(__FILE__). "include/add_vehicle.php";
}

function all_vehicles()
{
    include_once plugin_dir_path(__FILE__). "include/vehicles.php";
}

function add_categories_page()
{
    include_once plugin_dir_path(__FILE__). "include/add_categories.php";
}

function all_bookings_page()
{
    include_once plugin_dir_path(__FILE__). "include/all_bookings.php";
}

function info_page()
{
    include_once plugin_dir_path(__FILE__). "include/info.php";
}

/*
* Menu Sidebar Backend
*/
function sidebar_menu_create_form()
{
    add_menu_page("Book Vehicles","Book Vehicles", 'read', 'add_vehicle', 'create_form_page','');
	
    add_submenu_page( "add_vehicle","Add Vehicle","Add Vehicle", 'read', 'add_vehicle',  'add_vehicle_page');
    add_submenu_page( "add_vehicle","All Vehicles","All Vehicles", 'read', 'all_vehicles',  'all_vehicles');
	add_submenu_page( "add_vehicle","Categories","Categories", 'read', 'add_categories',  'add_categories_page');
	add_submenu_page( "add_vehicle","Bookings","Bookings", 'read', 'all_bookings',  'all_bookings_page');
	add_submenu_page( "add_vehicle","info","Info", 'read', 'info',  'info_page');
	
}
add_action("admin_menu", "sidebar_menu_create_form");

/*
* Add menu frontend
*/
function book_vehicle()
{
    include_once plugin_dir_path(__FILE__). "include/book_vehicle.php";
}
add_shortcode('book-vehicle-form', 'book_vehicle');



?>