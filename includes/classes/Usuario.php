<?php 

class Usuario extends Db{

	public function getUsuarioLogin($login, $senha){
		
		$conn = Db::connect();
		
		$usuario_login = $conn->query("SELECT * FROM usuario WHERE email = '$login' AND senha = '$senha' AND ativo = 't'");
		return $usuario_login->num_rows;
	}

	public function getUsuarioLogado($login, $senha){
		
		$conn = Db::connect();
		
		$usuario_logado = $conn->query("SELECT * FROM usuario WHERE email = '$login' AND senha = '$senha' AND ativo = 't'");
		return $usuario_logado->fetch_array();
	}
	
	public function getUsuarios(){
		
		$conn = Db::connect();
		
		$usuarios = $conn->query("SELECT * FROM usuario");
		return $usuarios->fetch_array();
	}
	
	public function updatePass($pass, $email){
		
		$conn = Db::connect();
		
		$conn->query("UPDATE usuario SET senha = '$pass' WHERE email = '$email'");
		return TRUE;
	}
}