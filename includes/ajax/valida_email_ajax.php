<?php
$email = $_POST['email'];
$alt = $_POST['alt'];

$select_fields	= '*';			
$select_table	= 'usuario';	
$select_join	= '';			
$select_where	= "WHERE email = '$email'";
$select_group	= '';
$select_order	= '';
$select_limit	= '';
$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group,
	$select_order, $select_limit);
	
echo $return = ($consulta->num_rows > 0 && $email != $alt)?(1):(0);
?>