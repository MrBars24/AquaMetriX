<?php
	class Controller{
		function __construct(){

		}

		function load_model($name){
			$name = strtolower($name);
			$temp = "./app/models/$name.php";
			include $temp;
			$this->$name = new $name();
		}
	}
?>