<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(Util::botDetected()){
	
	header("Location: $urlC");
}else{
	
	unset($_POST['g-recaptcha-response']);
	
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

	if($table == 'projeto'){
		
		$_POST['id_profissional'] = $_SESSION['login_profissional']['id'];
	}

	if($table == 'projeto_galeria' || $table == 'projeto_mensagem'){
		
		$_POST['id_projeto'] = $_SESSION['projeto']['id'];
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
			if($var == 'cpf'){
			
				$_POST[$var] = Util::formatCnpjCpf($_POST[$var]);
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

	if(Util::jaCadastrado($email) && $table == 'usuario'){
		
		$_SESSION['aviso'] = "E-mail já cadastrado! Por favor, utilize outro e-mail.";
		header("Location: {$_SERVER['HTTP_REFERER']}");	
	}elseif($table == 'newsletter_email' && Util::jaCadastradoNews($email)){
		
		$_SESSION['aviso'] = "E-mail já cadastrado! Por favor, utilize outro e-mail.";
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}else{
		
		if(isset($_FILES['arquivo'])){
				
			if(empty($_FILES['arquivo']['name'])){
				
				unset($_FILES['arquivo']);
			}else{
				
				$extensoes = array('jpg', 'jpeg', 'png', 'gif');
				$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
				
				if(array_search($extensao, $extensoes) === FALSE){
					
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
		
		if(!isset($_FILES['arquivo'])){

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
		
		if($table == 'newsletter_email' && $acao == TRUE){
					
			$_SESSION['sucesso'] = 'Cadastrado na nossa Newsletter com sucesso!';
			header("Location: {$_SERVER['HTTP_REFERER']}"); 
		}elseif($table == 'usuario' && $acao == TRUE){
			
			/*$table2 = 'newsletter_email';
			$insert->insertDefault($table2, "nome, email", "'".$nome.' '.$sobrenome."','".$email."'");*/
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
							<span style="float: right; font-size: 14px; color: #000; font-family: arial;">'.date("d/m/Y").'</span>
							<h2 style="float: left; width: 100%; text-align: center; color: #444; font-family: arial; font-size: 30px; margin-bottom: 18px;">Confirmação de cadastro</h2>
							<p style="float: left; width: 100%; font-size: 16px; color: #000; font-family: arial;">
								Prezado(a) cliente, <span style="font-weight: bold;">'.$nome.'</span>,
							</p>
							<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">'.$config['texto_cadastro'].'</p>
							<br /><br />
							<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">
								Seu e-mail cadastrado é <span style="font-size: 14px; color: #000; font-family: arial;">'.$email.'</span> <br />
								Senha: <span style="font-size: 14px; color: #000; font-family: arial;">'.$senha.'</span> 
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
			$email_to 	= $config['email_notificacao'];
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
			
			$header =  'Novo Cadastro - '.$empresa;
					
			require 'vendor/autoload.php';
		 
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
			/*if($config['tls'] == 't'){				
				$mailer->SMTPSecure = 'tls';
			}*/
			$mailer->SMTPAuth = true;
			$mailer->Username = $config['mailer_email'];
			$mailer->Password = $config['mailer_senha'];
			$mailer->setFrom($email_from, $empresa);
			$mailer->addAddress($email);
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
			
			if(isset($_FILES['arquivo']) && count($_FILES['arquivo']['name']) > 0){ 

				for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
					
					$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
				}
			}
			
			$mailer->send();
					
			$_SESSION['sucesso'] = 'Seu cadastro foi realizado com sucesso! :)';
			
			$login = Util::antiInjection($email);
			$senha = md5(Util::antiInjection($senha));

			$usuario_login = $usuario_obj->getUsuarioLogin($login, $senha);

			if($usuario_login > 0){
				
				
				$usuario_logado = $usuario_obj->getUsuarioLogado($login, $senha);
				$_SESSION['cliente_dados'] = $usuario_logado;
				
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}else{
				
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}else{
			
			if($acao === TRUE){
				
				$_SESSION['sucesso'] = "Cadastro efetuado com sucesso!<br/>Aguarde que entraremos em contato o mais breve possível.";
			}else{
				
				$_SESSION['aviso'] = "Falha ao cadastrar!<br/>Entre em contato conosco para maiores informações.";
			}
			
			header("Location: {$_SERVER['HTTP_REFERER']}");
		}
	}

}
?>