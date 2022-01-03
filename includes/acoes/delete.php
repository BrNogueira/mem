<?php

foreach($_POST as $var => $post_base64){
			
	if(base64_decode($var) == 'tabela'){
		
		$table = $_POST[$var];
		unset($_POST[$var]);
	}
}

$id = $_POST['id'];

$select_fields	= '*';			
$select_table	= $table;	
$select_join	= '';			
$select_where	= 'WHERE id = '.$id;
$select_group	= '';
$select_order	= '';
$select_limit 	= 'LIMIT 1';
$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
$result = $consulta->fetch_array();

if(file_exists($result['imagem'])){
		
	unlink($result['imagem']);
}

if($delete->delete($table, $id)){
	
	$acao = TRUE;
}

?>