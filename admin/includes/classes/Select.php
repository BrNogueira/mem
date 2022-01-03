<?php 

class Select extends Db{
	
	function __construct(){
		
	}
	
	public function selectAll($table){
		
		$conn = Db::connect();
			
		$sql = $conn->query("SELECT * FROM $table") or die($conn->error());
		return $sql;
	}
	
	public function selectAllCondition($table, $conditions){
		
		$conn = Db::connect();
		
		$sql = $conn->query("SELECT * FROM $table $conditions") or die($conn->error());
		return $sql;
	}
	
	public function selectWhere($fields, $table, $join, $conditions){
		
		$conn = Db::connect();
		
		$sql = $conn->query("SELECT $fields FROM $table $join $conditions") or die($conn->error());
		return $sql;
	}
	
	public function selectDefault($fields, $table, $join, $where, $group, $order, $limit){
		
		$conn = Db::connect();
		
		$sql = $conn->query("SELECT $fields FROM $table $join $where $group $order $limit") or die($conn->error());
		return $sql;
	}

}
	
?>