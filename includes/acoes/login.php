<?php

$login 	= Util::antiInjection($_POST['email']);
$senha 	= md5(Util::antiInjection($_POST['senha']));

$usuario_login = $usuario_obj->getUsuarioLogin($login, $senha);

if($usuario_login > 0){
	
	$usuario_logado = $usuario_obj->getUsuarioLogado($login, $senha);
	$_SESSION['cliente_dados'] = $usuario_logado;
	
	$_SESSION['alerta'] = 1;
	$_SESSION['sucesso'] = 'BEM VINDO!<br/>Login efetuado com sucesso.';
	
	header("Location: {$_SERVER['HTTP_REFERER']}");
}else{
	
	$_SESSION['alerta'] = 2;
	$_SESSION['aviso'] = "USUÁRIO OU SENHA INCORRETOS!";
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

?>