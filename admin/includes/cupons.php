
<span data-active="cupons"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo	= 'Cupons de Desconto';
	
	$table = $update_table 	= 'cupom';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= "";
	$select_group	= '';
	$select_order	= 'ORDER BY data_inicio DESC';
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
			            <th class="text-left">Nome</th>
						<th>Código</th>
						<th>Valor</th>
						<th>Data Início</th>
						<th>Data Fim</th>
						<th class="p5">Ativo</th>
						<th class="p5">Alterar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo $result['nome']; ?> </td>
							<td><?php echo $result['codigo']; ?> </td>
							<td><?php echo $valor = ($result['tipo'] == 'p')?($result['valor'].'%'):('R$ '.Util::fixValor($result['valor'])); ?> </td>
							<td><?php echo Util::fixData($result['data_inicio']); ?> </td>
							<td><?php echo Util::fixData($result['data_fim']); ?> </td>
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
<?php }else{

	header("location:".$urlC."login");
} ?>