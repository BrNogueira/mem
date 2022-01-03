
<span data-active="clientes"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo	= 'Clientes';
	
	$table = $update_table 	= 'usuario';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= 'ORDER BY nome';
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
			            <th class="text-left">Nome</th>
			            <th>CEP</th>
			            <th>E-mail</th>
			            <th>Telefone</th>
			            <th>Data Cadastro</th>
			            <th class="p5">Cadastro Completo</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo $result['nome'].' '.$result['sobrenome']; ?> </td>
							<td><?php echo $result['cep']; ?> </td>
							<td><?php echo $result['email']; ?> </td>
							<td><?php echo $result['telefone_contato']; ?> </td>
							<td><?php echo Util::fixDataHora($result['data_hora']); ?> </td>
							<td>
								<a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-cadastro-'.$result['id']; ?>" href="#">
									<i class="fa fa-vcard-o"></i>
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
	<div id="<?php echo 'modal-cadastro-'.$result['id']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<h4 class="modal-title h2-titulo-section">Cadastro Completo</h4>
				</div>
				<div class="modal-body">
					<div class="row">                            
						<div class="col-xs-12">
							<p><b>Nome: </b><?php echo ucwords(strtolower($result['nome'].' '.$result['sobrenome'])); ?></p>
			        		<p><b>E-mail: </b><?php echo $result['email']; ?></p>
			        		<p><b>CPF: </b><?php echo $result['cpf']; ?></p>
			        		<p><b>Data de Nascimento: </b><?php echo Util::fixData($result['nascimento']); ?></p>
			        		<p><b>CEP: </b><?php echo $result['cep']; ?></p>
			        		<?php $complemento = (!empty($result['complemento']))?(' - '.$result['complemento']):(NULL); ?>
			        		<p><b>Endereço: </b><?php echo $result['endereco'].', Nº: '.$result['numero'].$complemento; ?></p>
			        		<p><b>Bairro: </b><?php echo $result['bairro']; ?></p>
			        		<p><b>Cidade: </b><?php echo $result['cidade']; ?></p>
			        		<p><b>UF: </b><?php echo $result['uf']; ?></p>
			        		<p><b>Telefone Contato: </b><?php echo $result['telefone_contato']; ?></p>
			        		<p><b>Telefone Celular:</b><?php echo $result['telefone_celular']; ?></p>
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