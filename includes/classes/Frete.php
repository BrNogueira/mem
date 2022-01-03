<?php

class Frete extends Db{

	//transforma valores em gramas
	public static function weight2grams($peso) {
		
		$newPeso = str_replace(',','', $peso);
		
		return $newPeso;
	}

	public static function totalWeight(){

	}
	
	public static function isGratis($cep)
	{
		$temp 	= str_replace(array('.',',','-'), '', $cep);
		$cep	= intval($temp);
		/*if($cep >= 90000001 && $cep <= 91999999){
			
			return true;
		}else{ 
			
			return false; 
		}*/
			return false; 
	}

	public function calculaFrete($_cepdestino, $_peso, $_valor, $_tipoentrega){
		
		$conn = Db::connect();
			
		$config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$result_config = $config->fetch_array();
		
		if( $_tipoentrega == "EN" && Frete::isGratis($_cepdestino) )
			return "0.00";
		
			$tipoEntrega = $_tipoentrega;
			$CEP_ORIGEM = $result_config['cep_remetente'];
			$PESO  = $_peso;
			$VALOR = str_replace('.', ',', $_valor);
			$CEP_DESTINO = $_cepdestino;

			// CHAMADA DO ARQUIVO QUE CONTEM A CLASSE PgsFrete()
	   		require_once('FretePs.php');
	   		// INSTANCIANDO A CLASSE
	   		$frete = new PgsFrete;
	   		// ZERANDO VALORES
	   		$valorFrete = 0.0;
	   		// CALCULANDO O FRETE
	   		$valorFrete = $frete->gerar($CEP_ORIGEM, $PESO, $VALOR, $CEP_DESTINO);
	  		// CONDIÇÃO
	   		if($tipoEntrega == "SD" || $tipoEntrega == "EN") {
		    	if(is_array($valorFrete)) {
					if($tipoEntrega == "SD") {
						return $valorFrete["Sedex"];
					} else {
			    		return $valorFrete["PAC"];
		        	}
		    	}
		 	}else{							
				$valorFrete = "0.00";
		}
	}

}

?>