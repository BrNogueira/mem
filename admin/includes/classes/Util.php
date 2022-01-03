<?php 
	
class Util extends Db{
	
	function __construct(){
		
	}
	
	public static function getTotalProducts()
	{
		$len = count($_SESSION['carrinho_item']);
		$total = 0;

		for ($i = 0; $i <= $len; $i++) { 
			$total += $_SESSION['carrinho_item'][$i]['quantidade'];
		}

		return $total;
	}

	public static function dePor($aprazo, $avista){
		//de e por
	$html = '';
	if ($aprazo != 0){
		$html .= '<p style="text-decoration:line-through;">';
		$html .= '<b>De:</b> R$ ' . number_format($aprazo, 2, ',', '.') . '</p>';
	}
		$html .= '<p><b>Por: </b><b style="font-size:20px; text-decoration:underline;">';
		$html .= 'R$ ' . number_format($avista, 2, ',', '.') . '</b></p>';
		return $html;
	}
	

	//leva o cliente à página anterior
	public static function setPrevPage(){
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['prevPage'] = $actual_link;
	}
	
	public static function prevPage(){
		if(isset($_SESSION['prevPage']))
			return $_SESSION['prevPage'];
	}

	public static function setflashMessage($message){
		$_SESSION['flash_message'] = $message;
	}

	public static function flashMessage(){
		if(isset($_SESSION['flash_message']))
			return $_SESSION['flash_message'];
	}

	public static function unsetFlashMessage(){
		if(isset($_SESSION['flash_message']))
			unset($_SESSION['flash_message']);
	}

	public static function fixDiaMes($data){
		$data = explode('-', $data);
		return $data[2] .'/' . $data[1];
	}

	public static function fixDia($data){
		$data = explode('-', $data);
		return $data[2];
	}

	public static function fixMes($data){
		$data = explode('-', $data);
		return $data[1];
	}

	public static function fixAno($data){
		$data = explode('-', $data);
		return $data[0];
	}

	public static function fixData($data){
		$data = explode('-', $data);
		return $data[2] .'/' . $data[1] . '/' . $data[0];
	}

	public static function fixDataDb($data){
		if(!empty($data)){
			
			$data = explode('/', $data);
			return $data[2] .'-' . $data[1] . '-' . $data[0];
		}else{
			
			return NULL;
		}
	}
		
	public static function fixDataHora($data_hora){
		$data_hora = explode(' ', $data_hora);
		$data = $data_hora[0];
		$data = explode('-', $data);
		$data = $data[2].'/'.$data[1].'/'.$data[0];
		$hora = $data_hora[1];
		return $data.' '.$hora;
	}
		
	public static function fixDataHoraDb($data_hora){
		$data_hora = explode(' ', $data_hora);
		$data = $data_hora[0];
		$data = explode('/', $data);
		$data = $data[2].'-'.$data[1].'-'.$data[0];
		$hora = $data_hora[1];
		return $data.' '.$hora;
	}
	
	public static function fixDataSemHora($data_hora){
		$data_hora = explode(' ', $data_hora);
		$data = $data_hora[0];
		$data = explode('-', $data);
		$data = $data[2].'/'.$data[1].'/'.$data[0];
		$hora = $data_hora[1];
		return $data;
	}
	
	public static function fixValor($valor){
			
		$valor = number_format($valor, 2, ',', '.');
		return $valor;
	}

	public static function fixValorInput($valor){
			
		$valor = number_format($valor, 2);
		return $valor;
	}

	public static function fixValorDb($valor){
			
		$valor = str_replace(',', '.', $valor);
		return $valor;
	}
	
	public static function itemExplode($key, $string, $separator){
		
		$array = explode($separator, $string);
		
		return $array[$key];
	}

	public static function isLogged(){
		
		if(isset($_SESSION['cliente_dados']['email']) && !empty($_SESSION['cliente_dados']['email'])){
			
			return true;
		}
	}

	public static function existeCarrinho(){
		
		if(count($_SESSION['carrinho_item']) > 0){
			
			return true;	
		}
	}
	
