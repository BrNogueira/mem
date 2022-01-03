<?php 
class Db{
	
	const HOST     = 'mysql.memkids.com.br';
	const USERNAME = 'memkids';
	const PASSWORD = 'bdmk2705';
	const DATABASE = 'memkids';
	const CHARSET  = 'utf8';
		
	/*const HOST     = 'localhost';
	const USERNAME = 'root';
	const PASSWORD = '';
	const DATABASE = 'memkids_01';
	const CHARSET  = 'utf8';*/

	public function __construct($conn = null){
		
		$this->connect();
	}

	public static function connect(){
		
		$conn = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE);
		$conn->set_charset(self::CHARSET);
		
		if($conn){
			
			return $conn;
		}else{
						
			throw new Exception("Problemas ao conectar-se ao banco de dados", 1);
		}
	}
}
?>
