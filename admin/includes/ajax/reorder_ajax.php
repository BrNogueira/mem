<?php
$table = $_POST['table'];
$array_id = $_POST['array_id'];
$array_ordem = $_POST['array_ordem'];

foreach($array_id as $var => $id){
	
	$ordem = $array_ordem[$var];
	
	$conn->query("UPDATE $table SET ordem = $ordem WHERE id = $id");
}
?>
