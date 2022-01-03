<?php

$_SESSION['cliente_pg'] = Util::trimPg($_SESSION['cliente_dados']);

$base_domain = ($config['pagseguro_ambiente'] == 'p')?('pagseguro.uol.com.br'):('sandbox.pagseguro.uol.com.br');
$email_ps = ($config['pagseguro_ambiente'] == 'p')?(Util::trataEmailPg(addslashes($_SESSION['cliente_pg']['email']))):('doubleone@sandbox.pagseguro.com.br');

$url = 'https://ws.'.$base_domain.'/v2/checkout';

$request['email'] 		= $config['pagseguro_email'];
$request['token'] 		= $config['pagseguro_token'];

$request['currency'] 	= 'BRL';

$cont = 0;
$subtotal = 0;
for($i = 0; $i <= count($_SESSION['carrinho_item']); $i++){
		
	if(!empty($_SESSION['carrinho_item'][$i]['id'])){
		
		$cont++;
		
		$valor_por = $_SESSION['carrinho_item'][$i]['valor_por'] - number_format($_SESSION['carrinho_item'][$i]['valor_por'] * ($_SESSION['carrinho_item'][$i]['desconto'] / 100), 2);
		
		$request['itemId'.$cont] 			= $_SESSION['carrinho_item'][$i]['id'];
		$request['itemDescription'.$cont] 	= utf8_decode(substr($_SESSION['carrinho_item'][$i]['nome'], 0, 90));
		$request['itemAmount'.$cont] 		= str_replace(',','',number_format($valor_por, 2));
		$request['itemQuantity'.$cont] 		= $_SESSION['carrinho_item'][$i]['quantidade'];
		
		$subtotal += $request['itemAmount'.$cont] * $request['itemQuantity'.$cont] ;
		
		$peso 								= str_replace('.', '', $_SESSION['carrinho_item'][$i]['peso']);
		$request['itemWeight'.$cont] 		= str_replace(',', '', $peso);
	}
}



$request['reference'] 					= $id_novo_pedido;
$request['senderName'] 					= trim(addslashes(utf8_decode(Util::textoIntro($_SESSION['cliente_pg']['nome'].' '.$_SESSION['cliente_pg']['sobrenome'], 50))));

if(!empty($_SESSION['cliente_pg']['telefone_contato'])){
	
	$telefone = Util::telefonePg($_SESSION['cliente_pg']['telefone_contato']);
	
	$request['senderAreaCode'] 				= $telefone[0];
	$request['senderPhone'] 				= $telefone[1];
}

$request['senderEmail'] 				= $email_ps;

$request['shippingType'] 				= $_SESSION['pagseguro']['entrega'];
$request['shippingAddressStreet'] 		= utf8_decode(Util::textoIntro($_SESSION['pagseguro']['endereco'], 75));
$request['shippingAddressNumber'] 		= $_SESSION['pagseguro']['numero'];
$request['shippingAddressComplement'] 	= utf8_decode(Util::textoIntro($_SESSION['pagseguro']['complemento'], 35));
$request['shippingAddressDistrict'] 	= utf8_decode($_SESSION['pagseguro']['bairro']);
$request['shippingAddressPostalCode'] 	= preg_replace('#[^0-9]#','',strip_tags($_SESSION['pagseguro']['cep']));
$request['shippingAddressCity'] 		= utf8_decode($_SESSION['pagseguro']['cidade']);
$request['shippingAddressState'] 		= strtoupper($_SESSION['pagseguro']['uf']);

$request['shippingCost'] 				= number_format($_SESSION['pagseguro']['frete'], 2);

if($_SESSION['cupom_valido'] === TRUE){
				
	if($_SESSION['cupom']['tipo'] == 'p'){
		
		$desconto = $subtotal * ($_SESSION['cupom']['valor'] / 100);
	}elseif($_SESSION['cupom']['tipo'] == 'r' && $subtotal > $_SESSION['cupom']['valor']){
		
		$desconto = $_SESSION['cupom']['valor'];
	}
	
	$request['extraAmount'] = str_replace(',','',number_format(-$desconto, 2));
}

$request['shippingAddressCountry'] 	= 'BRA';
$request['redirectURL'] = $urlC.'retorno_pg';

print_r($request);

$request = http_build_query($request);
 
$curl = curl_init($url);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

$xml = curl_exec($curl);

curl_close($curl);
 
$xml = simplexml_load_string($xml);

unset($_SESSION['carrinho_item']);
unset($_SESSION['cupom']);
unset($_SESSION['cupom_valido']);
unset($_SESSION['lista']);
unset($_SESSION['cartao']);

if(strlen($xml->code) < 10){
	
	$_SESSION['aviso'] = '<p>Não conseguimos processar seu pagamento, por favor, verifique se seus dados cadastrais estão preenchidos corretamente ou entre em contato com nosso Atendimento.</p>';
	
	$erro = '('.$xml->error->code.') '.$xml->error->message;
	
	$conn->query("UPDATE pedido SET erro = '$erro' WHERE id = $id_novo_pedido");
	
	header('location:'.$urlC.'contato');
}else{
	
	$codigo_transacao = $xml->code;
	
	$conn->query("UPDATE pedido SET codigo_transacao = '$codigo_transacao' WHERE id = $id_novo_pedido");
	
	header('Location: https://'.$base_domain.'/v2/checkout/payment.html?code='.$xml->code);	
}
?>