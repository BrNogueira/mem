
<span data-active="oferta"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo	= 'Banners Oferta - Grande';
	
	$table = $update_table 	= 'banner_oferta_grande';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= 'ORDER BY ordem DESC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);	
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
	                <?php echo $titulo; ?>
	            </li>
	        </ol>
	    </div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		
		    <a href="<?php echo $urlC.$pagina.'_cadastrar'; ?>"> 
				<button class="btn btn-sm btn-primary">Cadastrar</button> 
			</a>
						
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
			            <th class="text-left">Título</th>
			            <th>Link</th>
			            <th>Data Início</th>
			            <th>Data Fim</th>
			            <th class="p5">Imagem</th>
			            <th class="p5">Texto</th>
			            <th class="p5">Ativo</th>
			            <th class="p5">Alterar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo $result['nome']; ?> </td>
							<td><?php echo $result['link']; ?> </td>
							<td><?php echo (empty($result['data_inicio']) or $result['data_inicio'] == '0000-00-00')?('-'):(Util::fixData($result['data_inicio'])); ?> </td>
							<td><?php echo (empty($result['data_fim']) or $result['data_fim'] == '0000-00-00')?('-'):(Util::fixData($result['data_fim'])); ?> </td>
							<td>
								<?php if(!empty($result['arquivo'])){ ?>
								<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox">
									<i class="fa fa-picture-o"></i>
								</a>
								<?php }else{ echo '-'; } ?>
							</td>
							<td>
								<?php if(!empty($result['texto'])){ ?>
								<a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-texto-'.$result['id']; ?>" href="#">
									<i class="fa fa-list-alt"></i>
								</a>
								<?php }else{ echo '-'; } ?>
							</td>
							<td>
								<?php if($result['ativo'] == 't'){ ?>
								<form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
									<input type="hidden" name="ativo" value="f"/>
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="update"/>
									<button type="submit" class="fa fa-toggle-on" style="color: #508b47;"></button>
								</form>
								<?php }else{ ?>
								<form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
									<input type="hidden" name="ativo" value="t"/>
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="update"/>
									<button type="submit" class="fa fa-toggle-on fa-flip-horizontal" style="color: #9d4444;"></button>
								</form>
								<?php } ?>
							</td>
							<td>
				                <a href="<?php echo $urlC.$pagina.'_alterar/'.$result['id']; ?>"> 
				                    <i class="fa fa-edit"></i>
				                </a>
				            </td>									
							<td>
								<form method="post" action="<?php echo $urlC.'acao'; ?>">
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="delete"/>
									<button type="button" class="fa fa-trash confirm" data-title="Deseja realmente excluir?"></button>
								</form>
							</td>
						</tr>
					<?php } ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
	<?php $consulta->data_seek(0); ?>
	<?php while($result = $consulta->fetch_array()){ ?>
	<div id="<?php echo 'modal-texto-'.$result['id']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<h4 class="modal-title h2-titulo-section">Texto</h4>
				</div>
				<div class="modal-body">
					<div class="row">                            
						<div class="col-xs-12">
							<p><?php echo $result['texto']; ?></p>
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