<?php 
$id_produto = $_POST['id_produto'];
$id_cor 	= $_POST['id_cor'];
?>

<p class="no-margin"><b>Tamanho:</b></p>

<?php $add_sql = (isset($_SESSION['rel']))?(" AND rel_produto_var.id = {$_SESSION['c_rel']} "):(NULL); ?>
<?php
$select_fields5	= 'rel_produto_var.*, tamanho.nome AS tamanho';			
$select_table5	= 'rel_produto_var';	
$select_join5	= 'INNER JOIN tamanho ON tamanho.id = rel_produto_var.id_tamanho';			
$select_where5	= "WHERE rel_produto_var.estoque > 0 AND rel_produto_var.id_produto = {$id_produto} AND rel_produto_var.id_cor = {$id_cor} {$add_sql}
					AND ((
						SELECT COUNT(*) 
						FROM carrinho
						INNER JOIN pedido ON pedido.id = carrinho.id_pedido
					WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
					) = 0 OR rel_produto_var.estoque > (
						SELECT SUM(carrinho.quantidade) 
						FROM carrinho
						INNER JOIN pedido ON pedido.id = carrinho.id_pedido
						WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
					))";
$select_group5	= 'GROUP BY tamanho.id';
$select_order5	= 'ORDER BY tamanho.ordem DESC';
$select_limit5	= '';
$consulta5 = $select->selectDefault($select_fields5, $select_table5, $select_join5, $select_where5, $select_group5, $select_order5, $select_limit5);
?>

<?php if($consulta5->num_rows > 1){ ?>
	
	<style>
		.tamanhos-ok{ display: block !important; }
	</style>
	
	<div class="form-group">
        <select name="id_tamanho" class="form-control chosen-select" required>
        	<option value="0">...selecione um tamanho</option>
			<?php while($result5 = $consulta5->fetch_array()){ ?>
				<option value="<?php echo $result5['id_tamanho']; ?>"><?php echo $result5['tamanho']; ?></option>
			<?php } ?>
		</select>
    </div>
	
	<script>
		$(document).ready(function(){
			
			$('.chooser-tamanho [name=id_tamanho]').change(function(){
				
				setTimeout(function(){
					
					var dir 		= window.location.href.split('/');
					var urlC 		= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
					
					var id_produto 	= $('.id_produto').attr('id');
					var id_tamanho 	= $('[name=id_tamanho] option:selected').val();
					var id_cor 		= $('[name=id_cor]:checked').val();
					
					$('.modelos-ok').html('');
					$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val('');
					
					if(id_tamanho != ''){
						
						$.ajax({
						 	
							type: "POST",
							url: urlC+'modelos_ajax',
							data: {
								id_produto: id_produto,
								id_tamanho: id_tamanho,
								id_cor: id_cor
							},
						    success: function(data){
								
								setTimeout(function(){
									
									$('.modelos-ok').html(data);
									$('.modelos-ok').fadeIn(500);
								}, 500);
						    },
						    beforeSend: function(){
								$('.loader').fadeIn(100);
							},
							complete: function(){
								$('.loader').fadeOut(100);
							}
						});
					}else{
						
						$('.modelos-ok').html('');
					}
				},500);
			});
		});
	</script>
<?php }elseif($consulta5->num_rows == 1){ ?>
	
	<?php $result5 = $consulta5->fetch_array(); ?>
	
	<?php if($result5['id_tamanho'] == 0){ ?>
		<style>
			.tamanhos-ok{ display: none !important; }
		</style>
	<?php } ?>
	
	<div class="form-group">
        <select name="id_tamanho" class="form-control chosen-select" required>
			<option value="<?php echo $result5['id_tamanho']; ?>"><?php echo $result5['tamanho']; ?></option>
		</select>
    </div>
	
	<script>
		$(document).ready(function(){
			
			var dir 		= window.location.href.split('/');
			var urlC 		= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
			
			var id_produto 	= $('.id_produto').attr('id');
			var id_tamanho 	= $('[name=id_tamanho] option:selected').val();
			var id_cor 		= $('[name=id_cor]:checked').val();
			
			$.ajax({
			 	
				type: "POST",
				url: urlC+'modelos_ajax',
				data: {
					id_produto: id_produto,
					id_tamanho: id_tamanho,
					id_cor: id_cor
				},
			    success: function(data){
					
					setTimeout(function(){
						
						$('.modelos-ok').html(data);
						$('.modelos-ok').fadeIn(500);
					}, 500);
			    },
			    beforeSend: function(){
					$('.loader').fadeIn(100);
				},
				complete: function(){
					$('.loader').fadeOut(100);
				}
			});
		});
	</script>
<?php } ?>
