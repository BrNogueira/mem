
<span data-active="frete"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Frete Grátis';
	
	$table = $update_table = 'frete';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= '';
	$select_limit 	= 'LIMIT 1';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	$result = $consulta->fetch_array();
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small>/alterar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li class="active">
                    <?php echo $titulo; ?>
                </li>
	        </ol>
	    </div>
	</div>
    
    <div class="row">
		<div class="col-xs-12">
					
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
				<div class="row">
				    <div class="col-xs-12">
			        	<div class="form-group">
				        	<label>Valor mínimo em compras para Frete Grátis</label>
				            <input type="text" name="valor_minimo_frete_gratis" class="form-control moeda_real" value="<?php echo $valor = ($result['valor_minimo_frete_gratis'] > 0)?($result['valor_minimo_frete_gratis']):(NULL); ?>"/>
				            <p><small>*Deixe este campo vazio ou 0 (zero) para desabilitar o Frete Grátis</small></p>
				        </div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/> 
							<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>     
							<input type="hidden" name="acao" value="update"/>
							<input type="submit" value="Alterar"  class="btn btn-info"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>