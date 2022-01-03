<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['tabela'])){
	
	$table = $_POST['tabela'];
	unset($_POST['tabela']);
}else{
	
	$code = $_POST['code'];

	$query = $conn->query("SELECT * FROM tabela WHERE codigo = '{$code}' LIMIT 1");

	if($query->num_rows > 0){
		
		$result = $query->fetch_array();
		$table = $result['nome'];
	}else{
		
		$_SESSION['aviso'] = 'Falha ao cadastrar!';
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
	
	unset($_POST['code']);
}

unset($_POST['acao']);

$id = $_POST['id'];
unset($_POST['id']);
$senha = NULL;

$field_value = array();

$empresa = $result_info['nome'];

$post_notificacao = 'f';
$notificar_situacao = FALSE;
$alteracao_status = FALSE;
$alteracao_info_pedido = FALSE;


if(isset($_POST['secoes'])){
	
	$_POST['secoes'] = implode(',', $_POST['secoes']);
}

if(isset($_POST['ordem'])){
			
	$ordem = TRUE;
	unset($_POST['ordem']);
}

foreach($_POST as $var => $post){
	
	$_POST[$var] = trim(addslashes($post));
	
	if($var == 'notificado_atualizacao_pedido'){
		
		$notificar_situacao = TRUE;
		$post_notificacao = 't';
	}
	
	if($var == 'id_status_pedido'){
		
		$alteracao_status = TRUE;
	}
	
	if($var == 'codigo_rastreamento'){
		
		$alteracao_info_pedido = TRUE;
	}
	
	if($var == 'senha' && empty($_POST[$var])){
		
		unset($_POST[$var]);
	}
	
	if($var == 'video'){
		
		$_POST[$var] = Util::videoId($_POST[$var]);
	}
	
	if($var == 'vimeo'){
		
		$_POST[$var] = Util::vimeoId($_POST[$var]);
	}
	
	if($var == 'valor_de' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if($var == 'valor_por' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if($var == 'valor_prazo' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if($var == 'juros_mes' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if($var == 'valor_promocional' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if($var == 'valor_promocional_prazo' && empty($_POST[$var])){
		
		$_POST[$var] = '0.00';
	}
	
	if(in_array($var, array('data', 'nascimento', 'data_inicio', 'data_fim', 'validade'))){
		
		$_POST[$var] = Util::fixDataDb($_POST[$var]);
	}
	if(in_array($var, array('inicio', 'fim', 'data_hora'))){
		
		$_POST[$var] = Util::fixDataHoraDb($_POST[$var]);
	}
	if($var == 'email'){
		
		$_POST[$var] = $login = Util::antiInjection($_POST[$var]);
	}
	if($var == 'senha'){
		
		$_POST[$var] = $senha = md5(Util::antiInjection($_POST[$var]));
	}
	
	if($field_type = $conn->query("SELECT {$var} FROM {$table}")){
	
		$field_info = $field_type->fetch_field();
		
		$is_int = ($field_info->type == 3)?(TRUE):(FALSE);
	}
	
	if($is_int === TRUE && !($_POST[$var] > 0)){
		
		$_POST[$var] = 0;
	}
			
	$field_value[] = ($is_int === TRUE)?("{$var} = {$_POST[$var]}"):(($field_info->type == 10 && empty($_POST[$var]))?("{$var} = NULL"):("{$var} = '{$_POST[$var]}'"));
}

$extensoes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'vcf', 'vcr');

if(count($_FILES) > 0){
	
	$query = $conn->query("SELECT * FROM {$table} WHERE id = {$id} LIMIT 1");
	$result = $query->fetch_array();
	
	$cont_files = count($_FILES);
	
	for($i = 1; $i <= $cont_files; $i++){
			
		$index = ($i == 1)?(NULL):($i);
		
		if(empty($_FILES['arquivo'.$index]['name'])){
			
			unset($_FILES['arquivo'.$index]);
			
		}else{
			
			$var_extensao = explode('.', $_FILES['arquivo'.$index]['name']);
			
			$extensao = strtolower(end($var_extensao));
							
			if(in_array($extensao, $extensoes)){
				
				$arquivo = $_FILES['arquivo'.$index];
				$pasta_arquivos = 'files/'.$table.'/';
				
				if(file_exists('admin/'.$result['arquivo'.$index])){
			
					unlink('admin/'.$result['arquivo'].$index);
				}

				if(!file_exists($pasta_arquivos)){
					
					mkdir($pasta_arquivos);
				}
				
				$arquivo_nome = utf8_encode($pasta_arquivos.$table.date('HisdmY').'_'.$i.'_.'.$extensao);
				move_uploaded_file($arquivo["tmp_name"], $arquivo_nome);
				
				$max_width 	= 900;
				$max_height = 700;
				
				if($table != 'banner'){
					
					Util::imgResize($arquivo_nome, $arquivo_nome, $max_width, $max_height, $extensao);
				}
				
				$field_value[] = "arquivo".$index." = '{$arquivo_nome}'";
			}else{
				
				$_SESSION['aviso'] = 'Arquivo(s) com extensão inválida!';
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}
	}
}	

$field_value = implode(',', $field_value);

if($table == 'produto'){
		
	$queryP = $conn->query("SELECT * FROM {$table} WHERE id = {$id}");
	$resultP = $queryP->fetch_array();
}

if($update->updateDefault($table, $field_value, $id)){
	
	if($table == 'produto'){
		
		if(array($_POST['valor_promocional'], $_POST['data_inicio'], $_POST['data_fim']) != array($resultP['valor_promocional'], $resultP['data_inicio'], $resultP['data_fim'])){
			
			$usuario_acao = $_SESSION['login']['login'];
			$produto_acao = $resultP['nome'];
			$codigo_acao = (!empty($resultP['codigo_erp']))?($resultP['codigo_erp']):('(vazio)');
			$referencia_acao = (!empty($resultP['referencia']))?($resultP['referencia']):('(vazio)');
			$valor_promocional = ($_POST['valor_promocional'] > 0)?('R$ '.Util::fixValor($_POST['valor_promocional'])):('(vazio)');
			$valor_promocional_prazo = ($_POST['valor_promocional_prazo'] > 0)?('R$ '.Util::fixValor($_POST['valor_promocional_prazo'])):('(vazio)');
			$inicio_promocional = (!empty($_POST['data_inicio']))?(Util::fixData($_POST['data_inicio'])):('(vazio)');
			$fim_promocional = (!empty($_POST['data_fim']))?(Util::fixData($_POST['data_fim'])):('(vazio)');
			
			$registro_valor_promocional = "O usuário de login <b>{$usuario_acao}</b> gravou o produto <b>{$produto_acao}</b> de código ERP <b>{$codigo_acao}</b> e referencia <b>{$referencia_acao}</b> com os seguintes dados: <br/>Valor Promocional à Vista = <b>{$valor_promocional}</b> / Valor Promocional a Prazo = <b>{$valor_promocional_prazo}</b> / Data Início = <b>{$inicio_promocional}</b> / Data Fim = <b>{$fim_promocional}</b>";
			
			$conn->query("INSERT INTO registro_valor_promocional (id_produto, registro) VALUES ($id, '$registro_valor_promocional')");
		}
	}
	
	if(!empty($login) && $senha){
		
		$query = $conn->query("SELECT * FROM usuario WHERE ativo = 't' AND email = '{$login}' AND senha = '{$senha}' LIMIT 1");
		$result = $query->fetch_array();
		$_SESSION['usuario'] = $result;
	}
	
	if($alteracao_status || $alteracao_info_pedido){
	
		$query0 = $conn->query("SELECT pedido.*, pedido.id AS id_pedido, usuario.nome AS usuario, usuario.email AS email
					FROM {$table}
					INNER JOIN usuario ON usuario.id = pedido.id_usuario
					WHERE pedido.id = {$id}
					GROUP BY pedido.id");
			
		$result0 = $query0->fetch_array();
		
		$data_hora = date('Y-m-d H:i:s');
		
		$conn->query("INSERT INTO historico_pedido_andamento (id_pedido, notificado, data_hora) VALUES ($id, '$post_notificacao', '$data_hora')");
	}

	if($notificar_situacao){
		
		$observacao = (empty($result0['observacao']))?(NULL):('Situação do pedido: <b>'.$result0['observacao'].'</b>');
		$codigo_rastreamento = (empty($result0['codigo_rastreamento']))?(NULL):('Código de rastreamento nos Correios: <b>'.$result0['codigo_rastreamento'].'</b>');
		
		$mensagem = NULL;
		$mensagem = '<body border="0" style="margin:0">
			<table cellspacing="0" cellpadding="0" width="850" align="center">
				<tr>
					<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.$config['arquivo'].'" width="850" height="150" style="border:none;"/></td>
				</tr>
				<tr>
					<td style="border:none; background:#fff;" width="50"></td>
					<td style="border:none;" width="750" colspan="4" align="left">
						<br/>
						<span style="float: right; font-size: 14px; color: #000; font-family: arial;">'.date("d/m/Y - H:i:s").'</span>
						<h2 style="float: left; width: 100%; text-align: center; color: #444; font-family: arial; font-size: 30px; margin-bottom: 18px;">Atualização de Pedido</h2>
						<p style="float: left; width: 100%; font-size: 16px; color: #000; font-family: arial;">
							Prezado(a) Cliente <span style="font-weight: bold;">'.$result0['usuario'].'</span>,
						</p>
						<p style="float: left; width: 100%; font-size: 14px; color: #000; font-family: arial; text-align: justify; line-height: 20px;">
							Seguem as informações atualizadas sobre o seu pedido de nº: <b>'.$id.'</b>.
							<br /><br />
							'.$observacao.'
							<br /><br />
							'.$codigo_rastreamento.'
							<br /><br />
							Esta mensagem é exclusiva à pessoa a quem foi destinada, podendo haver informações confidenciais e/ou legalmente protegidas. Se você não for o destinatário, é notificado que não deve fazer cópias, divulgações, verificações ou qualquer outro ato de mesma espécie, com o objetivo de utilizar estas informações. Por favor, caso tenha havido o engano, desde já, é importante que remova as informações de seus servidores e/ou banco de dados, precavendo-se assim de acarretamentos legais.
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
					<td colspan="3" style="border:none;" width="850"><img src="'.$urlC.$config['arquivo2'].'" width="850" height="90" style="border:none;"/></td>
				</tr>
			</table>
		</body>';
		
		$email_from = $config['mailer_email'];
		$email_to 	= $result0['email'];
		$email_bcc 	= $config['email_notificacao_copia_oculta'];

		$data = '<br/><br/>Horário do envio: '.date('d/m/Y H:i');
		 
		if(PATH_SEPARATOR == ';'){
			
			$quebra_linha = '\r\n';
		}elseif(PATH_SEPARATOR == ':'){
			
			$quebra_linha = '\n';
		}elseif( PATH_SEPARATOR != ';' && PATH_SEPARATOR != ':'){
			
			echo 'Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.';
		}
		
		$header =  "Atualização de Pedido #$id - $empresa";

				
		require '../vendor/autoload.php';
	 
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
		
		$mailer->send();
		
	}
	
	if(in_array($table, array('secao','categoria','subcategoria','destaque'))){
				
		$queryS = $conn->query("SELECT * FROM {$table} WHERE id = {$id}");
		$resultS = $queryS->fetch_array();
		$string = trim($resultS['nome']);
		$string = str_replace("'","",$string);
		
		$conn->query("UPDATE {$table} SET slug = slug('{$string}') WHERE id = {$id}");
	}elseif(in_array($table, array('produto'))){
		
		$queryS = $conn->query("SELECT * FROM {$table} WHERE id = {$id}");
		$resultS = $queryS->fetch_array();
		$string = trim($resultS['nome']).' '.trim($resultS['referencia']);
		$string = str_replace("'","",$string);
		
		$conn->query("UPDATE {$table} SET slug = slug('{$string}') WHERE id = {$id}");
	}
	
	$_SESSION['sucesso'] = 'Ação efetuada com sucesso!';
	header("Location: {$_SERVER['HTTP_REFERER']}");
}else{

	$_SESSION['aviso'] = 'Falha ao efetuar ação!';
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

?>