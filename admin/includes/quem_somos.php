
<span data-active="quem_somos"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Quem Somos - Texto principal';
	
	$table = $update_table = 'quem_somos';
	
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
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Título</label>
				            <input type="text" name="nome" value="<?php echo $result['nome']; ?>" class="form-control"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Imagem <small>[ Dimensões: 800x600px ]</small></label>
							<?php if(!empty($result['arquivo'])){ ?>
							<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
							<?php } ?>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo">
							</span>
						</div>
				    </div>
				    <div class="clearfix"></div>
			        <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Texto principal</label> 
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