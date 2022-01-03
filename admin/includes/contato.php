
<span data-active="contato"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Contato';
	
	$table = $update_table = 'contato';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= '';
	$select_limit	= 'LIMIT 1';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
		
	$result = $consulta->fetch_array();
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                Alterar
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
			        		<label>Texto</label> 
			        		<textarea class="form-control" rows="3" name="texto"><?php echo $result['texto']; ?></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>" required/> 
							<input type="hidden" name="id" value="<?php echo $result['id']; ?>" required/>     
							<input type="hidden" name="acao" value="update"/>
							<input type="submit" value="Alterar" class="btn btn-info"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>