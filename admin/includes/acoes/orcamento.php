<?php

$id_maquina 	= implode(',', $_POST['id_maquina']);
$email 			= $_POST['email'];
$texto 			= $_POST['texto'];
$valores 		= $_POST['valores'];
$tabela_insumos = $_POST['tabela_insumos'];

$conn->query("INSERT INTO orcamento_enviado (id_maquina, email, texto, valores, tabela_insumos) VALUES ('$id_maquina', '$email', '$texto', '$valores', '$tabela_insumos')");

$select_fields	= 'produto.*, categoria.nome AS categoria, categoria.id AS id_categoria';
$select_table	= 'produto';	
$select_join	= "INNER JOIN categoria ON categoria.id = produto.id_categoria";
$select_where	= "WHERE produto.ativo = 't' AND produto.id IN ({$id_maquina})";
$select_group	= 'GROUP BY produto.id';
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
	
	$query2 = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1");
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

echo $mensagem;

die;

/*$email_from = $config['mailer_email'];
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
	header('Location:'.$urlC.'enviar_orcamento');
}else{
	
	$_SESSION['alerta']['ok'] = 'Enviado com sucesso!';
	header('Location:'.$urlC.'enviar_orcamento');
}*/

	
?>