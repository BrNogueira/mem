<?php

$id = (int)$_GET['id'];
$table = $_GET['tabela'];
$name = $_GET['name'];
	
$query = $conn->query("SELECT * FROM {$table} WHERE id = {$id} LIMIT 1");
$result = $query->fetch_array();

if(isset($result[$name]) && !empty($result[$name]) && file_exists($result[$name])){
	
	unlink($result[$name]);
}

if($conn->query("UPDATE {$table} SET {$name} = '' WHERE id = {$id}")){
	
	$_SESSION['sucesso'] = 'Ação efetuada com sucesso!';
	echo '<script>history.go(-1)</script>';
}else{
	
	$_SESSION['aviso'] = 'Falha ao efetuar ação!';
	echo '<script>history.go(-1)</script>';
}

?>