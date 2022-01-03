
<?php

$var = $_POST['var'];

$_SESSION['carrinho_item'][$var]['quantidade'] = $_POST['quantidade'];
		
header('location:'.$urlC.'carrinho');

?>
