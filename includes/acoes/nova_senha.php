
<?php

$hash = $_POST['hash'];
$senha = md5($_POST['senha']);

$query = $conn->query("SELECT * FROM usuario WHERE MD5(rand) = '{$hash}' LIMIT 1");
$result = $query->fetch_array();
	
if($conn->query("UPDATE usuario SET senha = '{$senha}' WHERE id = {$result['id']}")){
	
	$conn->query("UPDATE usuario SET rand = '' WHERE id = {$result['id']}");
	
	$_SESSION['sucesso'] = "<b>Nova senha cadastrada com sucesso!</b>";
	header("Location: {$_SERVER['HTTP_REFERER']}");
}else{
	
	$_SESSION['sucesso'] = "Não foi possível cadastrar sua nova senha.";
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

?>