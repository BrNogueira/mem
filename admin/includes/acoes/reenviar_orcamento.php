<?php

$id = $_POST['id'];

$query0 = $conn->query("SELECT * FROM orcamento_enviado WHERE id = {$id}");
$result0 = $query0->fetch_array();

$id_maquina 	= $result0['id_maquina'];
$email 			= $result0['email'];
$texto 			= $result0['texto'];
$valores 		= $result0['valores'];
$tabela_insumos = $result0['tabela_insumos'];

$conn->query("INSERT INTO orcamento_enviado (id_maquina, email, texto, valores, tabela_insumos, reenviado) VALUES ('$id_maquina', '$email', '$texto', '$valores', '$tabela_insumos', 't')");

$select_fields	= 'maquina.*, maquina_categoria.nome AS maquina_categoria, maquina_categoria.id AS id_maquina_categoria';
$select_table	= 'maquina';	
$select_join	= "INNER JOIN maquina_categoria ON maquina_categoria.id = maquina.id_maquina_categoria";
$select_where	= "WHERE maquina.ativo = 't' AND maquina.id IN ({$id_maquina})";
$select_group	= 'GROUP BY maquina.id';
$select_order	= '';
$select_limit 	= "";
$query = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);

$mensagem = NULL;
$mensagem = '<body border="0" style="margin: 0; font-family: arial; color: #444;">
	<table cellspacing="0" cellpadding="0" width="850" align="center">
		<tr>
			<td colspan="3" style="border:none;" width="850">
				<a href="http://www.kmxmaquinasdecafe.com.br" target="_blank">
					<img src="'.$urlC.'img/email/cabecalho.jpg" width="850" height="200" style="border:none;"/>
				</a>
			</td>
		</tr>
		<tr>
			<td style="border:none; background:#fff;" width="110"></td>
			<td style="border:none;" width="630" align="left">
				<br/>
				<p style="text-align: justify; font-family: arial;">'.$texto.'</p>';

while($result = $query->fetch_array()){
	
	$query2 = $conn->query("SELECT * FROM maquina_galeria WHERE id_maquina = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1");
	$result2 = $query2->fetch_array();
	
	$mensagem .= '<br/>
				<h3 style="color: #9A672E; text-transform: uppercase; text-indent: 30px; font-family: arial;">'.$result['nome'].'</h3>
				<br/>
				<table width="630">
					<tr>
						<td>
							<a href="'.$urlC.'../maquina?c='.$result['id'].'#'.str_replace(' ','_',$result['nome']).'" target="_blank">									
								<img src="'.$urlC.$result2['arquivo'].'" width="250" style="border:none;"/>
							</a>
						</td>
						<td>
							<p style="text-align: justify; font-family: arial;">'.$result['texto'].'</p>
						</td>
					</tr>
				</table>
				<br/>			
				<p style="font-family: arial;"><b>Opções de Bebidas:</b><br/>'.$result['texto2'].'</p>
				<br/>
				<p style="font-family: arial;"><b>Dados Técnicos:</b></p>
				<div style="font-family: arial;">'.str_replace('<td','<td style="font-family: arial;" ',$result['texto3']).'</div>
				<hr />
				<br/>';
}
				
$mensagem .= '<br/>
				<p style="font-family: arial;">'.$valores.'</p>
				<br/>
				<p style="font-family: arial;"><b style="color: #683301; text-transform: uppercase;">Tabela de valor dos insumos:</b></p>
				'.$tabela_insumos.'
				<br/><br/>
			</td>
			<td style="border:none; background:#fff;" width="110"></td>
		</tr>
		<tr>
			<td colspan="3" style="border:none;" width="850">
				<img src="'.$urlC.'img/email/rodape.jpg" width="850" height="90" style="border:none;"/>
			</td>
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

$empresa = 'KMX Máquinas de Café';
$header =  "Orçamento - $empresa";

$email_cc = 'vendas@kmxmaquinasdecafe.com.br';

require_once('../includes/phpmailer/class.phpmailer.php');
 
$mailer = new PHPMailer();
//$mailer->IsSMTP();
$mailer->SMTPDebug = 1;
$mailer->Port = $config['servidor_smtp_porta'];
$mailer->Host = $config['servidor_smtp'];
//$mailer->SMTPSecure = 'tls';
$mailer->SMTPAuth = true;
$mailer->Username = $config['mailer_email'];
$mailer->Password = $config['mailer_senha'];
$mailer->FromName = $empresa;
$mailer->From = $config['mailer_email'];
$mailer->AddAddress($email);
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

if(count($_FILES['arquivo']['name']) > 0){ 
	 	
	for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
		
		$mailer->addAttachment($_FILES["arquivo"]['tmp_name'][$i], $_FILES['arquivo']['name'][$i]);
	}
}
		
if(!$mailer->Send()){
		
	$_SESSION['alerta']['error'] = 'Falha ao enviar.';
	header('Location:'.$urlC.'orcamentos_enviados');
}else{
	
	$_SESSION['alerta']['ok'] = 'Enviado com sucesso!';
	header('Location:'.$urlC.'orcamentos_enviados');
}

	
?>