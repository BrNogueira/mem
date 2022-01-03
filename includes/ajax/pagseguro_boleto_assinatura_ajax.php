<?php

$id_plano = $_SESSION['id_plano'];

$queryP = $conn->query("SELECT * FROM plano WHERE ativo = 't' AND id = {$id_plano}");
$resultP = $queryP->fetch_array();

$id_usuario = $_SESSION['cliente_dados']['id'];

$conn->query("INSERT INTO assinatura (id_usuario) VALUES ({$id_usuario})");
$id_assinatura = $conn->insert_id;

$_SESSION['cliente_pg'] = Util::trimPg($_SESSION['cliente_dados']);
$email_ps = ($config['pagseguro_ambiente'] == 'p')?(Util::trataEmailPg(addslashes($_SESSION['cliente_pg']['email']))):('doubleone@sandbox.pagseguro.com.br');

$dados['senderHash'] = $_POST['psHash'];
$dados['senderName'] = trim(addslashes(utf8_decode(Util::textoIntro($_SESSION['cliente_pg']['nome'].' '.$_SESSION['cliente_pg']['sobrenome'], 50))));
$dados['senderEmail'] = $email_ps;
$dados['senderCPF'] = Util::apenasNumeros($_SESSION['cliente_pg']['cpf']);
$dados['reference'] = $id_assinatura;

if(!empty($_SESSION['cliente_pg']['telefone_contato'])){
	
	$telefone = Util::telefonePg($_SESSION['cliente_pg']['telefone_contato']);
	
	$dados['senderAreaCode'] = $telefone[0];
	$dados['senderPhone'] = $telefone[1];
}

$dados['itemId1'] = $resultP['id'];
$dados['itemDescription1'] = utf8_decode(substr($resultP['nome'], 0, 90));
$dados['itemAmount1'] = str_replace(',','',number_format($_SESSION['valor_assinatura'], 2));
$dados['itemQuantity1'] = 1;

$retorno = PagSeguro::efetuaAssinaturaBoleto($dados);
$urlBoleto = $retorno['paymentLink'];
?>

<?php if(!empty($urlBoleto)){ ?>
	
	<?php
	$id_plano = $resultP['id'];
	$plano = $resultP['nome'];
	$valor = $_SESSION['valor_assinatura'];
	$frequencia = $resultP['frequencia'];
	$codigo = $resultP['codigo'];
	$descricao = $resultP['texto'];
	$forma_pagamento = 'boleto';
	$boleto_link = $urlBoleto;
	$status = 'WAITING';
		
	if($conn->query("UPDATE assinatura SET id_plano = {$id_plano}, plano = '{$plano}', valor = '{$valor}', frequencia = '{$frequencia}', codigo = '{$codigo}', forma_pagamento = '{$forma_pagamento}', boleto_link = '{$boleto_link}', status = '{$status}', descricao = '{$descricao}' WHERE id = {$id_assinatura} AND id_usuario = {$id_usuario}")){
		
		unset($_SESSION['id_plano']);
		unset($_SESSION['valor_assinatura']);
		
		$_SESSION['sucesso'] = 'ASSINATURA REALIZADA COM SUCESSO!';
		?>
		
		<script>
			var dir = window.location.href.split('/');
			var urlC = (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
			
			window.location.href = urlC+'minha-assinatura';
		</script>
	<?php } ?>
<?php } ?>