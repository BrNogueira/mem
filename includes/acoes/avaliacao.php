
<?php
$query = $conn->query("SELECT * FROM avaliacao WHERE id_usuario = {$_SESSION['cliente_dados']['id']} AND id_produto = {$_POST['id']}");

if($query->num_rows == 1){
	
	$conn->query("UPDATE avaliacao SET nota = {$_POST['nota']} WHERE id_usuario = {$_SESSION['cliente_dados']['id']} AND id_produto = {$_POST['id']}");
}else{
	
	$conn->query("INSERT INTO avaliacao (nota, id_usuario, id_produto) VALUES ({$_POST['nota']}, {$_SESSION['cliente_dados']['id']},  {$_POST['id']})");
}

header("Location: {$_SERVER['HTTP_REFERER']}");
?>