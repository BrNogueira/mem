
<span data-active="cupons"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Cupons de Desconto';
	
	$pagina_anterior = 'cupons';
	
	$table = $update_table = 'cupom';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= 'WHERE id = '.$parametro;
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
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>"><?php echo $titulo; ?></a>
                </li>
	            <li class="active">
	                Alterar
	            </li>
	        </ol>
	    </div>
	</div>
    <div class="row">
		<div class="col-xs-12">
			
			<a href="<?php echo $urlC.$pagina_anterior; ?>"> 
				<button class="btn btn-xs btn-default"> <i class="icon-hand-left"></i>voltar</button> 
			</a>
			
			<br/><br/>
			
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome</label>
				            <input type="text" name="nome" class="form-control" value="<?php echo $result['nome']; ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>Código</label>
				            <input type="text" name="codigo" class="form-control" value="<?php echo $result['codigo']; ?>" required/>
				        </div>
				        <div class="form-group">
				        	<label>Tipo</label>
				            <select name="tipo" class="form-control" required>
								<option value="p" <?php echo $selected = ($result['tipo'] == 'p')?('selected'):(NULL); ?>>% - desconto em Porcentagem</option>
								<option value="r"<?php echo $selected = ($result['tipo'] == 'r')?('selected'):(NULL); ?>>R$ - desconto em Reais</option>
							</select>
				        </div>
				        <div class="form-group">
				        	<label>Valor do Desconto</label>
				            <input type="text" name="valor" class="form-control moeda_real" value="<?php echo number_format($result['valor'], 2, '.', ''); ?>" required/>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Data Início</label>
				            <input type="text" name="data_inicio" class="form-control data_completa" value="<?php echo Util::fixData($result['data_inicio']); ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>Data Fim</label>
				            <input type="text" name="data_fim" class="form-control data_completa" value="<?php echo Util::fixData($result['data_fim']); ?>" required/>
				        </div>
				        <div class="form-group">
				        	<label>Ativo</label>
				            <select name="ativo" class="form-control" required>
								<option value="t" <?php echo $selected = ($result['ativo'] == 't')?('selected'):(NULL); ?>>Sim</option>
								<option value="f" <?php echo $selected = ($result['ativo'] == 'f')?('selected'):(NULL); ?>>Não</option>
							</select>
				        </div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
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