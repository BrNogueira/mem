
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Galeria';
	
	$table = $insert_table = $update_table = 'produto_galeria';
	
	$id_principal = 'id_produto';
	
	$select_fields	= 'produto_galeria.*, cor.nome AS cor';			
	$select_table	= $table;	
	$select_join	= 'INNER JOIN produto ON produto.id = produto_galeria.id_produto
						INNER JOIN cor ON cor.id = produto_galeria.id_cor';			
	$select_where	= "WHERE produto_galeria.id_produto = $parametro";
	$select_group	= '';
	$select_order	= 'ORDER BY produto_galeria.capa DESC, produto_galeria.ordem DESC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);
		
	$select_fields2	= '*';			
	$select_table2	= 'produto';	
	$select_join2	= '';			
	$select_where2	= "WHERE id = ".$parametro;
	$select_group2	= '';
	$select_order2	= '';
	$select_limit2	= '';
	$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2, $select_group2, $select_order2,
		$select_limit2);
	$result2 = $consulta2->fetch_array();
	
	$query0 = $conn->query("SELECT * FROM subcategoria WHERE id = {$result2['id_subcategoria']}");
	$result0 = $query0->fetch_array();
	
	$query0b = $conn->query("SELECT * FROM categoria WHERE id = {$result0['id_categoria']}");
	$result0b = $query0b->fetch_array();
	
	$pagina_anterior = 'produtos/'.$result2['id_subcategoria'];
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small> /galeria do produto "<?php echo $result2['nome']; ?>"</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo $urlC.'categorias'; ?>">Categorias</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.'subcategorias/'.$result0['id_categoria']; ?>">Subcategorias</a>
                </li>
	            <li>
	                <a href="<?php echo $urlC.$pagina_anterior; ?>">Produtos</a>
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
				        	<label>Cor</label>
				            <select name="id_cor" class="form-control chosen-select" required>
								<option value="">...selecione</option>
								<option value="0">Nenhuma</option>
								<?php $queryX = $conn->query("SELECT * FROM cor WHERE id != 0 ORDER BY nome"); ?>
								<?php while($resultX = $queryX->fetch_array()){ ?>
									<option value="<?php echo $resultX['id']; ?>"><?php echo $resultX['nome']; ?></option>
								<?php } ?>
							</select>
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
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Posição <small>(posição da imagem dentro da área de visualização)</small></label>
				            <select name="posicao" class="form-control chosen-select" required>
								<option value="">...selecione</option>
								<option value="c">Centralizada (imagem não ultrapassa a área delimitada)</option>
								<option value="e">Estendida (imagem ocupa toda a área delimitada ocultando o que ultrapassar)</option>
							</select>
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
			
			<span class="pull-right">				
				<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Não esqueça de cadastrar o <a href="<?php echo $urlC.'produtos_gerenciar/'.$parametro; ?>" class="btn btn-purple btn-sm">estoque</a> deste produto após cadastrar a galeria de cores.
			</span>
			
			<div class="clearfix"></div>
			<br/>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable-reorder">
			        <thead>
			        	<th class="p5">Ordem</th>
						<th class="text-left nowrap">Cor</th>
						<th class="p5">Visualizar</th>
						<th>Imagem</th>
						<th class="p5">Atualizar</th>
						<th class="p5">Posição</th>
						<th class="p5">Capa</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td data-reorder-id="<?php echo $result['id']; ?>"><?php echo $result['ordem']; ?></td>
							<td class="text-left">
								<?php echo $result['cor']; ?>
							</td>
							<form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
								<td class="text-center">
									<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox">
										<figure class="<?php echo ($result['posicao'] == 'c')?('bg-contain'):('bg-cover'); ?> bg-thumb bg-thumb-gallery">
					                    	<img src="<?php echo $urlC.$result['arquivo']; ?>"/>
					                    </figure>
					                </a>
								</td>
								<td class="text-center">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin">
								            <div class="file-input btn btn-default">
											    <span><i class="fa fa-folder-open"></i>&nbsp;Arquivo</span>
											    <input type="file" class="upload-input" name="arquivo" required/>
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
								<div class="input-group">
				                    <div class="input-group-btn">
				                        <form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
											<input type="hidden" name="posicao" value="c"/>
											<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
											<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
											<input type="hidden" name="acao" value="update"/>
											<button type="submit" class="btn <?php echo ($result['posicao'] == 'c')?('btn-warning'):('btn-default'); ?>"><small>Centralizada</small></button>
										</form>
				                    </div>
				                    <div class="input-group-btn">
				                        <form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
											<input type="hidden" name="posicao" value="e"/>
											<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
											<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
											<input type="hidden" name="acao" value="update"/>
											<button type="submit" class="btn <?php echo ($result['posicao'] == 'e')?('btn-warning'):('btn-default'); ?>"><small>Estendida</small></button>
										</form>
				                    </div>
		               			</div>
							</td>
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