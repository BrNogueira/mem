
<span data-active="noticias"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Dicas';
	
	$insert_table = $update_table = 'noticia_galeria';
	
	$id_principal = 'id_noticia';
	
	$select_fields	= 'noticia_galeria.*';			
	$select_table	= 'noticia_galeria';	
	$select_join	= 'INNER JOIN noticia ON noticia.id = noticia_galeria.id_noticia';			
	$select_where	= "WHERE noticia_galeria.id_noticia = $parametro";
	$select_group	= '';
	$select_order	= 'ORDER BY noticia_galeria.capa DESC, noticia_galeria.ordem DESC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);
		
	$select_fields2	= '*';			
	$select_table2	= 'noticia';	
	$select_join2	= '';			
	$select_where2	= "WHERE id = ".$parametro;
	$select_group2	= '';
	$select_order2	= '';
	$select_limit2	= '';
	$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2, $select_group2, $select_order2,
		$select_limit2);
		
	$result2 = $consulta2->fetch_array();
	
	$pagina_anterior = 'noticias';
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small> /galeria da dica "<?php echo $result2['nome']; ?>"</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                <a href="<?php echo $urlC.$pagina_anterior; ?>"><?php echo $titulo; ?></a>
	            </li>
	            <li class="active">
	                Galeria
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
				        	<label>Descrição</label>
				            <input type="text" name="nome" class="form-control"/>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Imagem</label>
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
			
			<?php if($consulta->num_rows > 0){ ?>
		    <button type="button" class="btn btn-warning btn-sm btn-reorder" data-table="<?php echo $update_table; ?>">
				<i class="fa fa-refresh fa-inverse"></i>&nbsp;&nbsp;Salvar ordem
			</button>
			<?php } ?>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable-reorder">
			        <thead>
			        	<th class="p5">Ordem</th>
						<th class="text-left nowrap">Descrição</th>
						<th class="p5">Visualizar</th>
						<th>Imagem</th>
						<th class="p5">Atualizar</th>
						<th class="p5">Capa</th>
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
									<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox">
										<figure class="bg-cover bg-thumb">
					                    	<img src="<?php echo $urlC.$result['arquivo']; ?>"/>
					                    </figure>
					                </a>
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
									<input type="hidden" name="field" value="<?php echo $id_principal; ?>"/>
									<input type="hidden" name="id_master" value="<?php echo $parametro; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="cover"/>
									<?php if($result['capa'] == 't'){ ?>
										<i class="fa fa-thumbs-up" style="color: #2063df;"></i>
									<?php }else{ ?>
										<button type="submit" class="fa fa-thumbs-down" style="color: #b54a4a;"></button>
									<?php } ?>
								</form>
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