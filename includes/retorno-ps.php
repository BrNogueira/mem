<?php

$email = $config['pagseguro_email'];
$token = $config['pagseguro_token'];

$base_domain = ($config['pagseguro_ambiente'] == 'p')?('pagseguro.uol.com.br'):('sandbox.pagseguro.uol.com.br');

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){

    $url = 'https://ws.'.$base_domain.'/v2/transactions/notifications/'.$_POST['notificationCode'].'?email='.$email.'&token='.$token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
       
	   echo 'N&atilde;o autorizado!';
       exit;
    }
	
    $transaction = simplexml_load_string($transaction);
	
	$id_status = $transaction->status;
	$id_pedido = $transaction->reference;
	
	$query = $conn->query("SELECT * FROM pedido WHERE id = $id_pedido");
	$result = $query->fetch_array();
	
	if($id_status != $result['id_status'] && $id_status == 3){
		
		$query2 = $conn->query("SELECT * FROM carrinho WHERE id_pedido = $id_pedido");
		
		while($result2 = $query2->fetch_array()){
			
			$id_rel_produto_var = $result2['id_rel_produto_var'];
			$vendido 	= $result2['quantidade'];
			
			$conn->query("UPDATE rel_produto_var SET estoque = (estoque - $vendido) WHERE id = {$id_rel_produto_var}");			
		}
	}
	
	$conn->query("UPDATE pedido SET id_status = $id_status, codigo_transacao = '$transaction->code' WHERE id = $id_pedido AND metodo_atualizacao = 'auto'");
			
	header('Location: ' . $urlC);
}elseif(isset($_GET['codigo_transacao'])){

	$transaction = $_GET['codigo_transacao'];
	 
	$url = 'https://ws.'.$base_domain.'/v2/transactions/'.$transaction.'?email='.$email.'&token='.$token;
	 
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$transaction= curl_exec($curl);
	curl_close($curl);
	 
	if($transaction == 'Unauthorized') {
	    
	    echo 'N&atilde;o autorizado!';
	    exit;
	}
	 
	$transaction = simplexml_load_string($transaction);
	 	
	$id_status = $transaction->status;
	$id_pedido = $transaction->reference;
	
	$query = $conn->query("SELECT * FROM pedido WHERE id = $id_pedido");
	$result = $query->fetch_array();
	
	if($id_status != $result['id_status'] && $id_status == 3){
		
		$query2 = $conn->query("SELECT * FROM carrinho WHERE id_pedido = $id_pedido");
		
		while($result2 = $query2->fetch_array()){
			
			$id_rel_produto_var = $result2['id_rel_produto_var'];
			$vendido 	= $result2['quantidade'];
			
			$conn->query("UPDATE rel_produto_var SET estoque = (estoque - $vendido) WHERE id = {$id_rel_produto_var}");			
		}
	}
	
	$conn->query("UPDATE pedido SET id_status = $id_status, codigo_transacao = '$transaction->code' WHERE id = $id_pedido");
	
	header('Location: '.$urlC.'home');
}
?>