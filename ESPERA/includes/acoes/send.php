<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(1==2){
	
	header("Location: $urlC");
}else{
	
	unset($_POST['g-recaptcha-response']);
	
	$email_from = "noreply@memkids.com.br";
	$email_to 	= 'contato@memkids.com.br';
	$email_cc 	= '';
	$email_bcc 	= 'sindy@doubleone.com.br';
	// $empresa 	= $result_info['nome'];
	$empresa 	= "M&M Kids";

	$data = '<br/><br/>Horário do envio: '.date('d/m/Y H:i');
	 
	if(PATH_SEPARATOR == ';'){
		
		$quebra_linha = '\r\n';
	}elseif(PATH_SEPARATOR == ':'){
		
		$quebra_linha = '\n';
	}elseif( PATH_SEPARATOR != ';' && PATH_SEPARATOR != ':'){
		
		echo 'Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.';
	}
	 
	$mensagem = '<body style="font-family: Calibri;"><h2>'.$empresa.'</h2><p>';
	
	foreach($_POST as $var => $post){

		$_POST[$var] = addslashes($post);
		
		if($var == 'tipo'){
				
			switch($_POST[$var]){
				case 'contato':
					$tipo = 'Contato';
				break;
				case 'anuncie':
					$tipo = 'Anuncie';
				break;
				case 'trabalhe_conosco':
					$tipo = 'Trabalhe Conosco';
				break;
				case 'envio_documentos':
					$tipo = 'Envio de Documentos';
				break;
				default:
					$tipo = 'Contato';
			}
		}
		
		$mensagem .= ($var == 'tipo_documento')		?('<b>Tipo de Documento: </b>'.$_POST[$var].'<br/>')		:(NULL);
		$mensagem .= ($var == 'nome')				?('<b>Nome: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cpf')				?('<b>CPF: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cnpj')				?('<b>CNPJ: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'documento')			?('<b>CPF/CNPJ: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'email')				?('<b>E-mail: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'email_comercial')	?('<b>E-mail Comercial: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'email_particular')	?('<b>E-mail Particular: </b>'.$_POST[$var].'<br/>')		:(NULL);
		$mensagem .= ($var == 'telefone_fixo')		?('<b>Telefone Fixo: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'telefone_contato')	?('<b>Telefone Contato: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'telefone_celular')	?('<b>Telefone Celular: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'data')				?('<b>Data do Evento: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'local')				?('<b>Local do Evento: </b>'.$_POST[$var].'<br/>')			:(NULL);
		$mensagem .= ($var == 'endereco')			?('<b>Endereço: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'informacao_entrega')	?('<b>Informação de Entrega: </b>'.$_POST[$var].'<br/>')	:(NULL);
		$mensagem .= ($var == 'observacao')			?('<b>Observação: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'telefone')			?('<b>Telefone: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'nascimento')			?('<b>Nascimento: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'rg')					?('<b>RG: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cep')				?('<b>CEP: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cidade')				?('<b>Cidade: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'uf')					?('<b>UF: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'cidade_uf')			?('<b>Cidade/UF: </b>'.$_POST[$var].'<br/>')				:(NULL);
		$mensagem .= ($var == 'numero')				?('<b>Nº: </b>'.$_POST[$var].'<br/>')						:(NULL);
		$mensagem .= ($var == 'assunto')			?('<b>Assunto: </b>'.$_POST[$var].'<br/>')					:(NULL);
		$mensagem .= ($var == 'mensagem')			?('<br/><b>Mensagem: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
		$mensagem .= ($var == 'observacoes')		?('<br/><b>Observações: </b><br/>'.nl2br($_POST[$var]).'<br/>'):(NULL);
	}

	$mensagem .= '</p>'.$data.'</body>';
	//$mensagem = wordwrap($mensagem, 500, '<br>', 1); 
	
	$header =  $tipo;
	
	
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
	$mailer->Port = 587;
	$mailer->Host = 'smtp.memkids.com.br';
	// if($config['tls'] == 't'){				
	// 	$mailer->SMTPSecure = 'tls';
	// }
	$mailer->SMTPAuth = true;
	$mailer->Username = 'noreply@memkids.com.br';
	$mailer->Password = 'mailer587@#21';
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
		
		$_SESSION['aviso'] = "Erro ao enviar mensagem!";
		header('Location:'.$urlC.'home');
	}else{
		
		$_SESSION['sucesso'] = "Enviado com sucesso!";
		header('Location:'.$urlC.'home');
	}
}
?>