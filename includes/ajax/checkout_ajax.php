
<?php

$id_cliente = $_SESSION['cliente_dados']['id'];

$conn->query("INSERT INTO pedido (id_usuario) VALUES ($id_cliente)");
$_SESSION['id_novo_pedido'] = $id_novo_pedido = $conn->insert_id;

$tipo_entrega 	= $_SESSION['tipo_entrega'];
$frete			= $_SESSION['frete'];
$total			= $_SESSION['total_carrinho'] + $frete;
	
if($_SESSION['endereco_entrega'] == 'endereco_atual' || isset($_SESSION['lista'])){
		
	$_SESSION['pagseguro']['cep'] 			= $cep			= addslashes($_SESSION['cliente_dados']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $endereco		= addslashes($_SESSION['cliente_dados']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $bairro		= addslashes($_SESSION['cliente_dados']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $cidade		= addslashes($_SESSION['cliente_dados']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $uf			= addslashes($_SESSION['cliente_dados']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $numero		= addslashes($_SESSION['cliente_dados']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $complemento	= addslashes($_SESSION['cliente_dados']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}elseif($_SESSION['endereco_entrega'] == 'endereco_novo'){
	
	$_SESSION['pagseguro']['cep'] 			= $cep			= addslashes($_SESSION['novo_endereco']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $endereco		= addslashes($_SESSION['novo_endereco']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $bairro		= addslashes($_SESSION['novo_endereco']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $cidade		= addslashes($_SESSION['novo_endereco']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $uf			= addslashes($_SESSION['novo_endereco']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $numero		= addslashes($_SESSION['novo_endereco']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $complemento	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}

if($_SESSION['endereco_entrega'] == 'endereco_novo' && $_SESSION['novo_endereco']['ativo'] == TRUE && $_SESSION['novo_endereco']['definicao'] == 'entrega_geral'){
	
	$_SESSION['pagseguro']['cep'] 			= $_SESSION['cliente_dados']['cep']			= addslashes($_SESSION['novo_endereco']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $_SESSION['cliente_dados']['endereco']	= addslashes($_SESSION['novo_endereco']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $_SESSION['cliente_dados']['bairro']		= addslashes($_SESSION['novo_endereco']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $_SESSION['cliente_dados']['cidade']		= addslashes($_SESSION['novo_endereco']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $_SESSION['cliente_dados']['uf']			= addslashes($_SESSION['novo_endereco']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $_SESSION['cliente_dados']['numero']		= addslashes($_SESSION['novo_endereco']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $_SESSION['cliente_dados']['complemento']	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$id_cliente = $_SESSION['cliente_dados']['id'];
	
	$update_endereco_entrega = $conn->query("UPDATE usuario SET cep = '$cep', endereco = '$endereco', bairro = '$bairro',
		cidade = '$cidade', uf = '$uf', numero = '$numero', complemento = '$complemento' WHERE id = $id_cliente");
}
	
$_SESSION['pagseguro']['frete'] = number_format($frete, 2);

$senderHash 	= $_POST['senderHash'];
$paymentMethod 	= $_POST['paymentMethod'];

$_SESSION['cliente_pg'] = Util::trimPg($_SESSION['cliente_dados']);

$base_domain 	= ($config['pagseguro_ambiente'] == 'p')?('pagseguro.uol.com.br'):('sandbox.pagseguro.uol.com.br');
$email_ps 		= ($config['pagseguro_ambiente'] == 'p')?(Util::trataEmailPg(addslashes($_SESSION['cliente_pg']['email']))):('doubleone@sandbox.pagseguro.com.br');

$url_retorno 	= $urlC.'retorno_pg';
$url 			= 'https://ws.'.$base_domain.'/v2/transactions';

$request['email'] 						= $config['pagseguro_email'];
$request['token'] 						= $config['pagseguro_token'];
$request['paymentMode'] 				= 'default';
$request['paymentMethod'] 				= $paymentMethod;
$request['receiverEmail'] 				= $config['pagseguro_email'];
$request['currency'] 					= 'BRL';

if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){
				
	if($_SESSION['cupom']['tipo'] == 'p'){
		
		$desconto = $_SESSION['total_carrinho'] * ($_SESSION['cupom']['valor'] / 100);
	}elseif($_SESSION['cupom']['tipo'] == 'r' && $_SESSION['total_carrinho'] > $_SESSION['cupom']['valor']){
		
		$desconto = $_SESSION['cupom']['valor'];
	}
	
	$request['extraAmount'] = str_replace(',','',number_format(-$desconto, 2));
}

$cont = 0;
$subtotal = 0;
for($i = 0; $i <= count($_SESSION['carrinho_item']); $i++){
		
	if(!empty($_SESSION['carrinho_item'][$i]['id'])){
		
		$cont++;
		
		$_SESSION['carrinho_item'][$i]['desconto'] = (isset($_SESSION['carrinho_item'][$i]['desconto']))?($_SESSION['carrinho_item'][$i]['desconto']):(0);
		
		$valor_por = $_SESSION['carrinho_item'][$i]['valor_por'] - number_format($_SESSION['carrinho_item'][$i]['valor_por'] * ($_SESSION['carrinho_item'][$i]['desconto'] / 100), 2);
		
		$request['itemId'.$cont] 			= $_SESSION['carrinho_item'][$i]['id'];
		$request['itemDescription'.$cont] 	= utf8_decode(substr($_SESSION['carrinho_item'][$i]['nome'], 0, 90));
		$request['itemAmount'.$cont] 		= str_replace(',','',number_format($valor_por, 2));
		$request['itemQuantity'.$cont] 		= $_SESSION['carrinho_item'][$i]['quantidade'];
		
		$subtotal += $request['itemAmount'.$cont] * $request['itemQuantity'.$cont] ;
	}
}

$request['notificationURL'] 			= $url_retorno;
$request['reference'] 					= $_SESSION['id_novo_pedido'];
$request['senderName'] 					= trim(addslashes(utf8_decode(Util::textoIntro($_SESSION['cliente_pg']['nome'].' '.$_SESSION['cliente_pg']['sobrenome'], 50))));

$request['senderCPF'] 					= Util::apenasNumeros($_SESSION['cliente_pg']['cpf']);

if(!empty($_SESSION['cliente_pg']['telefone_contato'])){
	
	$telefone = Util::telefonePg($_SESSION['cliente_pg']['telefone_contato']);
	
	$request['senderAreaCode'] 				= $telefone[0];
	$request['senderPhone'] 				= $telefone[1];
}

$request['senderEmail'] 				= $email_ps;
$request['senderHash'] 					= $senderHash;
$request['shippingType'] 				= $_SESSION['pagseguro']['entrega'];
$request['shippingAddressStreet'] 		= utf8_decode(Util::textoIntro($_SESSION['pagseguro']['endereco'], 75));
$request['shippingAddressNumber'] 		= $_SESSION['pagseguro']['numero'];
$request['shippingAddressComplement'] 	= utf8_decode(Util::textoIntro($_SESSION['pagseguro']['complemento'], 35));
$request['shippingAddressDistrict'] 	= utf8_decode($_SESSION['pagseguro']['bairro']);
$request['shippingAddressPostalCode'] 	= preg_replace('#[^0-9]#','',strip_tags($_SESSION['pagseguro']['cep']));
$request['shippingAddressCity'] 		= utf8_decode($_SESSION['pagseguro']['cidade']);
$request['shippingAddressState'] 		= strtoupper($_SESSION['pagseguro']['uf']);
$request['shippingAddressCountry'] 		= 'BRA';
$request['shippingCost'] 				= number_format($_SESSION['pagseguro']['frete'], 2);

include('includes/helpers/checkout_request.php');

$request = http_build_query($request);
 
$curl = curl_init($url);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

$xml = curl_exec($curl);

curl_close($curl);
 

if($xml == 'Unauthorized'){
       
   echo 'Não autorizado!';
   exit;
}else{
	
	$xml = simplexml_load_string($xml);
	
	include('includes/helpers/checkout_metodo.php');
}
 

?>