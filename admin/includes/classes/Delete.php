<?php

class Delete extends Db{
	
	function __construct(){
		
	}
	
	public function delete($table, $id){
		
		$conn = Db::connect();
		
		$del = $conn->query("DELETE FROM $table WHERE id = $id") or die($conn->error());
		return TRUE;
	}
}

?>