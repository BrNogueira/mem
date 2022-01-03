<?php
$id = $_POST['id'];

$ip =  $_SERVER['REMOTE_ADDR'];

$queryI = $conn->query("SELECT * FROM visitados WHERE ip = '{$ip}'");
$resultI = $queryI->fetch_array();

$id_visitados = $resultI['id'];

$ids_visitados = str_replace('|'.$id.'|', '|', $resultI['array_produtos']);

$conn->query("UPDATE visitados SET array_produtos = '{$ids_visitados}' WHERE id = {$id_visitados}");
?>