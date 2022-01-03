<?php

foreach($_POST as $var => $post){
			
	if($var == 'tabela'){
		
		$table = $_POST[$var];
		unset($_POST[$var]);
	}
}

$ordem 	= $_POST['ordem'];
$id 	= $_POST['id'];

if(isset($_POST['ordem_up'])){
	
	$ordem_up = $_POST['ordem_up'];
	$conn->query("UPDATE ".$table." SET ordem = $ordem WHERE ordem = $ordem_up") or die($conn->error());
	$conn->query("UPDATE ".$table." SET ordem = $ordem_up WHERE ordem = $ordem AND id = $id") or die($conn->error());
}elseif(isset($_POST['ordem_down'])){
	
	$ordem_down = $_POST['ordem_down'];
	$conn->query("UPDATE ".$table." SET ordem = $ordem WHERE ordem = $ordem_down") or die($conn->error());
	$conn->query("UPDATE ".$table." SET ordem = $ordem_down WHERE ordem = $ordem AND id = $id") or die($conn->error());
}

$acao = TRUE;

?>