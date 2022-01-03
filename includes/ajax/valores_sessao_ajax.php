<?php
$data['valor_total'] = $_SESSION['valor_total'];
$data['max_sem_juros'] = $_SESSION['max_sem_juros'];

echo json_encode($data);
?>