<style>
	.navbar{
		display: none;
	}
</style>

<?php if(isset($_SESSION['login'])){

	$acao = FALSE;
	
	if($_POST['acao'] == 'insert'){
		
		include('includes/acoes/insert.php');
	}elseif($_POST['acao'] == 'update'){
		
		include('includes/acoes/update.php');
	}elseif($_POST['acao'] == 'delete'){
		
		include('includes/acoes/delete.php');
	}elseif($_POST['acao'] == 'order'){
		
		include('includes/acoes/order.php');
	}elseif($_POST['acao'] == 'cover'){
		
		include('includes/acoes/cover.php');
	}elseif($_POST['acao'] == 'pre_postagem'){
		
		include('includes/acoes/pre_postar.php');
	}elseif($_POST['acao'] == 'orcamento'){
		
		include('includes/acoes/orcamento.php');
	}elseif($_POST['acao'] == 'reenviar_orcamento'){
		
		include('includes/acoes/reenviar_orcamento.php');
	}elseif($_POST['acao'] == 'cupom_destaque'){
		
		include('includes/acoes/cupom_destaque.php');
	}
	
	if($acao){
		
		$_SESSION['aviso']['ok']= "
			<div class='alert alert-success'>
				<button type='button' class='close fade in' data-dismiss='alert'>&times;</button>
					Sucesso ao executar esta ação!
			</div>"; 	
	}else{
		
		$_SESSION['aviso']['erro'] = "
			<div class='alert alert-error'>
				<button type='button' class='close fade in' data-dismiss='alert'>&times;</button>
					Falha ao executar esta ação!
			</div>" ; 
	}
	
	echo '<script>window.location.href = document.referrer</script>';	
}else{

	header("location:".$urlC."login");

} ?>