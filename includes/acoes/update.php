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

switch($table){
	case 'usuario': $id = $_SESSION['cliente_dados']['id']; break;
	case 'profissional': $id = $_SESSION['login_profissional']['id']; break;
	case 'projeto': $id = $_SESSION['projeto']['id']; break;
	case 'projeto_galeria': $id = $_SESSION['projeto_galeria']['id']; break;
}

unset($_POST['acao']);
unset($_POST['code']);

$field_value = '';
$post_count = 0;

foreach($_POST as $var => $post){
	
	$post_count++;
	$_POST[$var] = addslashes($post);
	
	if($var == 'tabela'){
		
		$table = $_POST[$var];
		unset($_POST[$var]);
	}elseif($var == 'confirme_senha' || ($var == 'senha' && empty($_POST[$var]))){
		
		unset($_POST[$var]);
	}else{
		
		if($var == 'data' || $var == 'nascimento'){
			
			$_POST[$var] = Util::fixDataDb($_POST[$var]);
		}
		if($var == 'email'){
			
			$login = Util::antiInjection($_POST[$var]);
		}
		if($var == 'senha'){
			
			$_POST[$var] = md5(Util::antiInjection($_POST[$var]));
		}
		if($var == 'cpf'){
			
			$_POST[$var] = Util::formatCnpjCpf($_POST[$var]);
		}
		if(is_numeric($_POST[$var])){
			
			$field_value .= ($post_count == 1)?($var." = ".$_POST[$var]):(",".$var." = ".$_POST[$var]);
		}else{
			
			$field_value .= ($post_count == 1)?($var." = '".$_POST[$var]."'"):(",".$var." = '".$_POST[$var]."'");
		}
	}
}


if(isset($_FILES['arquivo'])){
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= 'WHERE id = '.$id;
	$select_group	= '';
	$select_order	= '';
	$select_limit 	= 'LIMIT 1';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);
	$result = $consulta->fetch_array();
	
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
			
			if(file_exists('admin/'.$result['arquivo'])){
			
				unlink('admin/'.$result['arquivo']);
			}

			if(!file_exists($pasta_imagens)){
				
				mkdir('admin/'.$pasta_imagens);
			}
			
			$arquivo_nome = utf8_encode($pasta_imagens.$table.date('HisdmY').'.'.$extensao);
			move_uploaded_file($arquivo["tmp_name"], 'admin/'.$arquivo_nome);
			
			$field_value .= ",arquivo = '".$arquivo_nome."'";
		}
	}
}

if($table == 'usuario'){
	
	$select_fields2	= '*';			
	$select_table2	= 'usuario';	
	$select_join2	= '';			
	$select_where2	= "WHERE ativo = 't' AND id = $id";
	$select_group2	= '';
	$select_order2	= '';
	$select_limit2 	= 'LIMIT 1';
}elseif($table == 'profissional'){
	
	$select_fields2	= '*';			
	$select_table2	= 'profissional';	
	$select_join2	= '';			
	$select_where2	= "WHERE ativo = 't' AND id = $id";
	$select_group2	= '';
	$select_order2	= '';
	$select_limit2 	= 'LIMIT 1';
	
	$login = $_SESSION['login_profissional']['email'];
}

if(!isset($_FILES['arquivo'])){

	if($update->updateDefault($table, $field_value, $id)){
		
		$acao = TRUE;
		if(!empty($login)){
			
			$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2, $select_group2,
				$select_order2, $select_limit2);
			$result2 = $consulta2->fetch_array();
			$senha = $result2['senha'];
			
			if($table == 'profissional'){
				
				$queryA = $conn->query("SELECT * FROM profissional WHERE email = '$login' AND senha = '$senha' AND id = $id AND ativo = 't' LIMIT 1");
				$resultA = $queryA->fetch_array();
				$_SESSION['login_profissional'] = $resultA;
			}else{
				
				$usuario_logado = $usuario_obj->getUsuarioLogado($login, $senha);
				$_SESSION['cliente_dados'] = $usuario_logado;
			}
		}
		
		$_SESSION['sucesso'] = "Atualizado com sucesso!";
		
		if($table == 'profissional'){
			
			header('Location:'.$urlC.'area-restrita');
		}elseif(($table == 'projeto' || $table == 'projeto_galeria') && $acao == TRUE){
			
			header("Location: {$_SERVER['HTTP_REFERER']}");
		}else{
			
			header('Location:'.$urlC.'minha-conta');
		}
	}	
}elseif($arquivo_ok){
	
	if($update->updateDefault($table, $field_value, $id)){
		
		$acao = TRUE;
		if(!empty($login)){
			
			$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2, $select_group2,
				$select_order2, $select_limit2);
			$result2 = $consulta2->fetch_array();
			$senha = $result2['senha'];
			
			if($table == 'profissional'){
				
				$queryA = $conn->query("SELECT * FROM profissional WHERE email = '$login' AND senha = '$senha' AND id = $id AND ativo = 't' LIMIT 1");
				$resultA = $queryA->fetch_array();
				$_SESSION['login_profissional'] = $resultA;
			}else{
				
				$usuario_logado = $usuario_obj->getUsuarioLogado($login, $senha);
				$_SESSION['cliente_dados'] = $usuario_logado;
			}
		}
		
		$_SESSION['sucesso'] = "Atualizado com sucesso!";
		
		if($table == 'profissional'){
			
			header('Location:'.$urlC.'area-restrita');
		}elseif(($table == 'projeto' || $table == 'projeto_galeria') && $acao == TRUE){
			
			header("Location: {$_SERVER['HTTP_REFERER']}");
		}else{
			
			header('Location:'.$urlC.'minha-conta');
		}
	}
}else{
	
	$acao = FALSE;
	$_SESSION['aviso'] = "Erro ao atualizar cadastro!";
	
	if($table == 'profissional'){
			
		header('Location:'.$urlC.'area-restrita');
	}elseif(($table == 'projeto' || $table == 'projeto_galeria') && $acao == TRUE){
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}else{
		
		header('Location:'.$urlC.'minha-conta');
	}
}

?>