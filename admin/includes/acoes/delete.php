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
		echo '<script>history.go(-1)</script>';
	}
	
	unset($_POST['code']);
}

$id = $_POST['id'];
	
$query = $conn->query("SELECT * FROM {$table} WHERE id = {$id} LIMIT 1");
$result = $query->fetch_array();

if($table == 'newsletter'){
	
	$arquivo = fopen('newsletter/emails_news.txt','r+');
	
	if($arquivo){
		
		while(TRUE){
			
			$linha = fgets($arquivo);
			
			if($linha == NULL){
				
				break;
			}
			
			if(preg_match("/".$result['email'].";/", $linha)){
				
				$string .= str_replace($result['email'].";", "", $linha);
			} else {
				
				$string .= $linha;
			}
		}
		
		rewind($arquivo);
		ftruncate($arquivo, 0);
		fwrite($arquivo, $string);
		fclose($arquivo);
	}
}

if(isset($result['arquivo']) && !empty($result['arquivo']) && file_exists($result['arquivo'])){
		
	unlink($result['arquivo']);
}

if(isset($result['arquivo2']) && !empty($result['arquivo2']) && file_exists($result['arquivo2'])){
		
	unlink($result['arquivo2']);
}

if(isset($result['arquivo3']) && !empty($result['arquivo3']) && file_exists($result['arquivo3'])){
		
	unlink($result['arquivo3']);
}

if($delete->delete($table, $id)){
	
	$_SESSION['sucesso'] = 'Ação efetuada com sucesso!';
	echo '<script>history.go(-1)</script>';
}else{
	
	$_SESSION['aviso'] = 'Falha ao efetuar ação!';
	echo '<script>history.go(-1)</script>';
}

?>