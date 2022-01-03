<?php 

class Produto extends Db{
	
	public function getProduto($id_produto){
		
		$conn = Db::connect();
		
		$produto = $conn->query("SELECT * FROM produto WHERE id = $id_produto AND ativo = 't'");
		return $produto->fetch_array();
	}
}
	
?>