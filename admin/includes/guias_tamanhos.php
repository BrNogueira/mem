
<span data-active="guias_tamanhos"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Guias de Tamanhos - Categorias';
	
	$insert_table = $update_table = 'guia_tamanho';
	
	$id_principal = 'id_categoria_guia_tamanho';
	
	$select_fields	= 'guia_tamanho.*';			
	$select_table	= 'guia_tamanho';	
	$select_join	= 'INNER JOIN categoria_guia_tamanho ON categoria_guia_tamanho.id = guia_tamanho.id_categoria_guia_tamanho';			
	$select_where	= "WHERE guia_tamanho.id_categoria_guia_tamanho = $parametro";
	$select_group	= '';
	$select_order	= 'ORDER BY guia_tamanho.nome';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);
		
	$select_fields2	= '*';			
	$select_table2	= 'categoria_guia_tamanho';	
	$select_join2	= '';			
	$select_where2	= "WHERE id = ".$parametro;
	$select_group2	= '';
	$select_order2	= '';
	$select_limit2	= '';
	$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2, $select_group2, $select_order2,
		$select_limit2);
		
	$result2 = $consulta2->fetch_array();
	
	$pagina_anterior = 'categorias_guias_tamanhos';
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small> / categoria "<?php echo $result2['nome']; ?>"</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                <a href="<?php echo $urlC.$pagina_anterior; ?>"><?php echo $titulo; ?></a>
	            </li>
	            <li class="active">
	                Modelos
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
				            <input type="text" name="nome" class="form-control"/>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Imagem da Guia de Tamanho</label>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo" required>
							</span>
						</div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
							<input type="hidden" name="tabela" value="<?php echo $insert_table; ?>"/>  
							<input type="hidden" name="<?php echo $id_principal; ?>" value="<?php echo $parametro; ?>"/>     
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
			
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
						<th class="text-left nowrap">Nome</th>
						<th class="p5">Visualizar</th>
						<th>Imagem</th>
						<th class="p5">Atualizar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>						
						<tr>
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
									<?php if(!empty($result['arquivo'])){ ?>
									<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox">
										<i class="fa fa-picture-o"></i>
									</a>
									<?php }else{ echo '-'; } ?>
								</td>
								<td class="text-center">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin">
								            <span class="btn btn-default btn-file btn-file-sm col-xs-12 no-padding">
												<input type="file" name="arquivo">
											</span>
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