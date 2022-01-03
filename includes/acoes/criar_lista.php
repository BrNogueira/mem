<?php

if(Util::botDetected()){
	
	header("Location: $urlC");
}else{
		
	$email_from = $config['mailer_email'];
	$email_to 	= $config['email_notificacao'];
	$email_cc 	= $config['email_notificacao_copia'];
	$email_bcc 	= $config['email_notificacao_copia_oculta'];
	$empresa 	= $result_info['nome'];

	$data = '<br/><br/>Horário do envio: '.date('d/m/Y H:i');
	 
	if(PATH_SEPARATOR == ';'){
		
		$quebra_linha = '\r\n';
	}elseif(PATH_SEPARATOR == ':'){
		
		$quebra_linha = '\n';
	}elseif( PATH_SEPARATOR != ';' && PATH_SEPARATOR != ':'){
		
		echo 'Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.';
	}
	 
	$mensagem = '<body style="font-family: Calibri;"><h2>'.$empresa.'</h2><p>';

	$id_tipo_lista = $_POST['id_tipo_lista'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = md5(Util::antiInjection($_POST['senha']));
	$data = $_POST['data'];
	$info = $_POST['local'];
	$texto = $_POST['mensagem'];
		
	$dataDb = Util::fixDataDb($data);
	
	$queryT = $conn->query("SELECT * FROM tipo_lista WHERE id = {$id_tipo_lista}");
    $resultT = $queryT->fetch_array();
    
    $tipo_lista = $resultT['nome'];
	
	$arquivo_nome = '';
	
	if(!empty($_FILES['arquivo']['name'])){
		
		$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
		
		$arquivo = $_FILES['arquivo'];
		$pasta_arquivos = 'files/lista/';
		
		$arquivo_nome = utf8_encode($pasta_arquivos.'lista'.date('HisdmY').'_1_.'.$extensao);
		move_uploaded_file($arquivo["tmp_name"], 'admin/'.$arquivo_nome);
	}
	
	$conn->query("INSERT INTO lista (id_tipo_lista, nome, email, data, senha, info, texto, arquivo) VALUES ('$id_tipo_lista', '$nome', '$email', '$dataDb', '$senha', '$info', '$texto', '$arquivo_nome')");
	
	$mensagem .= '<b>'.$nome.'</b><br/><br/>';
	$mensagem .= '<b>Tipo de Lista: </b>'.$tipo_lista.'<br/>';
	$mensagem .= '<b>Data do Evento: </b>'.$data.'<br/>';
	$mensagem .= '<b>E-mail: </b>'.$email.'<br/>';
	$mensagem .= '<b>Local: </b>'.$info.'<br/>';
	$mensagem .= '<b>Mensagem: </b>'.$texto.'<br/>';
	
	$last_id = $conn->insert_id;
	
	$mensagem .= '<br/><b>PRODUTOS</b><br/><br/>';
	
	$mensagem .= '<table cellspacing="0" cellpadding="10" border="1" style="font-family: Calibri; vertical-align: middle;">
                    <tr>
                        <th>PRODUTO</th>
                        <th>DETALHES</th>
                        <th>QUANTIDADE</th>
                        <th>OBSERVAÇÃO</th>
                    </tr>';
                    
	foreach($_SESSION['criar_lista'] as $var => $item){
		
    	$query = $conn->query("SELECT * FROM produto WHERE id = {$item['id_produto']}");
    	$result = $query->fetch_array();
    	
    	$id_lista = $last_id;
    	$id_produto = $result['id'];
    	$produto = $result['nome'];
    	$quantidade = $item['quantidade'];
    	$observacao = $item['observacao'];
    	$id_rel_produto_var = $item['id_rel_produto_var'];
    	    	
    	$conn->query("INSERT INTO lista_produto (id_lista, id_produto, quantidade, observacao, id_rel_produto_var) VALUES ($id_lista, $id_produto, $quantidade, '$observacao', $id_rel_produto_var)");
    	
    	$detalhe = NULL;
    	
    	if($item['id_cor'] > 0){
			$query_cor = $conn->query("SELECT nome FROM cor WHERE id = ".$item['id_cor']);
			$cor = $query_cor->fetch_array();
        	$detalhe .= '<b>Cor:</b> '.$cor['nome']; 
        }
        
        if($item['id_tamanho'] > 0){
			$query_tamanho = $conn->query("SELECT nome FROM tamanho WHERE id = ".$item['id_tamanho']);
			$tamanho = $query_tamanho->fetch_array();
			$detalhe .= '<br/><b>Tamanho:</b> '.$tamanho['nome'];
		}
    	
    	$mensagem .= '<tr>
            <td>'.$produto.'</td>
            <td>'.$detalhe.'</td>
            <td>'.$quantidade.'</td>
            <td>'.$observacao.'</td>
        </tr>';
    }
    
    $mensagem .= '</table>';
	
	$mensagem .= '</p>'.$data.'</body>';
	//$mensagem = wordwrap($mensagem, 500, '<br>', 1); 

	$header =  'Nova Lista Recebida - '.$empresa;

	require_once('includes/phpmailer/class.phpmailer.php');
	 
	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->SMTPDebug = 1;
	$mailer->Port = $config['servidor_smtp_porta'];
	$mailer->Host = $config['servidor_smtp'];
	$mailer->SMTPSecure = 'tls';
	$mailer->SMTPAuth = true;
	$mailer->Username = $config['mailer_email'];
	$mailer->Password = $config['mailer_senha'];
	$mailer->FromName = $empresa;
	$mailer->From = $email_from;
	$mailer->AddAddress($email_to);
	if(!empty($email_cc)){
		$mailer->AddCC($email_cc, 'Cópia');
	}
	if(!empty($email_bcc)){
		$mailer->AddBCC($email_bcc, 'Cópia Segura');
	}
	$mailer->Subject = $header;
	$mailer->Body = $mensagem;
	$mailer->IsHTML(true); 
	$mailer->SetLanguage('br');
	$mailer->CharSet = 'utf-8';

	if(count($_FILES['arquivo']['name']) == 1){ 
		 	
		$mailer->addAttachment($_FILES["arquivo"]['tmp_name'], $_FILES['arquivo']['name']);
	}elseif(count($_FILES['arquivo']['name']) > 1){ 
		 	
		for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
			
			$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
		}
	}
		
	if(!$mailer->Send()){
		
		$_SESSION['aviso'] = "Erro ao enviar lista!";
		header('Location:'.$urlC.'home');
	}else{
		
		$_SESSION['sucesso'] = "Lista cadastrada com sucesso!<br/>Aguarde que entraremos em contato o mais breve possível.";
		unset($_SESSION['criar_lista']);
		header('Location:'.$urlC.'home');
	}
}
?>