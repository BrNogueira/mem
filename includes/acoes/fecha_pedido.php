<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(Util::isLogged() && count($_SESSION['carrinho_item']) > 0){
	
	$result_info = $_SESSION['result_info'];
	
	$forma_pagamento = $_POST['forma_pagamento'];
	$tipo_entrega 	= $_SESSION['tipo_entrega'];
	$frete			= $_SESSION['frete'];
	
	$valor_pagar = (isset($_SESSION['total_parcelado']) && $_SESSION['total_parcelado'] > $_SESSION['valor_total'])?($_SESSION['total_parcelado']):($_SESSION['valor_total']);
		
	$data_hora = date('d/m/Y H:i:s');
	$data = date('Y-m-d');
	
	$id_novo_pedido = $_SESSION['id_novo_pedido'];
	
	if($forma_pagamento == 'boleto'){
		
		$parcelas = 1;
		
	}
	
	$cliente_cpf = $_SESSION['cliente_dados']['cpf'];
	
	$juros = ($parcelas > $_SESSION['max_sem_juros'])?('t'):('f');
	
	$bandeira = (isset($_POST['bandeira']))?($_POST['bandeira']):('');
	
	$conn->query("UPDATE pedido SET data_hora = '$data_hora', data = '$data', forma_pagamento = '$forma_pagamento', parcelamento = $parcelas, valor_pagar = '$valor_pagar', cpf = '$cliente_cpf', juros = '$juros', bandeira = '$bandeira' WHERE id = $id_novo_pedido");
	
	if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){
		
		$cupom_id 		= $_SESSION['cupom']['id'];
		$cupom_nome 	= $_SESSION['cupom']['nome'];
		$cupom_codigo 	= $_SESSION['cupom']['codigo'];
		$cupom_valor 	= $_SESSION['cupom']['valor'];
		$cupom_tipo 	= $_SESSION['cupom']['tipo'];
		
		$conn->query("UPDATE pedido SET id_cupom = $cupom_id, cupom_nome = '$cupom_nome', cupom_codigo = '$cupom_codigo', cupom_valor = '$cupom_valor', cupom_tipo = '$cupom_tipo' WHERE id = $id_novo_pedido");
	}
	
	for($i = 0; $i <= count($_SESSION['carrinho_item']); $i++){
		
		if(!empty($_SESSION['carrinho_item'][$i]['id'])){
						
			//$valor_corrente = $_SESSION['carrinho_item'][$i]['valor_por'] + $_SESSION['carrinho_item'][$i]['valor_adicional'];
			$valor_corrente = $_SESSION['carrinho_item'][$i]['valor_por'];
			$desconto = 0;
			
			if(isset($_SESSION['carrinho_item'][$i]['id_cor'])){
							
				$sql = $conn->query("SELECT * FROM cor WHERE id = ".$_SESSION['carrinho_item'][$i]['id_cor']);
				$res = $sql->fetch_array();
				
				$cor = $res['nome'];
			}else{ $cor = NULL; }
			
			if(isset($_SESSION['carrinho_item'][$i]['id_tamanho']) && $_SESSION['carrinho_item'][$i]['id_tamanho'] > 0){
							
				$sql = $conn->query("SELECT * FROM tamanho WHERE id = ".$_SESSION['carrinho_item'][$i]['id_tamanho']);
				$res = $sql->fetch_array();
				
				$tamanho = $res['nome'];
			}else{ $tamanho = NULL; }
			
			if(isset($_SESSION['carrinho_item'][$i]['id_modelo']) && $_SESSION['carrinho_item'][$i]['id_modelo'] > 0){
							
				$sql = $conn->query("SELECT * FROM modelo WHERE id = ".$_SESSION['carrinho_item'][$i]['id_modelo']);
				$res = $sql->fetch_array();
				
				$modelo = $res['nome'];
			}else{ $modelo = NULL; }
			
			$valor_total = ($valor_corrente  - number_format($valor_corrente * ($desconto / 100), 2)) * $_SESSION['carrinho_item'][$i]['quantidade'];
			
			/*$tamanho = array();
			$tamanho[] = (!empty($_SESSION['carrinho_item'][$i]['largura']))?($_SESSION['carrinho_item'][$i]['largura'].' (l)'):('-');
			$tamanho[] = (!empty($_SESSION['carrinho_item'][$i]['altura']))?($_SESSION['carrinho_item'][$i]['altura'].' (a)'):('-');
			$tamanho[] = (!empty($_SESSION['carrinho_item'][$i]['profundidade']))?($_SESSION['carrinho_item'][$i]['profundidade'].' (p)'):('-');
			$tamanho = implode(' x ',$tamanho);*/
			
			$insert_carrinho = $conn->query("INSERT INTO carrinho (id_pedido, id_produto, id_rel_produto_var, referencia, nome_produto, quantidade, desconto, cor, tamanho, modelo, valor_corrente, valor_total, voltagem) VALUES (
				".$id_novo_pedido.",
				".$_SESSION['carrinho_item'][$i]['id'].",
				".$_SESSION['carrinho_item'][$i]['id_rel_produto_var'].",
				'".addslashes($_SESSION['carrinho_item'][$i]['referencia'])."',
				'".addslashes($_SESSION['carrinho_item'][$i]['nome'])."',
				".$_SESSION['carrinho_item'][$i]['quantidade'].",
				".$desconto.",
				'".addslashes($cor)."',
				'".addslashes($tamanho)."',
				'".addslashes($modelo)."',
				'".$valor_corrente."',
				'".$valor_total."',
				'".$_SESSION['carrinho_item'][$i]['voltagem']."'
			)");
		}
	}
	
	$update_pedido = $conn->query("UPDATE pedido SET tipo_entrega = '$tipo_entrega', valor_entrega = '$frete', valor_total = '$valor_pagar' WHERE id = $id_novo_pedido");
	
	//$_SESSION['fb_Purchase'] = TRUE;
	
	$empresa = $result_info['nome'];
	
	$mensagem = NULL;
		
	$mensagem = '<body border="0" style="margin:0">
		<table cellspacing="0" cellpadding="0" width="850" align="center">
			<tr>
				<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.'admin/'.$config['arquivo'].'" width="850" style="border:none;"/></td>
			</tr>
			<tr>
				<td style="border:none; background:#fff;" width="50"></td>
				<td style="border:none;" width="750" align="left">
					<br/>
					<span style="float: right; font-size: 14px; color: #000; font-family: arial;">'.date("d/m/Y - H:i:s").'</span>
					<h2 style="float: left; width: 100%; text-align: center; color: #444; font-family: arial; font-size: 30px; margin-bottom: 18px;">Confirmação de pedido</h2>
					<p style="float: left; width: 100%; font-size: 16px; color: #000; font-family: arial;">
						Prezado(a) Cliente <span style="font-weight: bold;">'.$_SESSION['cliente_dados']['nome'].'</span>,
					</p>
					<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">'.$config['texto_pedido'].'</p>
					<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">
						Equipe '.$empresa.'
						<br />
						Copyright © '.date("Y").' - TODOS OS DIREITOS RESERVADOS.
					</p>
					<br/>
				</td>
				<td style="border:none; background:#fff;" width="50"></td>
			</tr>
			<tr>
				<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.'admin/'.$config['arquivo2'].'" width="850" style="border:none;"/></td>
			</tr>
		</table>
	</body>';
	
	$mensagem2 = '<body border="0" style="margin:0">
		<table cellspacing="0" cellpadding="0" width="850" align="center">
			<tr>
				<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.'admin/'.$config['arquivo'].'" width="850" style="border:none;"/></td>
			</tr>
			<tr>
				<td style="border:none; background:#fff;" width="50"></td>
				<td style="border:none;" width="750" align="left">
					<br/>
					<span style="float: right; font-size: 14px; color: #000; font-family: arial;">'.date("d/m/Y - H:i:s").'</span>
					<h2 style="float: left; width: 100%; text-align: center; color: #444; font-family: arial; font-size: 30px; margin-bottom: 18px;">Confirmação de pedido</h2>
					<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">
						Um novo pedido foi realizada no site '.$empresa.'.
						<br /><br />
						Cliente: <b>'.$_SESSION['cliente_dados']['nome'].'</b>
						<br />
						Total do pedido: <b>R$ '.Util::fixValor($valor_pagar).'</b>
						<br /><br />
						Equipe '.$empresa.'
						<br />
						Copyright © '.date("Y").' - TODOS OS DIREITOS RESERVADOS.
					</p>
					<br/>
				</td>
				<td style="border:none; background:#fff;" width="50"></td>
			</tr>
			<tr>
				<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.'admin/'.$config['arquivo2'].'" width="850" style="border:none;"/></td>
			</tr>
		</table>
	</body>';
		
	$email_from = $config['mailer_email'];
	$email_to 	= $_SESSION['cliente_dados']['email'];
	$email_to2 	= $config['email_notificacao'];
	$email_cc 	= $config['email_notificacao_copia'];
	$email_bcc 	= $config['email_notificacao_copia_oculta'];

	$data = '<br/><br/>Horário do envio: '.date('d/m/Y H:i');
	 
	if(PATH_SEPARATOR == ';'){
		
		$quebra_linha = '\r\n';
	}elseif(PATH_SEPARATOR == ':'){
		
		$quebra_linha = '\n';
	}elseif( PATH_SEPARATOR != ';' && PATH_SEPARATOR != ':'){
		
		echo 'Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.';
	}
	
	$header =  'Novo Pedido - '.$empresa;

	require 'vendor/autoload.php';
	 
	$mailer = new PHPMailer(true);
	 
	$mailer = new PHPMailer();
	$mailer->isSMTP();
	$mailer->SMTPDebug = 0;
	$mailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mailer->Port = $config['servidor_smtp_porta'];
	$mailer->Host = $config['servidor_smtp'];
	$mailer->SMTPAuth = true;
	$mailer->Username = $config['mailer_email'];
	$mailer->Password = $config['mailer_senha'];
	$mailer->setFrom($email_from, $empresa);
	$mailer->addAddress($email_to);
	if(!empty($email_cc)){
		$mailer->addCC($email_cc, 'Cópia');
	}
	if(!empty($email_bcc)){
		$mailer->addBCC($email_bcc, 'Cópia Segura');
	}
	$mailer->Subject = $header;
	$mailer->Body = $mensagem;
	$mailer->isHTML(true); 
	$mailer->SetLanguage('br', 'libs/');
	$mailer->CharSet = 'utf-8';
	
	if(isset($_FILES['arquivo']['name']) && count($_FILES['arquivo']['name']) > 0){ 

		for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
			
			$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
		}
	}
	
	$mailer->send();
	
	 
	$mailer2 = new PHPMailer(true);
	 
	$mailer2 = new PHPMailer();
	$mailer2->isSMTP();
	$mailer2->SMTPDebug = 0;
	$mailer2->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mailer2->Port = $config['servidor_smtp_porta'];
	$mailer2->Host = $config['servidor_smtp'];
	$mailer2->SMTPAuth = true;
	$mailer2->Username = $config['mailer_email'];
	$mailer2->Password = $config['mailer_senha'];
	$mailer2->setFrom($email_from, $empresa);
	$mailer2->addAddress($email_to2);
	if(!empty($email_cc)){
		$mailer2->addCC($email_cc, 'Cópia');
	}
	if(!empty($email_bcc)){
		$mailer2->addBCC($email_bcc, 'Cópia Segura');
	}
	$mailer2->Subject = $header;
	$mailer2->Body = $mensagem2;
	$mailer2->isHTML(true); 
	$mailer2->SetLanguage('br', 'libs/');
	$mailer2->CharSet = 'utf-8';
	
	if(isset($_FILES['arquivo']['name']) && count($_FILES['arquivo']['name']) > 0){ 

		for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
			
			$mailer2->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
		}
	}
	
	$mailer2->send();
	
	unset($_SESSION['id_novo_pedido']);
	unset($_SESSION['novo_endereco']);
	unset($_SESSION['carrinho_item']);
	unset($_SESSION['cupom']);
	unset($_SESSION['cupom_valido']);
	unset($_SESSION['valor_total']);
	unset($_SESSION['total_carrinho']);
	unset($_SESSION['frete']);
	unset($_SESSION['produto_distribuidor']);
	unset($_SESSION['carrinho_ok']);
	unset($_SESSION['frete_pac']);
	unset($_SESSION['frete_sedex']);
	unset($_SESSION['subtotal']);
	unset($_SESSION['pagseguro']);
	unset($_SESSION['cliente_pg']);
	unset($_SESSION['frete_escolhido']);
	unset($_SESSION['lista']);
	unset($_SESSION['cartao']);
	unset($_SESSION['id_unidade']);
	unset($_SESSION['total_parcelado']);
	
	$add_alert = (!empty($urlBoleto))?('<br/><br/><a href="'.$urlBoleto.'" target="_blank" class="btn btn-custom"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Visualizar boleto</a>'):(NULL);
	
	$_SESSION['sucesso'] = 'PEDIDO EFETUADO!<br/><small>Em instantes você receberá um e-mail de confirmação.</small>'.$add_alert;
		
}else{
	
	header('location:'.$urlC);
} ?>