<?php

$acao = FALSE;

switch($_POST['acao']){
	
	case 'send'					: include('acoes/send.php');				break;
	case 'delete'				: include('acoes/delete.php');				break;
	case 'update'				: include('acoes/update.php');				break;
	case 'insert'				: include('acoes/insert.php');				break;
}

?>