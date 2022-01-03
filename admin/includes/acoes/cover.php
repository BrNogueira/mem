<?php foreach($_POST as $var => $post){
			
	if($var == 'tabela'){
		
		$table = $_POST[$var];
		unset($_POST[$var]);
	}
}

$field 		= $_POST['field'];
$id_master 	= $_POST['id_master'];
$id 		= $_POST['id'];

$conn->query("UPDATE ".$table." SET capa = 'f' WHERE $field = $id_master");
$conn->query("UPDATE ".$table." SET capa = 't' WHERE id = $id");

$acao = TRUE;

$_SESSION['alerta']['ok'] = 'Atualizado com sucesso!';
header("Location: {$_SERVER['HTTP_REFERER']}");
?>