
<span data-active="marcas"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Marcas/Parceiros';
	
	$pagina_anterior = 'marcas';
	
	$table = $update_table = 'marca';
	
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
				            <input type="text" name="nome" value="<?php echo $result['nome']; ?>" class="form-control"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Link</label>
				            <input type="text" name="link" value="<?php echo $result['link']; ?>" class="form-control"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Imagem <small>[ Formato: de preferência PNG com fundo transparente | Dimensões: 400x300px ]</small></label>
							<?php if(!empty($result['arquivo'])){ ?>
							<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
							<?php } ?>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo">
							</span>
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