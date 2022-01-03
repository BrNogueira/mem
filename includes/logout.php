<?php if(Util::isLogged()){
	
	unset($_SESSION['cliente_dados']);
	unset($_SESSION['novo_endereco']);
	unset($_SESSION['aviso']);
	unset($_SESSION['sucesso']);
	unset($_SESSION['erro']);
		
	header('location:'.$urlC);
} ?>