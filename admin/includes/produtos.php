
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Produtos';
	
	$table = $update_table = 'produto';
	
	$select_fields	= "produto.*, categoria.nome AS categoria, subcategoria.nome AS subcategoria, secao.nome AS secao";
	$select_table	= $table;	
	$select_join	= "INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
						INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
						LEFT JOIN secao ON secao.id = produto.id_secao";
	$select_where	= "WHERE produto.id_subcategoria = {$parametro}";
	$select_group	= "";
	$select_order	= "ORDER BY produto.ordem DESC";
	$select_limit 	= "";
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	
	$query0 = $conn->query("SELECT * FROM subcategoria WHERE id = {$parametro}");
	$result0 = $query0->fetch_array();
	
	$query0b = $conn->query("SELECT * FROM categoria WHERE id = {$result0['id_categoria']}");
	$result0b = $query0b->fetch_array();
	
	$pagina_anterior = 'subcategorias/'.$result0['id_categoria'];
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small>/categoria: "<?php echo $result0b['nome']; ?>" /subcategoria: "<?php echo $result0['nome']; ?>"</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.'categorias'; ?>">Categorias</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>">Subcategorias</a>
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
			
			<br/><br/>
			
			<a href="<?php echo $urlC.$pagina.'_cadastrar/'.$parametro; ?>"> 
				<button class="btn btn-sm btn-primary">Cadastrar</button> 
			</a>
			
			<?php if($consulta->num_rows > 0){ ?>
			&nbsp;
			<button type="button" class="btn btn-warning btn-sm btn-reorder" data-table="<?php echo $update_table; ?>">
				<i class="fa fa-refresh fa-inverse"></i>&nbsp;&nbsp;Salvar ordem
			</button>
			<?php } ?>
			
			<div class="col-xs-12 table-responsive">
			    <table class="table table-striped datatable-reorder">
			        <thead>
			            <th class="p5">Ordem</th>
			            <th class="text-left">Nome</th>
						<th>Referência</th>
						<th>Seções</th>
						<th class="p5">Destaque</th>
						<th class="p5">Ativo</th>
						<th class="p5">Galeria / Cores</th>
						<th class="p5">ESTOQUE</th>
						<th class="p5">Alterar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td data-reorder-id="<?php echo $result['id']; ?>"><?php echo $result['ordem']; ?></td>
							<td class="text-left text-nowrap"><?php echo $result['nome']; ?></td>
							<td><?php echo $result['referencia']; ?></td>
							<td>
								<?php
								$secoes = explode(',', $result['secoes']);
								$secoes_array = array();
								foreach($secoes as $secao){
									
									$queryM = $conn->query("SELECT * FROM secao WHERE id = {$secao}");
									
									if($queryM->num_rows > 0){
										
										$resultM = $queryM->fetch_array();
										
										$secoes_array[] = $resultM['nome'];
									}
								}
								
								echo implode(' / ',$secoes_array);
								?>
							</td>
							<td>
								<?php if($result['destaque'] == 't'){ ?>
								<form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
									<input type="hidden" name="destaque" value="f"/>
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="update"/>
									<button type="submit" class="fa fa-toggle-on" style="color: #508b47;"></button>
								</form>
								<?php }else{ ?>
								<form method="post" action="<?php echo $urlC.'acao'; ?>" style="display: inline;">
									<input type="hidden" name="destaque" value="t"/>
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="update"/>
									<button type="submit" class="fa fa-toggle-on fa-flip-horizontal" style="color: #9d4444;"></button>
								</form>
								<?php } ?>
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
								<?php $queryX = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']}"); ?>
				                <a href="<?php echo $urlC.$pagina.'_galeria/'.$result['id']; ?>"> 
				                    <i class="fa fa-camera" <?php echo ($queryX->num_rows == 0)?('style="color: #bf4040;"'):('style="color: #425ebd;"'); ?>></i>
				                </a>
				            </td>
							<td>
								<?php $queryX = $conn->query("SELECT * FROM rel_produto_var WHERE id_produto = {$result['id']}"); ?>
				                <a href="<?php echo $urlC.$pagina.'_gerenciar/'.$result['id']; ?>"> 
				                    <i class="fa fa-cubes" <?php echo ($queryX->num_rows == 0)?('style="color: #bf4040;"'):('style="color: #425ebd;"'); ?>></i>
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