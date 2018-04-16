<?php
	class Water_API_Controller extends Controller{
		function __construct(){
			$this->load_model("Water");
		}

		/* insert functions */
		function insert_log(){
			$data = $this->water->create_log();
			if($data){
				echo "success";
			}else{
				echo "failed";
			}
		}

		function insert_user(){
			$data = $this->water->create_user();
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		function insert_device(){
			$data = $this->water->create_device();
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		function insert_notif(){
			$data = $this->water->create_notif();
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		/* end insert functions */

		/* delete functions */
		function delete_device($id){
			$data = $this->water->delete_device($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		function delete_user($id){
			$data = $this->water->delete_user($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}	
		}

		function delete_notif(){
			$data = $this->water->delete_notif();
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}	
		}



		/* end delete functions */

		/* update functions */
		function update_notification($id){
			$data = $this->water->update_notif($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		function update_user($id){
			$data = $this->water->update_user($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		function update_device($id){
			$data = $this->water->update_device($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}else{
				echo 0;
			}
		}

		/* end update functions */

		/* get functions */
		
		function user_login(){
			$email = $_POST["email"];
			$pass = $_POST["password"];

			$data = $this->water->get_user_login($email,$pass);
			if($data!=0){
				$user = array("id"=>$data["id"],"email"=>$data["email"],"firstname"=>$data["firstname"],"lastname"=>$data["lastname"],"user_type"=>$data["user_type"],"devices"=>$data["devices"]);
				header("Content-Type:application/json");
				echo json_encode($user);
			}
		}

		function get_user($id){
			$data = $this->water->get_user($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);	
			}
		}

		function get_user_list(){
			$data = $this->water->get_users();
			if($data!=0){
				header("Content-Type:application/json");
				echo json_encode($data);
			}
		}

		function get_user_device_list($id){
			$data = $this->water->get_user_device_list($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}	
		}

		function get_device_latest(){
			$data = $this->water->get_device_latest();
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}	
		}

		function get_user_device_latest($id){
			$data = $this->water->get_user_device_latest($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}	
		}

		function get_device_logs($id,$page,$offset){
			$data = $this->water->get_logs($id,$page,$offset);
			if($data!=0){
				header("Content-Type:application/json");
				echo json_encode($data);
			}	
		}

		function get_device_logs_array($arr){
			$data = $this->water->get_logs_array($arr);
			if($data!=0){
				header("Content-Type:application/json");
				echo json_encode($data);
			}	
		}

		function get_user_notifs($id){
			$data = $this->water->get_notifs($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}
		}

		function get_instinct_notifs($id){
			$data = $this->water->get_notif($id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}
		}

		function get_time($date,$id){
			$data = $this->water->get_time($date,$id);
			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}
		}

		function get_reports($id,$type,$date){
			switch($type){
				case "day":
						$data["result"] = $this->water->get_report($id,$type,$date);
						break;
				case "month":
						$data["result"] = $this->water->get_report($id,$type,$date);
						break;
				case "year":
						$data["result"] = $this->water->get_report($id,$type,$date);
						break;
			}

			if($data!=null){
				header("Content-Type:application/json");
				echo json_encode($data);
			}
		}

		function get_admin_reports($type,$date){
			$overall;
			foreach ($_GET["dev"] as $value) {
				switch($type){
					case "day":
							$data = $this->water->get_report_admin($value["val"],$type,$date);
							break;
					case "month":
							$data = $this->water->get_report_admin($value["val"],$type,$date);
							break;
					case "year":
							$data = $this->water->get_report_admin($value["val"],$type,$date);
							break;
				}
				$overall[$value["name"]] = $data;
				$data = null;
			}
			if($overall!=null){
				header("Content-Type:application/json");
				echo json_encode($overall);
			}
		}

		function get_views($id){
			$data = $this->water->get_views($id);
			header("Content-Type:application/json");
			echo json_encode($data);
		}

		function add_views($id){
			$data = $this->water->update_views($id);
			header("Content-Type:application/json");
			echo json_encode($data);
		}

		/* end get functions */		
	}
?>