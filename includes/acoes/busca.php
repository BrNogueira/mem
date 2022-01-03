<?php
$busca = $_POST['busca'];
$conn->query("INSERT INTO busca (nome) VALUES ('{$busca}')");
header("Location: {$urlC}produtos?busca={$busca}");
?>