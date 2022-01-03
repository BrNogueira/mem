
<span data-active="cupons"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Cupons de Desconto';
	
	$pagina_anterior = 'cupons';
	
	$table = $insert_table = 'cupom';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= '';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);	
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small>/cadastrar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>"><?php echo $titulo; ?></a>
                </li>
	            <li class="active">
	                Cadastrar
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
				            <input type="text" name="nome" class="form-control" required/>
				        </div>
						<div class="form-group">
				        	<label>Código</label>
				            <input type="text" name="codigo" class="form-control" required/>
				        </div>
				        <div class="form-group">
				        	<label>Tipo</label>
				            <select name="tipo" class="form-control" required>
								<option value="p">% - desconto em Porcentagem</option>
								<option value="r">R$ - desconto em Reais</option>
							</select>
				        </div>
				        <div class="form-group">
				        	<label>Valor do Desconto</label>
				            <input type="text" name="valor" class="form-control moeda_real" required/>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Data Início</label>
				            <input type="text" name="data_inicio" class="form-control data_completa" required/>
				        </div>
						<div class="form-group">
				        	<label>Data Fim</label>
				            <input type="text" name="data_fim" class="form-control data_completa" required/>
				        </div>
				        <div class="form-group">
				        	<label>Ativo</label>
				            <select name="ativo" class="form-control" required>
								<option value="t">Sim</option>
								<option value="f">Não</option>
							</select>
				        </div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="tabela" value="<?php echo $insert_table; ?>"/>      
							<input type="hidden" name="acao" value="insert"/>
							<input type="submit" value="Cadastrar"  class="btn btn-success"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{
	
	header("location:".$urlC."login");
} ?>