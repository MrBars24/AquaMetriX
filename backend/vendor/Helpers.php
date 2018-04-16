<?php 
	function load($name){
		$ctrl = "./app/controller/$name.php";
		include $ctrl;
	}

	function get_date($type,$date){
		$ex = explode("-", $date);
		switch ($type) {
			case 'day':
				return $ex[2];
			case 'month':
				return $ex[1];
			case 'year':
				return $ex[0];
		}
	}
?>