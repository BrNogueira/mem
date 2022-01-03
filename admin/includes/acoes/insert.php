<?php

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

if(isset($_POST['secoes'])){
	
	$_POST['secoes'] = implode(',', $_POST['secoes']);
}

if(isset($_POST['multiplo']) && $_POST['multiplo'] = 't'){
	
	$id_principal = explode('|', $_POST['id_principal']);
		
	if(isset($_FILES['arquivo']['name']) && count($_FILES['arquivo']['name']) > 0){ 
		 	
		for($i = 0; $i < count($_FILES['arquivo']['name']); $i++){
			
			$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'][$i])));
		
			$label = $_FILES['arquivo']['name'][$i];
			$arquivo = $_FILES['arquivo'];
			$pasta_arquivos = 'files/'.$table.'/';

			if(!file_exists($pasta_arquivos)){
				
				mkdir($pasta_arquivos);
			}
			
			$arquivo_nome = utf8_encode($pasta_arquivos.$table.date('HisdmY').'_'.$i.'_.'.$extensao);
			move_uploaded_file($arquivo["tmp_name"][$i], $arquivo_nome);
			
			$max_width 	= 900;
			$max_height = 700;
			
			if($table != 'banner'){
				
				Util::imgResize($arquivo_nome, $arquivo_nome, $max_width, $max_height, $extensao);
			}
			
			if(isset($_POST['ordem'])){
		
				$sql_ordem = $conn->query("SELECT MAX(ordem) AS ordem FROM ".$table) or die($conn->error());
				$result_ordem = $sql_ordem->fetch_array();
				$nova_ordem = $result_ordem['ordem'] + 1;
			}
			
			if($conn->query("INSERT INTO {$table} (ordem, {$id_principal[0]}, arquivo) VALUES ({$nova_ordem}, {$id_principal[1]}, '{$arquivo_nome}')")){
				$_SESSION['alerta']['ok'] = 'Cadastrado com sucesso!';
			
			}else{
				
				$_SESSION['alerta']['error'] = 'Falha ao cadastrar o arquivo "'.$label.'"';
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}		
		}
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}	
	
	header("Location: {$_SERVER['HTTP_REFERER']}");
	die;
}

$ordem = FALSE;

if(isset($_POST['ordem'])){
			
	$ordem = TRUE;
	unset($_POST['ordem']);
}

$fields = array();
$values = array();

foreach($_POST as $var => $post){
	
	$_POST[$var] = trim(addslashes($post));
	
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
	
	if($field_type = $conn->query("SELECT {$var} FROM {$table}")){
	
		$field_info = $field_type->fetch_field();		
		$is_int = ($field_info->type == 3)?(TRUE):(FALSE);
	}
	
	if($is_int === TRUE && !($_POST[$var] > 0)){
		
		$_POST[$var] = 0;
	}
	
	$fields[] = $var;
	$values[] = ($is_int === TRUE)?($_POST[$var]):(($field_info->type == 10 && empty($_POST[$var]))?("NULL"):("'{$_POST[$var]}'"));
}

$extensoes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'vcf', 'vcr');

if(count($_FILES) > 0){
	
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
				
				$fields[] = "arquivo".$index;
				$values[] = "'{$arquivo_nome}'";
			}else{
				
				$_SESSION['aviso'] = 'Arquivo(s) com extensão inválida!';
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}
	}
}	

if($ordem){
	
	$sql_ordem = $conn->query("SELECT MAX(ordem) AS ordem FROM {$table}");
	$result_ordem = $sql_ordem->fetch_array();
	$nova_ordem = $result_ordem['ordem'] + 1;
	$fields[] = "ordem";
	$values[] = "{$nova_ordem}";
}

$fields = implode(',', $fields);
$values = implode(',', $values);


