<?php
$var = $_POST['data_var'];
$quantidade = $_POST['quantidade'];
$_SESSION['criar_lista'][$var]['quantidade'] = $quantidade;
?>