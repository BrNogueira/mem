<?php

$id_plano = $_SESSION['id_plano'];

$queryP = $conn->query("SELECT * FROM plano WHERE ativo = 't' AND id = {$id_plano}");
$resultP = $queryP->fetch_array();

$dados['plano'] = $resultP['codigo'];

$id_usuario = $_SESSION['cliente_dados']['id'];

$conn->query("INSERT INTO assinatura (id_usuario) VALUES ({$id_usuario})");
$id_assinatura = $conn->insert_id;

$_SESSION['cliente_pg'] = Util::trimPg($_SESSION['cliente_dados']);
$email_ps = ($config['pagseguro_ambiente'] == 'p')?(Util::trataEmailPg(addslashes($_SESSION['cliente_pg']['email']))):('doubleone@sandbox.pagseguro.com.br');

$dados['senderHash'] = $_POST['psHash'];
$dados['creditCardToken'] = $_POST['psToken'];
$dados['senderName'] = trim(addslashes(utf8_decode(Util::textoIntro($_SESSION['cliente_pg']['nome'].' '.$_SESSION['cliente_pg']['sobrenome'], 50))));
$dados['senderEmail'] = $email_ps;
$dados['senderCPF'] = Util::apenasNumeros($_SESSION['cliente_pg']['cpf']);
$dados['reference'] = $id_assinatura;

$phone 		= str_replace('(','', str_replace(')','',$_POST['holderPhone']));
$phone 		= explode(' ', $phone);
$ddd 		= $phone[0];
$telefone 	= Util::apenasNumeros($phone[1]);

$dados['creditCardHolderName'] = $_POST['creditCardHolderName'];
$dados['creditCardHolderCPF'] = Util::apenasNumeros($_POST['creditCardHolderCPF']);
$dados['creditCardHolderBirthDate'] = $_POST['creditCardHolderBirthDate'];
$dados['creditCardHolderAreaCode'] = $ddd;
$dados['creditCardHolderPhone'] = $telefone;
$dados['billingAddressStreet'] = $_POST['billingAddressStreet'];
$dados['billingAddressNumber'] = $_POST['billingAddressNumber'];
$dados['billingAddressComplement'] = $_POST['billingAddressComplement'];
$dados['billingAddressDistrict'] = $_POST['billingAddressDistrict'];
$dados['billingAddressPostalCode'] = Util::apenasNumeros($_POST['billingAddressPostalCode']);
$dados['billingAddressCity'] = $_POST['billingAddressCity'];
$dados['billingAddressState'] = $_POST['billingAddressState'];


$dados['addressStreet'] = $_SESSION['cliente_pg']['endereco'];
$dados['addressNumber'] = $_SESSION['cliente_pg']['numero'];
$dados['addressComplement'] = $_SESSION['cliente_pg']['complemento'];
$dados['addressDistrict'] = $_SESSION['cliente_pg']['bairro'];
$dados['addressPostalCode'] = Util::apenasNumeros($_SESSION['cliente_pg']['cep']);
$dados['addressCity'] = $_SESSION['cliente_pg']['cidade'];
$dados['addressState'] = $_SESSION['cliente_pg']['uf'];

if(!empty($_SESSION['cliente_pg']['telefone_contato'])){
	
	$telefone = Util::telefonePg($_SESSION['cliente_pg']['telefone_contato']);
	
	$dados['senderAreaCode'] = $telefone[0];
	$dados['senderPhone'] = $telefone[1];
}

?>

<?php if($retorno = PagSeguro::assinaPlano($dados)){ ?>
		
	<?php
	$id_plano = $resultP['id'];
	$plano = $resultP['nome'];
	$valor = $_SESSION['valor_assinatura'];
	$frequencia = $resultP['frequencia'];
	$codigo = $resultP['codigo'];
	$descricao = $resultP['texto'];
	$data_inicio = date('Y-m-d');
	$forma_pagamento = 'credito';
	$codigo_assinatura = $retorno->code;
	
	$consulta = PagSeguro::consultaAssinatura($codigo_assinatura);
	
	$status = $consulta->status;
		
	if($conn->query("UPDATE assinatura SET id_plano = {$id_plano}, plano = '{$plano}', valor = '{$valor}', frequencia = '{$frequencia}', codigo = '{$codigo}', forma_pagamento = '{$forma_pagamento}', status = '{$status}', descricao = '{$descricao}', codigo_assinatura = '{$codigo_assinatura}', data_inicio = '{$data_inicio}' WHERE id = {$id_assinatura} AND id_usuario = {$id_usuario}")){
		
		unset($_SESSION['id_plano']);
		unset($_SESSION['valor_assinatura']);
		
		$_SESSION['sucesso'] = 'ASSINATURA REALIZADA COM SUCESSO!';
		header("Location: {$urlC}minha-assinatura");
	} ?>
<?php } ?>