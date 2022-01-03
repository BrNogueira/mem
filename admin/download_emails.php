<?php 
header('Content-Disposition: attachment; filename=emails.txt');
header("Content-Type: text/plain");
include_once("includes/classes/Db.php"); 
include_once("includes/classes/Select.php");
include_once("includes/classes/Util.php"); 
$select = new Select();
if(base64_decode($_GET['acesso']) == 'mUser'){

		
	$select_fields	= 'DISTINCT email';			
	$select_table	= 'newsletter_email';	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= 'ORDER BY email ASC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);	

	while($result = $consulta->fetch_array()){
		
		echo strtolower($result['email']).';
';
	}
}else{

	header("location:".$urlC."home");
} ?>