	public static function jaCadastrado($email){
		
		$conn = Db::connect();
		
		$sql = $conn->query("SELECT * FROM usuario WHERE email = '$email'");
		
		if($sql->num_rows > 0){
			
			return true;
		}
	}
	
	public static function jaCadastradoNews($email){
		
		$conn = Db::connect();
		
		$sql = $conn->query("SELECT * FROM newsletter_email WHERE email = '$email'");
		if($sql->num_rows > 0){
			
			return true;
		}
	}
	
	public static function removeTags($texto){
		
		/*$texto = str_replace('<div>','<p>',$texto);
		$texto = str_replace('</div>','</p>',$texto);
		$texto = str_replace('&nbsp;','',$texto);*/
		
		$tags_to_strip = Array('div');
		
		foreach($tags_to_strip as $tag){
			
		    $texto = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", "", $texto);
		}
		
		$texto = trim($texto);
			
		return $texto;
	}
	
	public static function fixTelefone($telefone){
		
		$telefone = str_replace('(','<span>',$telefone);
		$telefone = str_replace(')','</span>',$telefone);
			
		return $telefone;
	}
	
	public static function retiraAcentos($texto){
		
		$troca = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
		$por = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
		$texto = str_replace($troca, $por, $texto);
		$texto = strtolower($texto);
		return $texto;
	}
	
	public static function colocaAcentos($texto){
		
		$troca = array('&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&ugrave;','&uuml;','&uacute;','&yuml;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&Ugrave;','&Uuml;','&Uacute;','&Yuml;',);
		$por = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
		$texto = str_replace($troca, $por, $texto);
		$texto = strtolower($texto);
		return $texto;
	}
	
	public static function removeAcentos($string){
		
		$string = strtr(utf8_decode($string),utf8_decode("ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿºª"),"SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyyoa");
		
		return $string;
	}
	
	public static function trataTelefonePg($telefone){
		
		$telefone = str_replace(' ', '', $telefone);
		$telefone = str_replace('-', '', $telefone);
		$telefone = str_replace('_', '', $telefone);
		$telefone = str_replace('.', '', $telefone);
		$telefone = str_replace(',', '', $telefone);
		$telefone = substr($telefone, 0, 9);
		
		$telefone = preg_replace('#[^0-9]#','',strip_tags($telefone));
		
		return $telefone;
	}
	
	public static function trataEmailPg($email){
		
		$email = str_replace(' ', '', $email);
		$email = str_replace(',', '.', $email);
		
		return $email;
	}
	
	public static function trataHtml($result){
		
		foreach($result as $var => $htmlentities){
		
			$result[$var] = htmlentities(utf8_decode($htmlentities));
		}
		
		return $result;
	}
	
	public static function trataLink($link){
		
		if(!empty($link)){
			
			$link = (stristr($link, 'http') == TRUE)?($link):('http://'.$link);
		}else{
			
			$link = 'javascript:void(0)';
		}
		
		return $link;
	}
	
	public static function introTexto($texto, $tamanho){
		
		if(strlen($texto) >= $tamanho){
		
			$texto = strip_tags($texto);
			$texto = mb_substr($texto, 0, $tamanho, 'UTF-8').'...';
		}
		
		return $texto;
	}
	
	public static function textoIntro($texto, $tamanho){
		
		if(strlen($texto) >= $tamanho){
		
			$texto = strip_tags($texto);
			$texto = mb_substr($texto, 0, $tamanho, 'UTF-8');
		}
		
		return $texto;
	}
	
	public static function trimPg($result){
		
		foreach($result as $var => $trim){
		
			$result[$var] = trim($trim);
			$result[$var] = str_replace('  ', ' ', $result[$var]);
		}
		
		return $result;
	}
	
	public static function fretePesoExcedente($peso_total, $valor_por_30){
		
		$peso_excedente = $peso_total - 30;
		$porcentagem_por_kg = 100/30;
		$porcentagem_excedente = $peso_excedente * $porcentagem_por_kg;
		$frete_total = $valor_por_30 + ($valor_por_30 * ($porcentagem_excedente / 100));
		
		return $frete_total;
	}
	
