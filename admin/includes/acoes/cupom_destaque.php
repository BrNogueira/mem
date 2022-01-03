
<?php
$id = $_POST['id'];

$conn->query("UPDATE cupom SET destaque = 'f'");
$conn->query("UPDATE cupom SET destaque = 't' WHERE id = {$id}");

$acao = TRUE;

$_SESSION['alerta']['ok'] = 'Atualizado com sucesso!';
header("Location: {$_SERVER['HTTP_REFERER']}");
?>