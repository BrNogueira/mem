<?php

class Update extends Db{
	
	function __construct(){
		
	}
	
	public function updateDefault($table, $field_value, $id){
		
		$conn = Db::connect();
		
		if($conn->query("UPDATE $table SET $field_value WHERE id = $id")){
			
			return TRUE;
		}
	}
}

?>