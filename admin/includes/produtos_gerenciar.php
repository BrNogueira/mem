
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Estoque';
	
	$id_principal = 'id_produto';
	
	$table = $insert_table = $update_table = 'rel_produto_var';
		
	$select_fields	= "rel_produto_var.*, cor.codigo AS codigo, cor.nome AS cor, tamanho.nome AS tamanho";			
	$select_table	= "rel_produto_var";	
	$select_join	= "LEFT JOIN tamanho ON tamanho.id = rel_produto_var.id_tamanho
						LEFT JOIN cor ON cor.id = rel_produto_var.id_cor";
	$select_where	= "WHERE rel_produto_var.id_produto = $parametro";
	$select_group	= "";
	$select_order	= "ORDER BY cor.nome, tamanho.nome";
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	
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
	            <?php echo $titulo; ?> <small> /estoque do produto "<?php echo $result2['nome']; ?>"</small>
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
                <li class="active">
	                <a href="<?php echo $urlC.$pagina_anterior; ?>">Produtos</a>
	            </li>
	            <li class="active">
	                <?php echo $titulo; ?>
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
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label>Cor:</label>
				            <select name="id_cor" class="form-control chosen-select" data-placeholder="...selecione" required>
								<option value="0">Nenhuma</option>
								<?php
								$query0 = $conn->query("SELECT cor.* 
								FROM cor 
								INNER JOIN produto_galeria ON produto_galeria.id_cor = cor.id
								WHERE produto_galeria.id_produto = {$parametro} AND cor.id != 0
								GROUP BY cor.id
								ORDER BY cor.nome");
								?>
								<?php while($result0 = $query0->fetch_array()){ ?>
									<option value="<?php echo $result0['id']; ?>"><?php echo $result0['nome']; ?></option>
								<?php } ?>
							</select>
				        </div>
			        </div>
					<div class="col-xs-12 col-md-6">
				        <div class="form-group">
							<label>Tamanho:</label>
				            <select name="id_tamanho" class="form-control chosen-select" required>
								<option value="0">Nenhum</option>
								<?php $query0 = $conn->query("SELECT * FROM tamanho WHERE id != 0 ORDER BY ordem DESC"); ?>
								<?php while($result0 = $query0->fetch_array()){ ?>
									<option value="<?php echo $result0['id']; ?>"><?php echo $result0['nome']; ?></option>
								<?php } ?>
							</select>
				        </div>
			        </div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label>Peso*</label>
				            <input type="text" name="peso" class="form-control peso" required/>
				        </div>
				    </div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label>Valor*</label>
				            <input type="text" name="valor" class="form-control moeda_real" required/>
				        </div>
				    </div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label>Estoque:</label>
				            <input type="number" name="estoque" class="form-control" value="0" required/>
				        </div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="<?php echo $id_principal; ?>" value="<?php echo $parametro; ?>"/>
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
			
			<span>
				<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Não esqueça de cadastrar a <a href="<?php echo $urlC.'produtos_galeria/'.$parametro; ?>" class="btn btn-purple btn-sm">galeria de cores</a> deste produto antes do seu estoque.
			</span>
			
			<div class="clearfix"></div>
			<br/>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
						<th class="text-left">Cor</th>
						<th>Tamanho</th>
						<th class="text-left">Peso</th>
						<th class="text-left">Valor</th>
						<th class="p5">Estoque</th>
						<th class="p5">Atualizar</th>
						<th class="p5">Remover</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo $result['cor']; ?></td>
							<td><?php echo $result['tamanho']; ?></td>
							<form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
								<td class="text-left">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin display-block">
								        	<div class="input-group col-xs-12">
									            <input type="text" name="peso" class="form-control input-sm peso" value="<?php echo $result['peso']; ?>" required/>
									            <span class="display-none"><?php echo $result['peso']; ?></span>
											</div>
								        </div>
									</div>
								</td>
								<td class="text-left">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin display-block">
								        	<div class="input-group col-xs-12">
									            <input type="text" name="valor" class="form-control input-sm moeda_real" value="<?php echo number_format($result['valor'],2,'.',''); ?>" required/>
									            <span class="display-none"><?php echo 'R$&nbsp;'.Util::fixValor($result['valor']); ?></span>
											</div>
								        </div>
									</div>
								</td>
								<td class="text-left">
									<div class="col-xs-12 no-padding">
										<div class="form-group no-margin display-block">
								        	<div class="input-group col-xs-12">
									            <input type="text" name="estoque" class="form-control input-sm" value="<?php echo $result['estoque']; ?>" required/>
									            <span class="display-none"><?php echo $result['estoque']; ?></span>
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
									<button type="button" class="fa fa-eraser confirm" data-title="Deseja realmente remover?"></button>
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