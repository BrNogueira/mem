
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Seções de Produtos';
	
	$table = $insert_table = $update_table = 'secao';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= "";
	$select_group	= '';
	$select_order	= 'ORDER BY ordem DESC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);
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
	
	<br/>
	
	<div class="row">
		<div class="col-xs-12">
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome</label>
				            <input type="text" name="nome" class="form-control"/>
				        </div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
							<input type="hidden" name="tabela" value="<?php echo $insert_table; ?>"/>
							<input type="hidden" name="acao" value="insert"/>
							<input type="submit" value="Cadastrar"  class="btn btn-sm btn-success"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			
			<hr />
			
			<?php if($consulta->num_rows > 0){ ?>
		    <button type="button" class="btn btn-warning btn-sm btn-reorder" data-table="<?php echo $update_table; ?>">
				<i class="fa fa-refresh fa-inverse"></i>&nbsp;&nbsp;Salvar ordem
			</button>
			<?php } ?>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable-reorder">
			        <thead>
			        	<th class="p5">Ordem</th>
						<th class="text-left nowrap">Nome</th>
						<th class="p5">Atualizar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td data-reorder-id="<?php echo $result['id']; ?>"><?php echo $result['ordem']; ?></td>
							<form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
								<td class="text-left">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin display-block">
								        	<div class="input-group col-xs-12">
									            <input type="text" name="nome" class="form-control input-sm" value="<?php echo $result['nome']; ?>"/>
									            <span class="display-none"><?php echo $result['nome']; ?></span>
											</div>
								        </div>
									</div>
								</td>
								<td class="text-center">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin">
								        	<div class="input-group margin-auto">
												<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
												<input type="hidden" name="ordem" value=""/>
												<!---->
												<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/>  
												<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>  
												<input type="hidden" name="acao" value="update"/>
												<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-refresh"></i></button>
											</div>
								        </div>
									</div>
								</td>							
							</form>
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