<?php

if(Util::isLogged()){
		
	$_SESSION['novo_endereco']['cep']				= $_POST['cep'];
	$_SESSION['novo_endereco']['endereco']			= $_POST['endereco'];
	$_SESSION['novo_endereco']['bairro']			= $_POST['bairro'];
	$_SESSION['novo_endereco']['cidade']			= $_POST['cidade'];
	$_SESSION['novo_endereco']['uf']				= $_POST['uf'];
	$_SESSION['novo_endereco']['numero']			= $_POST['numero'];
	$_SESSION['novo_endereco']['complemento']		= $_POST['complemento'];
	
	$_SESSION['novo_endereco']['definicao']			= $_POST['definicao'];
	
	$_SESSION['novo_endereco']['ativo']		= TRUE;
	
	header("location:".$urlC."carrinho");

}else{

	header("location:".$urlC."login");
}

?>