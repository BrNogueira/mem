
<span data-active="oferta"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Banners Oferta - Médio';
	
	$pagina_anterior = 'banners_oferta_medio';
	
	$table = $update_table = 'banner_oferta_medio';
	
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
				        	<label>Título</label>
				            <input type="text" name="nome" value="<?php echo $result['nome']; ?>" class="form-control"/>
				        </div>
						<div class="form-group">
				        	<label>Link</label>
				            <input type="text" name="link" value="<?php echo $result['link']; ?>" class="form-control"/>
				        </div>
			        </div>			        
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Data Início</label>
				            <input type="text" name="data_inicio" class="form-control data_completa" value="<?php echo (empty($result['data_inicio']) or $result['data_inicio'] == '0000-00-00')?(NULL):(Util::fixData($result['data_inicio'])); ?>"/>
				        </div>
						<div class="form-group">
				        	<label>Data Fim</label>
				            <input type="text" name="data_fim" class="form-control data_completa" value="<?php echo (empty($result['data_fim']) or $result['data_fim'] == '0000-00-00')?(NULL):(Util::fixData($result['data_fim'])); ?>"/>
				        </div>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Imagem <small>[ Dimensões: 400x500px ]</small></label>
							<?php if(!empty($result['arquivo'])){ ?>
							<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
							<?php } ?>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo">
							</span>
						</div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Ativo</label>
				            <select name="ativo" class="form-control" required>
								<option value="t" <?php echo ($result['ativo'] == 't')?('selected'):(NULL); ?>>Sim</option>
								<option value="f" <?php echo ($result['ativo'] == 'f')?('selected'):(NULL); ?>>Não</option>
							</select>
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