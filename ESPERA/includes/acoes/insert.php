<?php
$code = $_POST['code'];

$query = $conn->query("SELECT * FROM tabela WHERE codigo = '{$code}' LIMIT 1");

if($query->num_rows > 0){
	
	$result = $query->fetch_array();
	$table = $result['nome'];
}else{
	
	$_SESSION['alerta'] = 2;
	$_SESSION['aviso'] = 'Falha ao cadastrar!';
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

unset($_POST['acao']);
unset($_POST['code']);

$fields 	= NULL;
$values 	= NULL;
$post_count = 0;
$empresa	= $result_info['nome'];

if(isset($_POST['ordem'])){
	
	$queryO = $conn->query("SELECT MAX(ordem) AS ordem_maior FROM {$table}");
	$resultO = $queryO->fetch_array();
	$_POST['ordem'] = $resultO['ordem_maior'] + 1;
}

foreach($_POST as $var => $post){
	
	$post_count++;
	
	$_POST[$var] = addslashes($post);
	
	if($var == 'tabela'){
		
		$table = $_POST[$var];
		unset($_POST[$var]);
	}elseif($var == 'confirme_senha'){
		
		unset($_POST[$var]);
	}else{
		
		if($var == 'data' || $var == 'nascimento'){
			
			$_POST[$var] = Util::fixDataDb($_POST[$var]);
		}
		if($var == 'senha'){
			
			$senha = $_POST[$var];
			$_POST[$var] = md5($_POST[$var]);
		}
		if($var == 'email'){
			
			$email = $_POST[$var];
		}
		if($var == 'nome'){
			
			$nome = $_POST[$var];
		}
		if($var == 'sobrenome'){
			
			$sobrenome = $_POST[$var];
		}
		if($var == 'razao_sozial'){
			
			$razao = $_POST[$var];
		}
		$fields .= ($post_count == 1)?($var):(",".$var);
		$values .= ($post_count == 1)?("'".$_POST[$var]."'"):(",'".$_POST[$var]."'");
	}
}

if($table == 'usuario'){
	
	$fields .= ", data_hora";
	$values .= ", '".date('Y-m-d H:i:s')."'";
}

if($table == 'usuario' && Util::jaCadastrado($email)){
	
	$_SESSION['aviso'] = "E-mail já cadastrado! Por favor, utilize outro e-mail.";
	header("Location: {$_SERVER['HTTP_REFERER']}");	
}elseif(Util::jaCadastradoNews($email) && $table == 'newsletter_email'){
	
	$_SESSION['aviso'] = "E-mail já cadastrado! Por favor, utilize outro e-mail.";
	header("Location: {$_SERVER['HTTP_REFERER']}");
}else{
	
	if(isset($_FILES['arquivo']) && !in_array($table, array('denuncia'))){
			
		if(empty($_FILES['arquivo']['name'])){
			
			unset($_FILES['arquivo']);
		}else{
			
			$extensoes = array('jpg', 'jpeg', 'png', 'gif');
			$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
			
			if(1==2/*array_search($extensao, $extensoes) === FALSE*/){
				
				$arquivo_ok = FALSE;
			}else{
				
				$arquivo_ok = TRUE;
				
				$arquivo = $_FILES['arquivo'];
				$pasta_imagens = 'files/'.$table.'/';

				if(!file_exists('admin/'.$pasta_imagens)){
					
					mkdir('admin/'.$pasta_imagens);
				}
				
				$arquivo_nome = utf8_encode($pasta_imagens.$table.date('HisdmY').'.'.$extensao);
				move_uploaded_file($arquivo["tmp_name"], 'admin/'.$arquivo_nome);
				
				$fields .= ",arquivo";
				$values .= ",'".$arquivo_nome."'";
			}
		}
	}
	
	if(!isset($_FILES['arquivo']) or in_array($table, array('denuncia'))){

		if($insert->insertDefault($table, $fields, $values)){
			
			$acao = TRUE;
		}	
	}elseif($arquivo_ok){
		
		if($insert->insertDefault($table, $fields, $values)){
			
			$acao = TRUE;
		}
	}else{
		
		$acao = FALSE;
	}

	if($table == 'newsletter_cadastro' && $acao == TRUE){
				
		$_SESSION['sucesso'] = 'Cadastrado na nossa Newsletter com sucesso!';
		header("Location: {$_SERVER['HTTP_REFERER']}"); 
	}else{
		
		if($acao === TRUE){
			
			if(in_array($table, array('denuncia'))){
				
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
				
				if(isset($_POST['id_processo'])){
					
					$queryO = $conn->query("SELECT * FROM processo WHERE ativo = 't' AND id = {$_POST['id_processo']}");
					$resultO = $queryO->fetch_array();
					$mensagem .= '<b>Processo: </b>'.$resultO['nome'].'<br/>';
				}
				
				foreach($_POST as $var => $post){

					$_POST[$var] = addslashes($post);
										
					$mensagem .= ($var == 'nome')				?('<b>Nome: </b>'.$_POST[$var].'<br/>')						:(NULL);
					$mensagem .= ($var == 'email')				?('<b>E-mail: </b>'.$_POST[$var].'<br/>')					:(NULL);
					$mensagem .= ($var == 'telefone')			?('<b>Telefone: </b>'.$_POST[$var].'<br/>')					:(NULL);
					$mensagem .= ($var == 'cidade')				?('<b>Cidade: </b>'.$_POST[$var].'<br/>')					:(NULL);
					$mensagem .= ($var == 'uf')					?('<b>UF: </b>'.$_POST[$var].'<br/>')						:(NULL);
					$mensagem .= ($var == 'assunto')			?('<b>Assunto: </b>'.$_POST[$var].'<br/>')					:(NULL);
					$mensagem .= ($var == 'mensagem')			?('<br/><b>Mensagem: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
				}

				$mensagem .= '</p>'.$data.'</body>';

				$header =  $empresa;
				
				switch($table){
					case 'denuncia': $header = 'DENÚNCIA - '.$empresa; break;
				}

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

				if(isset($_FILES['arquivo']['name']) && count($_FILES['arquivo']['name']) == 1){ 
		 	
					$mailer->addAttachment($_FILES["arquivo"]['tmp_name'], $_FILES['arquivo']['name']);
				}elseif(isset($_FILES['arquivo']['name']) && count($_FILES['arquivo']['name']) > 1){ 
					 	
					for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
						
						$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
					}
				}
				
				if(isset($_FILES['arquivos']['name']) && count($_FILES['arquivos']['name']) > 0){ 
					 	
					for($i = 0; $i < count($_FILES['arquivos']['name']); $i++){
						
						$mailer->addAttachment($_FILES["arquivos"]['tmp_name'][$i], $_FILES['arquivos']['name'][$i]);
					}
				}
				
				if(!$mailer->Send()){
		
					$_SESSION['aviso'] = "Erro ao enviar mensagem!";
					header('Location:'.$urlC.'home');
				}else{
					
					$_SESSION['sucesso'] = "Enviado com sucesso!";
					header('Location:'.$urlC.'home');
				}
			}
		}else{
			
			$_SESSION['aviso'] = "Falha ao cadastrar!<br/>Entre em contato conosco para maiores informações.";
		}
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
}

?>