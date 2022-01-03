<?php if(isset($_SESSION['login']) && in_array($_SESSION['login']['id_nivel_acesso'], array(1,2))){
	
	$titulo = 'Usuários';
	
	$select_fields	= 'DISTINCT admin.id, admin.*, admin.id as id_usuario, nivel_acesso.*, MAX(log.data_hora) AS data_hora';			
	$select_table	= 'admin';	
	$select_join	= 'LEFT JOIN nivel_acesso ON nivel_acesso.id = admin.id_nivel_acesso
						LEFT JOIN log ON log.id_admin = admin.id';			
	$select_where	= ($_SESSION['login']['id'] == 1)?(NULL):('WHERE admin.id != 1');
	$select_group	= 'GROUP BY admin.id';
	$select_order	= 'ORDER BY nome ASC';
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
	
	<div class="row">
		<div class="col-xs-12">
		
		    <a href="<?php echo $urlC.$pagina.'_cadastrar'; ?>"> 
				<button class="btn btn-sm btn-primary">Cadastrar</button> 
			</a>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
			            <th class="text-left">Nome</th>
			            <th>Login</th>
			            <th>E-mail</th>
			            <th>Permissão</th>
			            <th>Último Login</th>
			            <th class="p5">Alterar</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<?php if(!($result['id_nivel_acesso'] == 1 && $_SESSION['login']['id_nivel_acesso'] == 2)){ ?>
							<tr>
								<td class="text-left"><?php echo $result['nome']; ?> </td>
								<td><?php echo $result['login']; ?> </td>
								<td><?php echo $result['email']; ?> </td>
								<td><?php echo $result['permissao']; ?> </td>
								<td><?php echo $data_hora = ($result['data_hora'] > 0)?($result['data_hora']):('-'); ?> </td>
								<td>
					                <a href="<?php echo $urlC.$pagina.'_alterar/'.$result['id_usuario']; ?>"> 
					                    <i class="fa fa-edit"></i>
					                </a>
					            </td>									
								<td>
									<form method="post" action="<?php echo $urlC.'acao'; ?>">
										<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
										<input type="hidden" name="id" value="<?php echo $result['id_usuario']; ?>"/>
										<input type="hidden" name="acao" value="delete"/>
										<button type="button" class="fa fa-trash" data-toggle="confirmation"></button>
									</form>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
<?php }else{

	$_SESSION['aviso']['alerta'] = "
			<div class='alert alert-error'>
				<button type='button' class='close fade in' data-dismiss='alert'>&times;</button>
				Você não tem permissão!	</div>";
		
	header("location:".$urlC."home");
} ?>