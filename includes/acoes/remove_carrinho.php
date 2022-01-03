
<?php

$var = $_POST['var'];

unset($_SESSION['carrinho_item'][$var]);

if(Util::isLogged() && isset($_SESSION['carrinho_item']) && count($_SESSION['carrinho_item']) == 0){
	
	$conn->query("UPDATE usuario SET sessao_carrinho = '' WHERE id = {$_SESSION['cliente_dados']['id']}");
	
	$_SESSION['cliente_dados']['sessao_carrinho'] = '';
}

if(count($_SESSION['carrinho_item']) == 0){
	
	unset($_SESSION['lista']);
}

header('location:'.$urlC.'carrinho');

?>
