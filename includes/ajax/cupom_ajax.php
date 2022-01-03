<?php
$codigo = $_POST['codigo'];

$_SESSION['cupom_valido'] = FALSE;

$query = $conn->query("SELECT * FROM cupom WHERE ativo = 't' AND codigo = '$codigo' LIMIT 1");
	
if($query->num_rows == 0){ ?>
	
	<?php
	$_SESSION['cupom_valido'] = FALSE;
	$_SESSION['cupom'] = FALSE;
	?>
	
	<?php $_SESSION['aviso'] = '<p class="text-danger">Cupom inválido!</p>'; ?>
	
	<script>location.reload()</script>
<?php }else{
	
	$result = $query->fetch_array();
	
	if(date('Y-m-d') < $result['data_inicio'] || date('Y-m-d') > $result['data_fim']){ ?>
		
		<?php
		$_SESSION['cupom_valido'] = FALSE;
		$_SESSION['cupom'] = FALSE;
		?>
		
		<?php $_SESSION['aviso'] = '<p class="text-danger">Cupom expirado!</p>'; ?>
		
		<script>location.reload()</script>
	<?php }else{ ?>
		
		<?php if($result['tipo'] == 'r' && $result['valor'] > $_SESSION['subtotal']){ ?>
			
			<?php
			$_SESSION['cupom_valido'] = FALSE;
			$_SESSION['cupom'] = FALSE;
			?>
			
			<?php $_SESSION['aviso'] = '<p class="text-danger">O total em produtos não pode ser inferior ao valor do desconto!<br/>
				Cupom: <b class="text-color">'.$result['nome'].'</b><br/>
				Desconto: <b class="text-danger">R$ '.Util::fixValor($result['valor']).'</b>
			</p>'; ?>
						
			<script>location.reload()</script>
		<?php }else{ ?>
			
			<?php
			$_SESSION['cupom_valido'] = TRUE;
			$_SESSION['cupom'] = $result;
			?>
			
			<p>
				<b class="text-success text-uppercase">Cupom OK!</b><br/>
				Cupom: <span class="text-color"><?php echo $_SESSION['cupom']['nome']; ?></span><br/>
				Desconto: <span class="text-color"><?php echo $desconto_cupom = ($_SESSION['cupom']['tipo'] == 'p')?($_SESSION['cupom']['valor'].'%'):('R$ '.Util::fixValor($_SESSION['cupom']['valor'])); ?></span>
			</p>
			
			<script>location.reload()</script>
		<?php } ?>
	<?php }
}
?>