	public static function telefones_array($telefones_array){
		
		$lista_telefones 	= NULL;
		$cont_telefone		= 0;
		$telefones 			= explode('/', $telefones_array);
		
		foreach($telefones as $telefone){
			
			$cont_telefone++;
			$telefones_ddds = explode(' ', $telefone);
			$cont_field 	= 0;
			$telefone_item = NULL;
			
			foreach($telefones_ddds as $var => $telefone_ddd){
				
				if(!empty($telefone_ddd)){
					
					$cont_field++;
				}
				
				$telefone_item .= ($cont_field == 1)?('<small>'.$telefone_ddd.'</small> '):($telefone_ddd);
			}
			
			$lista_telefones .= ($cont_telefone > 1)?('<br/>'.$telefone_item):($telefone_item);
		}
		
		return $lista_telefones;
	}
	
	public static function apenasNumeros($string){
		
		$string = preg_replace('#[^0-9]#','',strip_tags($string));
		
		return $string;
	}
	
	public static function telefonePg($telefone){
		
		$telefone 		= explode(')', $telefone);
		$telefone[0]	= Util::apenasNumeros($telefone[0]);
		$telefone[1]	= Util::apenasNumeros($telefone[1]);
		
		return $telefone;
	}
	
	public static function fixEncodeErp($string){
		
		$item_explode = Util::itemExplode(0, $string, 'x');
		
		if(is_numeric($item_explode) && strlen($item_explode) == 1){
			
			$string = NULL;
		}
		
		$string = utf8_encode(trim($string));
		
		return $string;
	}
	
	public static function microtimeFloat(){ 
	
	    list($usec, $sec) = explode(" ", microtime()); 
	    
	    return ((float)$usec + (float)$sec); 
	} 
	
	public static function strToUrl($string){ 
	
	    $string = str_replace(' ', '_', strtolower(Util::retiraAcentos(trim($string))));
	    
	    return $string; 
	} 
	
	public static function fixToUrl($string){ 
	
	    $string = str_replace('.', '&', str_replace('/', '+', $string));
	    
	    return $string; 
	} 
	
	public static function fixUrl($string){ 
	
	    $string = str_replace('&', '.', str_replace('+', '/', $string));
	    
	    return $string; 
	} 
	
