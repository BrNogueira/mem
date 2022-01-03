<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	
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
	
	$insert = FALSE;
	
	$mensagem = '<body style="font-family: Calibri;"><h2>'.$empresa.'</h2><p>';

	foreach($_POST as $var => $post){

		$_POST[$var] = addslashes($post);
		
		if($var == 'tipo'){
				
			switch($_POST[$var]){
				case 'contato':
					$tipo = 'Contato';
				break;
				case 'associe':
					$tipo = 'Associe-se';
				break;
				case 'trabalhe_conosco':
					$tipo = 'Trabalhe Conosco';
				break;
				case 'depoimento':
					$tipo = 'Depoimento';
				break;
				case 'avise_me':
					$tipo = 'Avise-me';
					$insert = TRUE;
				break;
				default:
					$tipo = 'Contato';
			}
		}
		
		$mensagem .= ($var == 'nome')				?('<b>Nome: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'nome_noivos')		?('<b>Nome dos Noivos: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'email')				?('<b>E-mail: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'telefone_contato')	?('<b>Telefone Contato: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'telefone_celular')	?('<b>Telefone Celular: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'data')				?('<b>Data do Evento: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'local')				?('<b>Local do Evento: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'endereco')			?('<b>Endereço: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'informacao_entrega')	?('<b>Informação de Entrega: </b>'.$_POST[$var].'<br/>')	:(NULL);
		$mensagem .= ($var == 'festeiro')			?('<b>Festeiro: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'observacao')			?('<b>Observação: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'telefone')			?('<b>Telefone: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'nascimento')			?('<b>Nascimento: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'rg')					?('<b>RG: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cep')				?('<b>CEP: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cidade')				?('<b>Cidade: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'uf')					?('<b>UF: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cidade_uf')			?('<b>Cidade/UF: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'numero')				?('<b>Nº: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'data')				?('<b>Data: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'produto')			?('<b>Produto: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'hora')				?('<b>Hora: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'pessoas')			?('<b>Nº de pessoas: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'assunto')			?('<b>Assunto: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'observacoes')		?('<br/><b>Observações: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
		$mensagem .= ($var == 'mensagem')			?('<br/><b>Mensagem: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
		$mensagem .= ($var == 'depoimento')			?('<br/><b>Depoimento: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
		
		if($var == 'nome'){ $nome = $_POST[$var]; }
		if($var == 'email'){ $email = $_POST[$var]; }
		if($var == 'produto'){ $produto = $_POST[$var]; }
		if($var == 'observacoes'){ $observacao = $_POST[$var]; }
	}
	
	$adendo = NULL;
	
	if($insert){
			
		$conn->query("INSERT INTO avise (nome, email, produto, texto, data_hora) VALUES ('$nome', '$email', '$produto', '$observacao', '".date('Y-m-d H:i:s')."')");
		
		$adendo = '<br/>Assim que este produto estiver disponível lhe avisaremos por e-mail!';
	}
	
	if($_POST['tipo'] == 'depoimento'){
			
		$conn->query("INSERT INTO depoimento (nome, email, telefone, cidade, texto) VALUES ('{$_POST['nome']}', '{$_POST['email']}', '{$_POST['telefone']}', '{$_POST['cidade']}', '{$_POST['depoimento']}')");
		
		$adendo = '<br/>Seu depoimento será analisado pela nossa equipe e divulgado em nosso site!';
	}

	
	$mensagem .= '</p>'.$data.'</body>';
	//$mensagem = wordwrap($mensagem, 500, '<br>', 1); 

	$header =  $tipo.' - '.$empresa;

	// Load Composer's autoloader
	require 'vendor/autoload.php';

	// Instantiation and passing `true` enables exceptions
	$mailer = new PHPMailer(true);
	 
	$mailer = new PHPMailer();
	$mailer->isSMTP();
	$mailer->SMTPDebug = 2;
	$mailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mailer->Port = $config['servidor_smtp_porta'];
	$mailer->Host = $config['servidor_smtp'];
	if($config['tls'] == 't'){				
		$mailer->SMTPSecure = 'tls';
	}
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

	if(count($_FILES['arquivo']['name']) == 1){ 
		 	
		$mailer->addAttachment($_FILES["arquivo"]['tmp_name'], $_FILES['arquivo']['name']);
	}elseif(count($_FILES['arquivo']['name']) > 1){ 
		 	
		for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
			
			$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
		}
	}
	
	if(!$mailer->send()){
		
		$_SESSION['aviso'] = 'Erro ao enviar!';
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}else{
		
		$_SESSION['sucesso'] = 'Enviado com sucesso!'.$adendo;
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
}
?>