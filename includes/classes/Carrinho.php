<?php 

class Carrinho extends Db{
	
	public function calculaPesoTotal(){
		
		$peso_total = 0;
		
		foreach($_SESSION['carrinho_item'] as $carrinho_item){
			
			$peso_total	+= str_replace(",", ".", $carrinho_item['peso']) * $carrinho_item['quantidade'];
		}
		
		return $peso_total;
	}
}
	
?>