<?php

if(isset($_POST['cep_simulacao']) && !empty($_POST['cep_simulacao'])){
	
	$_SESSION['cliente_dados']['cep'] = $_POST['cep_simulacao'];
}

echo '<script>window.location.href = document.referrer</script>';

?>