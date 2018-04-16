<?php 
	header("Allow-Access-Controll-Orgin:*");
	include 'vendor/Autoload.php';
	$method = $_SERVER['REQUEST_METHOD'];
	if(isset($_SERVER['PATH_INFO'])){
		$request = explode("/", $_SERVER['PATH_INFO']);
	}

	//insert device log temp, turbidity, phLevel
	if(preg_match("/^\/api\/v1\/device\/log$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->insert_log();
		}
	}

	//insert user details
	if(preg_match("/^\/api\/v1\/user$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->insert_user();
		}
	}

	//insert device details with user
	if(preg_match("/^\/api\/v1\/device$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->insert_device();
		}
	}

	//update notification status
	if(preg_match("/^\/api\/v1\/read\/notification\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->update_notification($request[5]);
		}
	}

	//update user details
	if(preg_match("/^\/api\/v1\/user\/update\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->update_user($request[5]);
		}
	}

	//update user device
	if(preg_match("/^\/api\/v1\/device\/update\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->update_device($request[5]);
		}
	}

	//user login
	if(preg_match("/^\/api\/v1\/user\/login$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->user_login();
		}
	}

	//device notification
	if(preg_match("/^\/api\/v1\/device\/notification$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->insert_notif();
		}
	}

	//get list of users
	if(preg_match("/^\/api\/v1\/user\/list$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_user_list();
		}
	}

	//get user details
	if(preg_match("/^\/api\/v1\/user\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_user($request[4]);
		}
	}
	
	//get device list according to user id
	if(preg_match("/^\/api\/v1\/device\/list\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_user_device_list($request[5]);	
		}
	}

	//get device latest
	if(preg_match("/^\/api\/v1\/device\/latest$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_device_latest();	
		}
	}

	//get device latest
	if(preg_match("/^\/api\/v1\/device\/latest\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_user_device_latest($request[5]);	
		}
	}

	//get log details of specific device
	if(preg_match("/^\/api\/v1\/device\/log\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			header("Allow-Access-Control-Orgin:*");
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			if(isset($_GET["page"])&&isset($_GET["offset"])){
				$api->get_device_logs($request[5],$_GET["page"],$_GET["offset"]);		
			}
		}
	}

	//get log details of many device
	if(preg_match("/^\/api\/v1\/device\/logs$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			header("Allow-Access-Control-Orgin:*");
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			if(isset($_GET["ids"])){
				$api->get_device_logs_array($_GET["ids"]);
				//$api->get_device_logs($request[5],$_GET["page"],$_GET["offset"]);		
			}
		}
	}

	//get user notification
	if(preg_match("/^\/api\/v1\/notification\/user\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			header("Allow-Access-Control-Orgin:*");
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_user_notifs($request[5]);	
		}
	}

	//get single notification
	if(preg_match("/^\/api\/v1\/notification\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			header("Allow-Access-Control-Orgin:*");
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_instinct_notifs($request[4]);	
		}
	}

	if(preg_match("/^\/api\/v1\/report\/device\/\d+\/(year|month|day)\/\d{4}-\d{1,2}-\d{1,2}$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_reports($request[5],$request[6],$request[7]);
		}
	}

	if(preg_match("/^\/api\/v1\/report\/admin\/(year|month|day)\/\d{4}-\d{1,2}-\d{1,2}$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_admin_reports($request[5],$request[6]);
		}
	}

	if(preg_match("/^\/api\/v1\/device\/delete\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->delete_device($request[5]);
		}
	}

	if(preg_match("/^\/api\/v1\/user\/delete\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->delete_user($request[5]);
		}
	}

	if(preg_match("/^\/api\/v1\/device\/notification\/delete$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->delete_notif();
		}
	}

	if(preg_match("/^\/api\/v1\/time\/\d{4}-\d{1,2}-\d{1,2}\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_time($request[4],$request[5]);
		}
	}

	if(preg_match("/^\/api\/v1\/views\/\d+$/", $_SERVER['PATH_INFO'])){
		if($method=="POST"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->add_views($request[4]);
		}

		if($method=="GET"){
			load("Water_API_Controller");
			$api = new Water_API_Controller();
			$api->get_views($request[4]);	
		}
	}

	if(preg_match("/^$/", $_SERVER['PATH_INFO'])){
		
	}
	//SELECT AVG(ph_level) as average FROM water_data WHERE device_id = 2 and YEAR(date_created) = 2016
	//SELECT AVG(ph_level) as average FROM water_data WHERE device_id = 2 and MONTH(date_created) = 2016
	//SELECT AVG(ph_level) as average FROM water_data WHERE device_id = 2 and DAY(date_created) = 2016
?>