<?php
$var = $_POST['data_var'];
$observacao = $_POST['observacao'];
$_SESSION['criar_lista'][$var]['observacao'] = $observacao;
?>