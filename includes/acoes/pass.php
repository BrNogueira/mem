<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(Util::botDetected()){
	
	header("Location: $urlC");
}else{

	$email_from = $config['mailer_email'];
	$email_bcc 	= $config['email_notificacao_copia_oculta'];
	$empresa 	= $result_info['nome'];

	$email = Util::antiInjection($_POST['email']);

	$query = $conn->query("SELECT * FROM usuario WHERE email = '{$email}' LIMIT 1");
	
	if($query->num_rows > 0){
		
		$rand = rand(100000, 99999999);
		
		$result = $query->fetch_array();
		
		$conn->query("UPDATE usuario SET rand = '{$rand}' WHERE id = {$result['id']}");
		
		$hash = md5($rand);
		
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
					<h2 style="float: left; width: 100%; text-align: center; color: #444; font-family: arial; font-size: 30px; margin-bottom: 18px;">Recuperação de senha</h2>
					<p style="float: left; width: 100%; font-size: 16px; color: #000; font-family: arial;">
						Prezado(a) usuário, 
					</p>
					<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">
						Clique no link abaixo para gerar sua nova senha:<br/>
						<a href="'.$urlC.'nova-senha?hash='.$hash.'">CLIQUE AQUI</a>
						<br /><br/>
						Caso não tenha solicitado esta recuperação de senha, por favor desconsidere este e-mail.
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
	
		$header =  'Recuperação de senha - '.$empresa;
					
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
						
		if(!$mailer->send()){
		
			$_SESSION['sucesso'] = "<b>Recuperação de senha</b><br/>Não foi possível recuperar sua senha!<br/>Entre em contato conosco para podermos auxiliá-lo.";
			header("Location: {$_SERVER['HTTP_REFERER']}");
		}else{
			
			$_SESSION['sucesso'] = "<b>Recuperação de senha</b><br/>Foi enviado para o seu e-mail instruções para criar uma nova senha.";
			header("Location: {$_SERVER['HTTP_REFERER']}");
		}
	}else{
		
		$_SESSION['aviso'] = "Recuperação de senha</b><br/>Este e-mail não consta em nosso sistema! Por favor, certifique-se de ter informado o e-mail corretamente.";
							
			header("Location: {$_SERVER['HTTP_REFERER']}");
	}

}
?>