if($insert_id = $insert->insertDefault($table, $fields, $values)){
	
	if($table == 'produto' && $_POST['valor_promocional'] > 0){
		
		$queryP = $conn->query("SELECT * FROM {$table} WHERE id = {$insert_id}");
		$resultP = $queryP->fetch_array();
		
		$usuario_acao = $_SESSION['login']['login'];
		$produto_acao = $resultP['nome'];
		$codigo_acao = (!empty($resultP['codigo_erp']))?($resultP['codigo_erp']):('(vazio)');
		$referencia_acao = (!empty($resultP['referencia']))?($resultP['referencia']):('(vazio)');
		$valor_promocional = ($resultP['valor_promocional'] > 0)?('R$ '.Util::fixValor($resultP['valor_promocional'])):('(vazio)');
		$valor_promocional_prazo = ($resultP['valor_promocional_prazo'] > 0)?('R$ '.Util::fixValor($resultP['valor_promocional_prazo'])):('(vazio)');
		$inicio_promocional = (!empty($resultP['data_inicio']))?(Util::fixData($resultP['data_inicio'])):('(vazio)');
		$fim_promocional = (!empty($resultP['data_fim']))?(Util::fixData($resultP['data_fim'])):('(vazio)');
		
		$registro_valor_promocional = "O usuário de login <b>{$usuario_acao}</b> gravou o produto <b>{$produto_acao}</b> de código ERP <b>{$codigo_acao}</b> e referencia <b>{$referencia_acao}</b> com os seguintes dados: <br/>Valor Promocional à Vista = <b>{$valor_promocional}</b> / Valor Promocional a Prazo = <b>{$valor_promocional_prazo}</b> / Data Início = <b>{$inicio_promocional}</b> / Data Fim = <b>{$fim_promocional}</b>";
		
		$conn->query("INSERT INTO registro_valor_promocional (id_produto, registro) VALUES ($insert_id, '$registro_valor_promocional')");
	}
	
	if(isset($_FILES['arquivos']) && count($_FILES['arquivos']['name']) > 0){
		
		$cont_files = count($_FILES['arquivos']['name']);
		
		for($i = 0; $i < $cont_files; $i++){
			
			$var_extensao = explode('.', $_FILES['arquivos']['name'][$i]);
			$extensao = strtolower(end($var_extensao));
			$arquivo = $_FILES['arquivos'];
			$pasta_arquivos = 'admin/files/'.$table.'_arquivo/';

			if(!file_exists($pasta_arquivos)){
				
				mkdir($pasta_arquivos);
			}
			
			$arquivo_nome = utf8_encode($pasta_arquivos.$table.'_arquivo'.date('HisdmY').'_'.$i.'_.'.$extensao);
			move_uploaded_file($arquivo["tmp_name"][$i], $arquivo_nome);
			
			$conn->query("INSERT INTO {$table}_arquivo (id_{$table}, nome) VALUES ($insert_id, '$arquivo_nome')");
		}
	}
	
	$_SESSION['sucesso'] = 'Ação efetuada com sucesso!';
	
	if(in_array($table, array('secao','categoria','subcategoria','destaque'))){
				
		$queryS = $conn->query("SELECT * FROM {$table} WHERE id = {$insert_id}");
		$resultS = $queryS->fetch_array();
		$string = trim($resultS['nome']);
		$string = str_replace("'","",$string);
		
		$conn->query("UPDATE {$table} SET slug = slug('{$string}') WHERE id = {$insert_id}");
	}elseif(in_array($table, array('produto'))){
		
		$queryS = $conn->query("SELECT * FROM {$table} WHERE id = {$insert_id}");
		$resultS = $queryS->fetch_array();
		$string = trim($resultS['nome']).' '.trim($resultS['referencia']);
		$string = str_replace("'","",$string);
		
		$conn->query("UPDATE {$table} SET slug = slug('{$string}') WHERE id = {$insert_id}");
	}
	
	if($table == 'produto'){
		
		header("Location: {$urlC}produtos_galeria/{$insert_id}");
	}else{
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}	
}else{
	
	$_SESSION['aviso'] = 'Falha ao efetuar ação!';
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

?>