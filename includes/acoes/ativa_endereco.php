<?php

if(Util::isLogged()){
	
	if($_SESSION['novo_endereco']['ativo'] == FALSE){
		
		$_SESSION['novo_endereco']['ativo'] = TRUE;
		header("location:".$urlC."carrinho");
	}elseif($_SESSION['novo_endereco']['ativo'] == TRUE){
		
		$_SESSION['novo_endereco']['ativo'] = FALSE;
		header("location:".$urlC."carrinho");
	}
}else{

	header("location:".$urlC."login");
}

?>