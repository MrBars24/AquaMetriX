<?php 
	class Water extends Model{
		function __construct(){
			parent::__construct();
		}

		/* insert models */
		function create_log(){
			$data = parent::insert(TBL_LOG, array("device_id"=>$_POST["device"],"ph_level"=>$_POST["ph"],"temperature"=>$_POST["temperature"],"turbidity"=>$_POST["turbidity"]));

			if($data){
				return true;
			}	else{
				return false;
			}		
		}

		function create_user(){
			$data = parent::insert(TBL_USER, array("email"=>$_POST["email"],"firstname"=>$_POST["firstname"],"lastname"=>$_POST["lastname"],"user_type"=>"user"));

			if($data){
				return $this->get_user(parent::get_insert_id());
			}else{
				return false;
			}
		}

		function create_device(){
			$data = parent::insert(TBL_DEVICE, array("address"=>$_POST["address"],"lat"=>$_POST["latitude"],"lng"=>$_POST["longitude"],"user_id"=>$_POST["user_id"]));

			if($data){
				return $this->get_device(parent::get_insert_id());
			}else{
				return false;
			}
		}

		function create_notif(){
			$data = parent::insert(TBL_NOTIF, array("category"=>$_POST["category"],"title"=>$_POST["title"],"description"=>$_POST["desc"],"device_id"=>$_POST["id"]));

			if($data){
				return $this->get_notif(parent::get_insert_id());
			}else{
				return false;
			}
		}

		/* end insert models */

		/* update models */
		function update_notif($id){
			$data = parent::update(TBL_NOTIF,array("status"=>"read"),"id=$id");
			if($data){
				return true;
			}else{
				return false;
			}	
		}

		function update_user($id){
			$data = parent::update(TBL_USER,array("email"=>$_POST["email"],"firstname"=>$_POST["firstname"],"lastname"=>$_POST["lastname"]),"id=$id");
			if($data){
				return $this->get_user($id);
			}else{
				return false;
			}	
		}

		function update_device($id){
			$data = parent::update(TBL_DEVICE,array("address"=>$_POST["address"],"lat"=>$_POST["latitude"],"lng"=>$_POST["longitude"]),"device_id=$id");
			if($data){
				return $this->get_device($id);
			}else{
				return false;
			}	
		}

		/* end update models */

		/* delete models */
		function delete_user($id){
			$data = parent::select("*")->from(TBL_DEVICE)->where("user_id=$id")->get();

			if(count($data) > 0){
				foreach ($data as $value) {
					$this->delete_device($value["device_id"]);
				}
			}

			$data = parent::delete(TBL_USER,"id=$id");
			if($data){
				return true;
			}else{
				return false;
			}
		}

		function delete_device($device="",$id=""){
			$data = parent::delete(TBL_DEVICE,"device_id=$device");
			if($data){
				$this->delete_device_logs($device);
				return true;
			}else{
				return false;
			}
		}

		function delete_notif(){
			$data = parent::delete(TBL_NOTIF);
			if($data){
				return true;
			}else{
				return false;
			}	
		}

		function delete_device_logs($id){
			$data = parent::delete(TBL_LOG,"device_id=$id");
		}


		/* end delete models */

		/* get models */
		
		function get_user_login($user,$pass){
			$data = parent::select("*")->from("users")->where("email='$user' and password='$pass'")->get();
			if($data){
				$data = $data[0];
				if($data["user_type"]=="user"){
					$data["devices"] = parent::select("device_id, address, lat, lng, ph, temperature, turbidity")->from("device")->where("user_id=".$data["id"])->get();
				}else{
					$data["devices"] = parent::select("device_id, address, lat, lng, ph, temperature, turbidity")->from("device")->get();
				}
				return $data;
			}else{
				return 0;
			}
		}

		function get_user($id){
			$data = parent::select("*")->from("users")->where("id=$id")->get_first_row();
			if($data){
				$data["devices"] = $this->get_devices_count($data["id"]);
				return $data;
			}else{
				return null;
			}
		}

		function get_users(){
			$data = parent::select("*")->from("users")->where("user_type!='admin'")->order_by("id","DESC")->get();
			if($data){
				foreach ($data as $value) {
					$value["devices"] = $this->get_devices_count($value["id"]);
					$new_data[] = $value;
				}
				return $new_data;
			}else{
				return 0;
			}
		}

		function get_devices_count($id){
			$data = parent::select("*")->from("device")->where("user_id=$id")->get_count();
			if($data){
				return $data;
			}else{
				return 0;
			}			
		}

		function get_device($id){
			$data = parent::select("*")->from(TBL_DEVICE)->where("device_id=$id")->get_first_row();
			if($data){
				return $data;
			}else{
				return null;
			}
		}

		function get_time($date,$id){
			$data = parent::select("TIME(date_created) as time,ph_level,temperature,turbidity")->from(TBL_LOG)->where("DATE(date_created)='$date' AND device_id = $id")->get();
			if($data){
				return $data;
			}else{
				return null;
			}
		}

		function get_device_latest(){
			$data = parent::select("device_id, address, lat, lng")->from("device")->get();
			if($data){
				foreach ($data as $value) {
					$extend = $this->get_logs($value["device_id"],1,1)["results"][0];
					$rows[] = array("device_id"=>$value["device_id"],"address"=>$value["address"],"lat"=>$value["lat"],"lng"=>$value["lng"],"ph_level"=>$extend["ph_level"],"turbidity"=>$extend["turbidity"],"temperature"=>$extend["temperature"]);
				}
				return $rows;
			}else{
				return null;
			}
		}

		function get_user_device_latest($id){
			$data = parent::select("device_id, address, lat, lng")->from("device")->where("user_id=$id")->get();
			if($data){
				foreach ($data as $value) {
					$extend = $this->get_logs($value["device_id"],1,1)["results"][0];
					$rows[] = array("device_id"=>$value["device_id"],"address"=>$value["address"],"lat"=>$value["lat"],"lng"=>$value["lng"],"ph_level"=>$extend["ph_level"],"turbidity"=>$extend["turbidity"],"temperature"=>$extend["temperature"]);
				}
				return $rows;
			}else{
				return null;
			}
		}

		function get_user_device_list($id){
			$data = parent::select("*")->from(TBL_DEVICE)->where("user_id=$id")->get();
			if($data){
				foreach ($data as $value) {
					$extend = $this->get_logs($value["device_id"],1,1)["results"][0];
					$rows[] = array("device_id"=>$value["device_id"],"address"=>$value["address"],"lat"=>$value["lat"],"lng"=>$value["lng"],"ph_level"=>$extend["ph_level"],"turbidity"=>$extend["turbidity"],"temperature"=>$extend["temperature"]);
				}
				return $rows;
			}else{
				return null;
			}
		}

		function get_logs($id,$page,$offset){
			$data["results"] = parent::select("id, DATE(date_created) as `date`, TIME(date_created) as `time`,date_created,ph_level,temperature,turbidity")->from(TBL_LOG)->where("device_id=$id")->order_by("id","DESC")->limit($page,$offset)->get();
			$res = parent::select("COUNT(id) as total")->from(TBL_LOG)->where("device_id=$id")->get_first_row();
			$data["max_page"] = ceil($res["total"] / 10);
			return $data;
		}

		function get_logs_array($ids){
			$d = array();
			foreach ($ids as $value) {
				$temp = parent::select("id, device_id,DATE(date_created) as `date`, TIME(date_created) as `time`, date_created,ph_level,temperature,turbidity")->from(TBL_LOG)->where("device_id=$value")->order_by("id","DESC")->limit(1,20)->get();
				$d = array_merge($d,$temp);
			}

			$data["results"] = $d;

			return $data;
		}

		function get_notifs($id){
			$data = parent::select("notif.id, DATE(notif.date_created) as date, TIME(notif.date_created) as time, notif.category, notif.title, notif.description, notif.status, notif.device_id, device.address, device.user_id")->from(TBL_NOTIF)->join(TBL_DEVICE,"notif.device_id=device.device_id")->where("device.user_id=$id AND status IN ('unread', 'read')")->order_by("FIELD(status, 'unread', 'read'),date_created","DESC")->get();
			return $data;
		}

		function get_notif($id){
			$data = parent::select("id,DATE(notif.date_created) as date, TIME(notif.date_created) as time, notif.category, notif.title, notif.description, notif.status, notif.device_id, device.user_id, device.address")->from(TBL_NOTIF)->join(TBL_DEVICE,"notif.device_id=device.device_id")->where("id=$id")->get_first_row();
			return $data;
		}

		function get_report($id,$type,$date){
			$result["ph"] = $this->get_summary($id,$type,$date,"ph_level");
			$result["turbidity"] = $this->get_summary($id,$type,$date,"turbidity");
			$result["temperature"] = $this->get_summary($id,$type,$date,"temperature");

			return $result;
		}

		function get_report_admin($id,$type,$date){
			$result["ph"] = $this->get_summary_admin($id,$type,$date,"ph_level");
			$result["turbidity"] = $this->get_summary_admin($id,$type,$date,"turbidity");
			$result["temperature"] = $this->get_summary_admin($id,$type,$date,"temperature");

			return $result;
		}

		function get_summary($id,$type,$date,$cat){
			switch ($type) {
				case 'day': 
					$data = parent::select("ROUND(AVG($cat),2) as average, MAX($cat) as max, MIN($cat) as min")->from("water_data")->where("device_id = $id and DATE(date_created)='".$date."'")->get()[0];

					$data["data"] = parent::select("TIME(date_created) as date,$cat as val")->from("water_data")->where("device_id = $id and DATE(date_created)='".$date."'")->get();

					break;
				case 'month':
					$data = parent::select("ROUND(AVG($cat),2) as average, MAX($cat) as max, MIN($cat) as min")->from("water_data")->where("device_id = $id and MONTH(date_created)='".get_date("month",$date)."' and YEAR(date_created)='".get_date("year",$date)."'")->get()[0];

					$data["data"] = parent::select("DATE(date_created) as date,$cat as val")->from("water_data")->where("device_id = $id and MONTH(date_created)='".get_date("month",$date)."' and YEAR(date_created)='".get_date("year",$date)."'")->group_by("DATE(date_created)")->get();

					break;
				case 'year':
					$data = parent::select("ROUND(AVG($cat),2) as average, MAX($cat) as max, MIN($cat) as min")->from("water_data")->where("device_id = $id and MONTH(date_created)='".get_date("month",$date)."' and YEAR(date_created)='".get_date("year",$date)."'")->get()[0];

					$data["data"] = parent::select("MONTHNAME(date_created) as date,$cat as val")->from("water_data")->where("device_id = $id and YEAR(date_created)='".get_date("year",$date)."'")->group_by("MONTH(date_created)")->get();
					break;
			}

			return $data;
		}

		function get_summary_admin($id,$type,$date,$cat){
			switch ($type) {
				case 'month':
					$data["data"] = parent::select("DATE(date_created) as date,ROUND(AVG($cat),2) as val")->from("water_data")->where("device_id = $id and MONTH(date_created)='".get_date("month",$date)."' and YEAR(date_created)='".get_date("year",$date)."'")->group_by("DATE(date_created)")->get();

					break;
				case 'year':
					$data["data"] = parent::select("MONTHNAME(date_created) as date,ROUND(AVG($cat),2) as val")->from("water_data")->where("device_id = $id and YEAR(date_created)='".get_date("year",$date)."'")->group_by("MONTH(date_created)")->get();
					break;
			}

			return $data;
		}

		function update_views($id){
			$data["views"] = parent::update("app_conf",
				array("value"=>"value + 1"),"app_id=$id and settings='views'","value=value + 1  ");

			if($data){
				return $this->get_views($id);
			}else{
				return false;
			}
		}

		function get_views($id){
			$data["views"] = parent::select("value")->from("app_conf")
			->where("app_id=$id and settings='views'")->get_first_row();

			return $data;
		}

		/* end get models */
	}
?>