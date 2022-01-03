
<span data-active="avise"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo	= 'Avise-me';
	
	$table = $update_table 	= 'avise';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= 'ORDER BY data_hora DESC';
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
		
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
						<th class="text-left">Data</th>
			            <th class="text-left">Nome</th>
						<th>E-mail</th>
						<th>Produto</th>
						<th class="p5">Detalhes</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo Util::fixDataHora($result['data_hora']); ?></td>	
							<td class="text-left"><?php echo $result['nome']; ?></td>							
							<td><?php echo $result['email']; ?></td>					
							<td><?php echo $result['produto']; ?></td>					
							<td>
								<a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-texto-'.$result['id']; ?>" href="#">
									<i class="fa fa-list-alt"></i>
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
					<h4 class="modal-title h2-titulo-section">Detalhes</h4>
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