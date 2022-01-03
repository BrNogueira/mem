<?php

class Insert extends Db{
	
	function __construct(){
		
	}
	
	public function insertDefault($table, $fields, $values){
		
		$conn = Db::connect();
		
		$set = $conn->query("INSERT INTO $table ($fields) VALUES ($values)") or die($conn->error());
		return $conn->insert_id;
	}
}

?>