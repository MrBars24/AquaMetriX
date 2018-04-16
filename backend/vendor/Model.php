<?php
	class Model{
		protected $conn;
		private $sql;
		function __construct(){
			$this->conn = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
		}

		function select($fields){
			if(gettype($fields)=="string"){
				$this->sql = "SELECT $fields ";
			}else{
				foreach ($fields as $value) {
					$field = $value . ", ";
				}
				$field = substr($field, 0, strlen($field) - 2);
				$this->sql = "SELECT $field ";
			}

			return $this;
		}

		function from($table){
			$this->sql .= "FROM $table ";
			return $this;
		}

		function where($where){
			if(gettype($where)=="string"){
				$this->sql .= "WHERE $where ";
				return $this;
			}
		}

		function join($table,$on,$custom=""){
			$this->sql .= "INNER JOIN $table ON $on ";
			if($custom!=null){
				$this->sql = str_replace("INNER", $custom, $this->sql_string);
			}
			return $this;
		}

		function group_by($field){
			$this->sql .= "GROUP BY $field";

			return $this;
		}

		function custom_where($where){
			$this->sql .= "$where ";
		}

		function limit($page,$offset){
			$page = $offset * ($page - 1);
			$this->sql .= "LIMIT $page,$offset ";
			return $this;
		}

		function order_by($field,$order = "ASC"){
			if(gettype($field)=="string"){
				$this->sql .= " ORDER BY $field $order ";	
				return $this;
			}else{
				foreach ($field as $value) {
					$f = "$value, ";
				}
				$f = substr($f, 0, strlen($f) - 2);
				$this->sql .= "ORDER BY $f $order";
				return $this;
			}
		}

		function get_insert_id(){
			return mysqli_insert_id($this->conn);
		}

		function insert($table,$insert){
			$str = "INSERT INTO $table SET ";
			foreach ($insert as $key => $value) {
				$str .= "$key = '$value', ";
			}
			$str = substr($str, 0, strlen($str) - 2);
			$this->conn->query($str);
			if($this->conn->affected_rows > 0){
				return true;
			}else{
				return false;
			}
		}

		function update($table,$insert,$where,$custom=""){
			$str = "UPDATE $table SET ";
			if($custom!=""){
				$str .= $custom;
			}else{
				foreach ($insert as $key => $value) {
					$str .= "$key = '$value', ";
				}
			}
			$str = substr($str, 0, strlen($str) - 2);
			$str.= " WHERE $where";

			$result = mysqli_query($this->conn,$str);
			if(mysqli_affected_rows($this->conn) > 0){
				return true;
			}
		}

		function delete($table,$where=""){
			if($where!=""){
				$str = "DELETE FROM $table WHERE $where";
			}else{
				$str = "DELETE FROM $table";
			}
			$result = mysqli_query($this->conn,$str);
			if(mysqli_affected_rows($this->conn) > 0){
				return true;
			}

			return false;
		}

		function get($table="",$fields="",$where="",$order="",$limit=""){
			//echo $this->sql;
			if(!empty($table)){
				$this->sql = "SELECT * FROM $table";
			}
			
			$result = $this->conn->query($this->sql);
			if($result->num_rows > 0){
				while($data = $result->fetch_assoc()){
					$row[] = $data;
				}
				return $row;
			}else{
				return null;
			}
		}

		function get_first_row($table="",$fields="",$where="",$order="",$limit=""){
			return $this->get($table,$fields,$where,$order,$limit)[0];
		}

		function get_count(){
			$result = $this->conn->query($this->sql);
			return $result->num_rows;
		}

		function print(){
			echo $this->sql;
		}
	}
?>