	public static function paginacao($max, $sql){ 
		
		$conn = Db::connect();
		
		$url_full 	= $_SERVER['REQUEST_URI'];
		$url_pagina = explode('?', $url_full);
		$url_pagina = $url_pagina[0];
		$pagina 	= (isset($_GET['p']) && !empty($_GET['p']))?($_GET['p']):(1);
		$url_base 	= $url_pagina; 
		$limite 	= 'LIMIT '.$max;
		$ate 		= $max;
		$de 		= $pagina * $max - $max;
		$limite 	= 'LIMIT '.$de.', '.$ate;
		$url_base 	= $url_pagina; 
						
		$consulta = $conn->query("$sql");
		
		$total = $consulta->num_rows;
		
		$listagem = 'Máximo de '.$max.' por página. Pág: ';
		$numero_itens = 0;
		$paginacao_item = 0;
		
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['p'])){
					
					unset($_GET['p']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
								
				$bold = ($pagina == $paginacao_item || ($pagina == 0 && $paginacao_item == 1))?('style="font-weight:bold; text-decoration:underline;"'):(NULL);
				$listagem .= ($paginacao_item > 1)?('&nbsp;|'):('&nbsp;');
				$listagem.= '&nbsp;<a href="'.$url_base.'?p='.$paginacao_item.$more_get.'"'.$bold.'>'.$paginacao_item.'</a>';
			}
		}
		
		$consulta2 = $conn->query("$sql $limite");
		
		$cont = 0;
		$paginacao_limite[5] = NULL;
		
		while($result2 = $consulta2->fetch_array()){
			
			$cont++;
			
			$paginacao_limite[5] .= ($cont == 1)?($result2['id']):(','.$result2['id']);
		}
		
		$paginacao_limite[0] = $paginacao_item;
		$paginacao_limite[1] = ($paginacao_item > 1)?($listagem):(NULL);
		$paginacao_limite[2] = $limite;
		$paginacao_limite[3] = $total;
		$paginacao_limite[4] = $url_pagina;
		
		return $paginacao_limite;
	} 
	
	public static function paginacao_front($max, $sql){ 
		
		$conn = Db::connect();
		
		$url_full 	= $_SERVER['REQUEST_URI'];
		$url_pagina = explode('?', $url_full);
		$url_pagina = $url_pagina[0];
		$pagina 	= (isset($_GET['pagina']) && !empty($_GET['pagina']))?($_GET['pagina']):(1);
		$url_base 	= $url_pagina; 
		$limite 	= 'LIMIT '.$max;
		$ate 		= $max;
		$de 		= $pagina * $max - $max;
		$limite 	= 'LIMIT '.$de.', '.$ate;
		$url_base 	= $url_pagina; 
						
		$consulta = $conn->query("$sql");
		
		$total = $consulta->num_rows;
		$total_paginas = ceil($total / $max);
		
		$listagem = '<ul class="pagination pull-right">';
		$range = 5;
		
		$numero_itens = 0;
		$paginacao_item = 0;
		
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['pagina'])){
					
					unset($_GET['pagina']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
							
				if($paginacao_item == 1 && $pagina > 2){
					
					$pagina_primeira = $paginacao_item;
					
					$listagem .= '<li class="page-item"><a href="'.$url_base.'?pagina='.$pagina_primeira.$more_get.'" class="page-link"><i class="fa fa-angle-double-left visible-inline-block-xs"></i>&nbsp;<span class="hidden-xs">Primeira</span></a></li>';
					break;
				}				
			}
		}
		
		$numero_itens = 0;
		$paginacao_item = 0;
		
		$consulta->data_seek(0);
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['pagina'])){
					
					unset($_GET['pagina']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
							
				if($paginacao_item == ($pagina - 1) && $pagina > 1){
					
					$pagina_anterior = $paginacao_item;
					
					$listagem .= '<li class="page-item"><a href="'.$url_base.'?pagina='.$pagina_anterior.$more_get.'" class="page-link"><i class="fa fa-angle-left"></i>&nbsp;<span class="hidden-xs">Anterior</span></a></li>';
					break;
				}				
			}
		}
		
		$numero_itens = 0;
		$paginacao_item = 0;
		
		$consulta->data_seek(0);
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['pagina'])){
					
					unset($_GET['pagina']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
				
				$visible_mobile = (($paginacao_item < ($pagina - 3)) or ($paginacao_item > ($pagina + 3)))?('hidden-xs hidden-sm'):(NULL);
												
				$active = ($pagina == $paginacao_item || ($pagina == 0 && $paginacao_item == 1))?('active'):(NULL);
				
				if(($paginacao_item >= ($pagina - $range)) && ($paginacao_item <= ($pagina + $range))){
					
					$listagem .= '<li class="page-item '.$visible_mobile.' '.$active.'"><a href="'.$url_base.'?pagina='.$paginacao_item.$more_get.'" class="page-link '.$active.'">'.$paginacao_item.'</a></li>';
				}
			}
		}
		
		$numero_itens = 0;
		$paginacao_item = 0;
		
		$consulta->data_seek(0);
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['pagina'])){
					
					unset($_GET['pagina']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
							
				if($paginacao_item == ($pagina + 1) && $pagina < $total_paginas){
					
					$pagina_posterior = $paginacao_item;
					
					$listagem .= '<li class="page-item"><a href="'.$url_base.'?pagina='.$pagina_posterior.$more_get.'" class="page-link"><span class="hidden-xs">Próxima</span>&nbsp;<i class="fa fa-angle-right"></i></a></li>';
					break;
				}				
			}
		}
		
		$numero_itens = 0;
		$paginacao_item = 0;
		
		$consulta->data_seek(0);
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				if(isset($_GET['pagina'])){
					
					unset($_GET['pagina']);					
				}
				
				$more_get = (count($_GET) > 0)?('&'.http_build_query($_GET)):(NULL);
							
				if($paginacao_item == ($total_paginas - 1) && $pagina < ($total_paginas - 1)){
					
					$pagina_ultima = $paginacao_item + 1;
					
					$listagem .= '<li class="page-item"><a href="'.$url_base.'?pagina='.$pagina_ultima.$more_get.'" class="page-link"><span class="hidden-xs">Última</span>&nbsp;<i class="fa fa-angle-double-right visible-inline-block-xs"></i></a></li>';
					break;
				}				
			}
		}
		
		$listagem .= '</ul>';
		
		$consulta2 = $conn->query("$sql $limite");
		
		$cont = 0;
		$paginacao_limite[5] = NULL;
		
		while($result2 = $consulta2->fetch_array()){
			
			$cont++;
			
			$paginacao_limite[5] .= ($cont == 1)?($result2['id']):(','.$result2['id']);
		}
		
		$paginacao_limite[0] = $paginacao_item;
		$paginacao_limite[1] = ($paginacao_item > 1)?($listagem):(NULL);
		$paginacao_limite[2] = $limite;
		$paginacao_limite[3] = $total;
		$paginacao_limite[4] = $url_pagina;
		
		return $paginacao_limite;
	}
	
	public static function paginacaoItens($max, $sql){ 
		
		$conn = Db::connect();
		
		$url_pagina = $_SERVER['REQUEST_URI'];
		$url_pagina = explode('?', $url_pagina);
		$url_pagina = $url_pagina[0];
		$pagina 	= (isset($_GET['p']) && !empty($_GET['p']))?($_GET['p']):(1);
		$url_base 	= $url_pagina; 
		$limite 	= 'LIMIT '.$max;
		$ate 		= $max;
		$de 		= $pagina * $max - $max;
		$limite 	= 'LIMIT '.$de.', '.$ate;
				
		$consulta 	= $conn->query("$sql");
		$total 		= $consulta->num_rows;
		
		//$listagem 		= 'Máximo de '.$max.' por página. Pág: ';
		$numero_itens 	= 0;
		$paginacao_item = 0;
		
		while($pag = $consulta->fetch_array()){
			
			$numero_itens++;
			
			if($numero_itens%$max == 1){ 
			
				$paginacao_item++;
				
				$bold = ($pagina == $paginacao_item || ($pagina == 0 && $paginacao_item == 1))
						?('class="ativo"'):(NULL);
						
				$listagem.= '&nbsp;<a href="'.$url_base.'?p='.$paginacao_item.'"'.$bold.'>'.$paginacao_item.'</a>';
			}
		}
		
		$consulta2 = $conn->query("$sql $limite");
		
		$paginacao_limite[5] = 0;
		
		while($result2 = $consulta2->fetch_array()){
			
			$paginacao_limite[5] .= ','.$result2['id'];
		}
		
		$paginacao_limite[0] = $paginacao_item;
		$paginacao_limite[1] = ($paginacao_item > 1)?($listagem):(NULL);
		$paginacao_limite[2] = $limite;
		$paginacao_limite[3] = $total;
		$paginacao_limite[4] = $url_pagina;
		
		return $paginacao_limite;
	} 
	
	public static function existeImagem($codigo_erp){
		
        $dir = '../fotos_ok/'.$codigo_erp;
        $array = glob($dir.'*');
        
        if(!empty($array[0])){
			
            return TRUE;
		}else{
			
            return FALSE;
		}
	}
	
	public static function imgErp($url, $codigo_erp){
		
        $dir = '../fotos_ok/'.$codigo_erp;
        $array = glob($dir.'*');
        
        if(!empty($array[0])){
			
            return $url.'admin/'.$array[0];
		}else{
			
            return $url.'img/no_photo.jpg';
		}
	}
	
	public static function dataPost($data){
		
		$data = explode('-', $data);
		
		switch($data[1]){
			case '01': $data[1] = 'jan'; break;
			case '02': $data[1] = 'fev'; break;
			case '03': $data[1] = 'mar'; break;
			case '04': $data[1] = 'abr'; break;
			case '05': $data[1] = 'mai'; break;
			case '06': $data[1] = 'jun'; break;
			case '07': $data[1] = 'jul'; break;
			case '08': $data[1] = 'ago'; break;
			case '09': $data[1] = 'set'; break;
			case '10': $data[1] = 'out'; break;
			case '11': $data[1] = 'nov'; break;
			case '12': $data[1] = 'dez'; break;
		}
		
		return $data;
	}
	
	public static function dataMesString($data){
		
		$data = explode('-', $data);
		
		switch($data[1]){
			case '01': $data[1] = 'Janeiro'; break;
			case '02': $data[1] = 'Favereiro'; break;
			case '03': $data[1] = 'Março'; break;
			case '04': $data[1] = 'Abril'; break;
			case '05': $data[1] = 'Maio'; break;
			case '06': $data[1] = 'Junho'; break;
			case '07': $data[1] = 'Julho'; break;
			case '08': $data[1] = 'Agosto'; break;
			case '09': $data[1] = 'Setembro'; break;
			case '10': $data[1] = 'Outubro'; break;
			case '11': $data[1] = 'Novembro'; break;
			case '12': $data[1] = 'Dezembro'; break;
		}
		
		return $data[1].' '.$data[2].', '.$data[0];
	}
	
	public static function dataDiaSemana($data){
		
		$diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
		$data = date($data);
		$diasemana_numero = date('w', strtotime($data));

		return $diasemana[$diasemana_numero];
	}
	
	public static function dataMesAno($data){
		
		$data = explode('-', $data);
		
		switch($data[1]){
			case '01': $mes_ano = 'Janeiro '.$data[0]; break;
			case '02': $mes_ano = 'Fevereiro '.$data[0]; break;
			case '03': $mes_ano = 'Março '.$data[0]; break;
			case '04': $mes_ano = 'Abril '.$data[0]; break;
			case '05': $mes_ano = 'Maio '.$data[0]; break;
			case '06': $mes_ano = 'Junho '.$data[0]; break;
			case '07': $mes_ano = 'Julho '.$data[0]; break;
			case '08': $mes_ano = 'Agosto '.$data[0]; break;
			case '09': $mes_ano = 'Setembro'.$data[0]; break;
			case '10': $mes_ano = 'Outubro '.$data[0]; break;
			case '11': $mes_ano = 'Novembro '.$data[0]; break;
			case '12': $mes_ano = 'Dezembro '.$data[0]; break;
		}
		
		return $mes_ano;
	}
	
	public static function dataMes($mes){
		
		switch($mes){
			case '01': $mes = 'Janeiro '; break;
			case '02': $mes = 'Fevereiro '; break;
			case '03': $mes = 'Março '; break;
			case '04': $mes = 'Abril '; break;
			case '05': $mes = 'Maio '; break;
			case '06': $mes = 'Junho '; break;
			case '07': $mes = 'Julho '; break;
			case '08': $mes = 'Agosto '; break;
			case '09': $mes = 'Setembro'; break;
			case '10': $mes = 'Outubro '; break;
			case '11': $mes = 'Novembro '; break;
			case '12': $mes = 'Dezembro '; break;
		}
		
		return $mes;
	}
	
	public static function fixMmAaaa($data){
		
		$data = explode('-', $data);
		
		return $data[1].'-'.$data[0];
	}
	
	/**  **/
	
	public static function mascaraThemis($numero){ 
	
	    $themis  = substr($numero,0,3).'/';
	    $themis .= substr($numero,3,1).'.';
	    $themis .= substr($numero,4,2).'.';
	    $themis .= substr($numero,6,7).'-';
	    $themis .= substr($numero,13,1);
	    
	    return $themis;
	}
	
	public static function mascaraCnj($numero){ 
	
	    $cnj  = substr($numero,0,7).'-';
	    $cnj .= substr($numero,7,2).'.';
	    $cnj .= substr($numero,9,3).'.';
	    $cnj .= substr($numero,12,1).'.';
	    $cnj .= substr($numero,13,2).'.';
	    $cnj .= substr($numero,15,4);
	    
	    return $cnj;
	}
	
	public static function mascaraCnpjCpf($documento){
		
	    if(strlen($documento) == 14){
	    	
	        $documento = substr($documento, 0, 2).'.'.
	        substr($documento, 2, 3).'.'.
	        substr($documento, 5, 3).'/'.
	        substr($documento, 8, 4).'-'.
	        substr($documento, 12, 2);
	        
	        return $documento;
	        
	    }elseif(strlen($documento) == 11){
	    	
	        $documento = substr($documento, 0, 3).'.'.
	        substr($documento, 3, 3).'.'.
	        substr($documento, 6, 3).'-'.
	        substr($documento, 9, 2);
	        
	        return $documento;
	        
	    }else{
	    	
	        return false;
	    }
	}
	
	public static function isMobile(){
		
	    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	public static function windowSize(){
		
		return '<script>$(window).width()</script>';
	}
	
	public static function botDetected(){

		if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])){
			
			return TRUE;
		}else{
			
			return FALSE;
		}
	}
	
	public static function imgResize($target, $newcopy, $w, $h, $ext){
	
	    list($w_orig, $h_orig) = getimagesize($target);
	    
	    if($w_orig > $w || $h_orig > $h){
				    
		    $scale_ratio = $w_orig / $h_orig;
		    
		    if(($w / $h) > $scale_ratio){
		    	
		    	$w = $h * $scale_ratio;
		    }else{
		    	
				$h = $w / $scale_ratio;
		    }
		    
		    $img = "";
		    $ext = strtolower($ext);
		    
		    if($ext == "gif"){ 
		    
		      $img = imagecreatefromgif($target);
		    }elseif($ext == "png"){ 
		    
		      $img = imagecreatefrompng($target);
		    }else{ 
		    
		      $img = imagecreatefromjpeg($target);
		    }
		    
		    $tci = imagecreatetruecolor($w, $h);
		    
		    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
		    imagejpeg($tci, $newcopy, 90);
		}
	}
	
	public static function antiInjection($sql){
	
		$sql = @preg_replace("/(from|select|insert|delete|where|drop table|show tables|\*|--|\\\\)/","",$sql);
		$sql = trim($sql);
		$sql = strip_tags($sql);
		$sql = addslashes($sql);
		
		return $sql;
	}
	
	public static function videoId($url){
	
		$video_id = NULL;
		
		if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)){
			
			$video_id = $match[1];
		}

		return $video_id;
	}
	
	public static function mediaAvaliacao($id){
	
	    $conn = Db::connect();
	    
	    $media = 0;
	    
	    $query = $conn->query("SELECT * FROM avaliacao WHERE id_produto = {$id}");
	    $votos = $query->num_rows;
	    
	    if($votos > 0){
			
			$query = $conn->query("SELECT SUM(nota) AS total FROM avaliacao WHERE id_produto = {$id}");
		    $result = $query->fetch_array();
		    $total = $result['total'];
		    
		    $media = floor($total / $votos);
		}
	    
	    return $media;
	}
	
	public static function produtosVisitados($id){
	
	    $conn = Db::connect();
	    
		$ip =  $_SERVER['REMOTE_ADDR'];
		
		$queryI = $conn->query("SELECT * FROM visitados WHERE ip = '{$ip}'");
		
		if($queryI->num_rows == 0){
			
			$conn->query("INSERT INTO visitados (ip, array_produtos) VALUES ('{$ip}', '|')");
			
			$queryI = $conn->query("SELECT * FROM visitados WHERE ip = '{$ip}'");
		}
		
		$resultI = $queryI->fetch_array();
		
		$id_visitados = $resultI['id'];
		
		$array_produtos = array_filter(explode('|', $resultI['array_produtos']));
		
		if(!in_array($id, $array_produtos)){
			
			array_push($array_produtos, $id);
			
			$array_produtos = '|'.implode('|', $array_produtos).'|';
			
			$conn->query("UPDATE visitados SET array_produtos = '{$array_produtos}' WHERE id = {$id_visitados}");
		}
	}
	
	public static function validaCidadeFrete(){
		
		if(Util::isLogged()){
			
		    $conn = Db::connect();
		    
		    if($_SESSION['novo_endereco']['ativo'] == FALSE || empty($_SESSION['novo_endereco']['cep'])){
		    	
		    	$cidade = $_SESSION['cliente_dados']['cidade'];
		    	$uf = $_SESSION['cliente_dados']['uf'];
			}else{
				
				$cidade = $_SESSION['novo_endereco']['cidade'];
		    	$uf = $_SESSION['novo_endereco']['uf'];
			}
		    
			$query = $conn->query("SELECT frete_cidade.* 
			FROM frete_cidade
			INNER JOIN cidade ON cidade.id = frete_cidade.id_cidade
			INNER JOIN estado ON estado.id = cidade.id_estado
			WHERE cidade.nome = '{$cidade}' AND estado.uf = '{$uf}'
			GROUP BY frete_cidade.id");
			
			if($query->num_rows == 1){
				
				$result = $query->fetch_array();
				
				return $result['valor'];
			}else{
				
				return FALSE;
			}
		}
	}
	
	public static function minimoCidadeFrete(){
		
		if(Util::isLogged()){
			
		    $conn = Db::connect();
		    
		    if($_SESSION['novo_endereco']['ativo'] == FALSE || empty($_SESSION['novo_endereco']['cep'])){
		    	
		    	$cidade = $_SESSION['cliente_dados']['cidade'];
		    	$uf = $_SESSION['cliente_dados']['uf'];
			}else{
				
				$cidade = $_SESSION['novo_endereco']['cidade'];
		    	$uf = $_SESSION['novo_endereco']['uf'];
			}
		    
			$query = $conn->query("SELECT frete_cidade.* 
			FROM frete_cidade
			INNER JOIN cidade ON cidade.id = frete_cidade.id_cidade
			INNER JOIN estado ON estado.id = cidade.id_estado
			WHERE cidade.nome = '{$cidade}' AND estado.uf = '{$uf}'
			GROUP BY frete_cidade.id");
			
			if($query->num_rows == 1){
				
				$result = $query->fetch_array();
				
				return $result['minimo_gratis'];
			}else{
				
				return FALSE;
			}
		}
	}
	
	public static function freteGratis(){
		
		$conn = Db::connect();
		
		$query_frete = $conn->query("SELECT * FROM frete LIMIT 1");
        $result_frete = $query_frete->fetch_array();
        
        return $result_frete['valor_minimo_frete_gratis'];
	}
	
	public static function formatCnpjCpf($value){
		
		$cnpj_cpf = preg_replace("/\D/", '', $value);

		if(strlen($cnpj_cpf) === 11){

			return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
		} 

		return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
	}
	
	public static function valorReal($valor, $valor_promocional, $data_inicio, $data_fim){
		
		$now = date('Y-m-d');
		
		if($valor_promocional > 0 && (empty($data_inicio) or $now >= $data_inicio) && (empty($data_fim) or $now <= $data_fim)){
			
			return 	$valor_promocional;
		}else{
			
			return 	$valor;
		}
	}
	
	public static function gerarParcelas($valor, $taxa, $parcelas) {
		
		if($taxa > 0){
			
			$taxa = $taxa / 100;
			
			$total_parcela = $valor * $taxa / (1 - pow(1 + $taxa, - $parcelas));
			$total = $total_parcela * $parcelas;
		}else{
			
			$total_parcela = $valor / $parcelas;
		}

		return number_format($total_parcela,2,'.','');
	}
	
	public static function xSemJuros($valor) {
		
		$valor_minimo = 5;
		
		$fracao = floor($valor / $valor_minimo);
		
		if($fracao > $_SESSION['max_sem_juros']){
			
			$parcelamento = $_SESSION['max_sem_juros'];
		}else{
			
			$parcelamento = $fracao;
		}

		return $parcelamento;
	}
}
?>