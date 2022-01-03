<?php 
session_start();

function anti_injection($sql){
	
	//$sql = @preg_replace(@sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
}

if(!isset($_SESSION['login']) && isset($_POST['login'])){
	
	$login = anti_injection($_POST['login']);
	$senha = md5(anti_injection($_POST['senha']));
	
	$consulta = $conn->query("SELECT * FROM admin WHERE login = '$login' AND senha = '$senha'");
					   
 	if($consulta->num_rows == 0){
		
		$_SESSION['aviso']['alerta'] = "
		<div class='alert alert-danger'>
			<button type='button' class='close fade in' data-dismiss='alert'>&times;</button>
			Usuário ou senha inválido!
		</div>";
		
		header("location: $_SERVER[HTTP_REFERER]");
	}else{
		
		$dados = $consulta->fetch_array();
		
		$_SESSION['login'] = array();
		
		$_SESSION['login'] = $dados;
		
		$_SESSION['data'] = date('Y-m-d H:i:s');
		$data_hora = $_SESSION['data'];
		$id_admin = $_SESSION['login']['id'];
		
		$conn->query("INSERT INTO log (id_admin, data_hora) VALUES ($id_admin, '$data_hora')") or die($conn->error());
		
		$usuario = $_SESSION['login']['nome'];
		
		$_SESSION['aviso']['ok'] = "
		<div class='alert alert-success'>
			<button type='button' class='close fade in' data-dismiss='alert'>&times;</button> Bem Vindo, ".$usuario."!
		</div>";
		
		header("location:".$urlC."home");
	}
    
}elseif(isset($_SESSION['login'])){
	
	$_SESSION['aviso']['ok'] = 'Você já está logado';	
	header("location:".$urlC."home");
}else{
	
}

 ?>