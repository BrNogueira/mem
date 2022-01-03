
<span data-active="noticias"></span>

<?php if(isset($_SESSION['login'])){
		
	$titulo = 'Dicas';
	
	$table = $update_table = 'noticia';
	
	$select_fields	= "*";			
	$select_table	= $table;	
	$select_join	= "";
	$select_where	= "WHERE id = $parametro";
	$select_group	= "";
	$select_order	= "";
	$select_limit 	= "";
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	$result = $consulta->fetch_array();
	
	$pagina_anterior = 'noticias';
	?>
    
    <div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small> /alterar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
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
		</div>
	</div>
	
	<br/>
	
	<div class="row">
	   	<div class="col-xs-12">	   	
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
		    	<div class="row">
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome</label>
				            <input type="text" name="nome" class="form-control" value="<?php echo $result['nome']; ?>"/>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Data</label>
				            <input type="text" name="data" class="form-control data_completa" value="<?php echo Util::fixData($result['data']); ?>" required/>
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
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Vídeo <small>(URL do vídeo no Youtube)</small></label>
							<?php if(!empty($result['video'])){ ?>
							<a href="javascript:void(0)" data-toggle="modal" data-target="<?php echo '#modal-video-'.$result['id']; ?>" class="btn btn-default" data-video="<?php echo 'https://www.youtube.com/embed/'.$result['video']; ?>"><i class="fa fa-youtube-play"></i></a>
							<?php } ?>
							<input type="text" name="video" class="form-control ti40" value="<?php echo (!empty($result['video']))?('https://www.youtube.com/watch?v='.$result['video']):(NULL); ?>"/>
						</div>
				    </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Texto</label> 
			        		<textarea class="form-control" rows="3" name="texto"><?php echo $result['texto']; ?></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
				        	<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/>      
							<input type="hidden" name="acao" value="update"/>
							<input type="submit" value="Alterar"  class="btn btn-info"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php if(!empty($result['video'])){ ?>
		<div id="<?php echo 'modal-video-'.$result['id']; ?>" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">								
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title h2-titulo-section">Vídeo</h4>
					</div>
					<div class="modal-body">
						<div class="row">                            
							<div class="col-xs-12">
								<div class="area-video"></div>
							</div>                            
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php }else{

	header("location:".$urlC."login");
} ?>