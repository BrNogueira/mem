
<span data-active="marcas"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo	= 'Marcas/Parceiros';
	
	$table = $update_table 	= 'marca';
	
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
			
			<?php if($consulta->num_rows > 0){ ?>
			&nbsp;
			<button type="button" class="btn btn-warning btn-sm btn-reorder" data-table="<?php echo $update_table; ?>">
				<i class="fa fa-refresh fa-inverse"></i>&nbsp;&nbsp;Salvar ordem
			</button>
			<?php } ?>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable-reorder">
			        <thead>
			            <th class="p5">Ordem</th>
			            <th class="text-left">Nome</th>
			            <th>Link</th>
			            <th class="p5">Imagem</th>
			            <th class="p5">Alterar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td data-reorder-id="<?php echo $result['id']; ?>"><?php echo $result['ordem']; ?></td>
							<td class="text-left"><?php echo $result['nome']; ?> </td>
							<td><?php echo $result['link']; ?> </td>
							<td>
								<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox">
									<i class="fa fa-picture-o"></i>
								</a>
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
<?php }else{

	header("location:".$urlC."login");
} ?>