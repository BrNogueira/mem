<?php if(isset($_SESSION['login']) && in_array($_SESSION['login']['id_nivel_acesso'], array(1,2))){

	$pagina_anterior = 'usuarios';
	
	$table = $update_table = 'admin';
	
	$select_fields	= 'DISTINCT log.id_admin, admin.*, log.*, nivel_acesso.*, admin.id AS id';			
	$select_table	= $table;	
	$select_join	= 'LEFT JOIN nivel_acesso ON nivel_acesso.id = admin.id_nivel_acesso LEFT JOIN log ON log.id_admin = admin.id';			
	$select_where	= 'WHERE admin.id ='.$parametro;
	$select_group	= 'GROUP BY log.id_admin';
	$select_order	= 'ORDER BY nome ASC';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);	

	$result = $consulta->fetch_array();
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            Usuários <small>/alterar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>">Usuários</a>
                </li>
	            <li class="active">
	                Alterar Usuário
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
			
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome</label>
				            <input type="text" name="nome" value="<?php echo $result['nome']; ?>" class="form-control" required/>
				        </div>
						<div class="form-group">
				        	<label>E-mail</label>
				            <input type="text" name="email" value="<?php echo $result['email']; ?>" class="form-control"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Login</label>
				            <input type="text" name="login" value="<?php echo $result['login']; ?>" class="form-control" required/>
				        </div>
				        <div class="form-group">
				        	<label>Senha</label>
				            <input type="password" name="senha" class="form-control"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Permissão</label>
							<select name="id_nivel_acesso" class="form-control" required>
								<option value="<?php echo $result['id_nivel_acesso']; ?>">
									<?php echo $result['permissao']; ?>
	                            </option>
	                           <?php
								$select_fields2	= '*';			
								$select_table2	= 'nivel_acesso';	
								$select_join2	= '';			
								$select_where2	= "WHERE id != ".$result['id_nivel_acesso'];
								$select_group2	= '';
								$select_order2	= '';
								$select_limit2 	= '';
								$consulta2 = $select->selectDefault($select_fields2, $select_table2, $select_join2, $select_where2,
									$select_group2, $select_order2, $select_limit2);
							   
							   	while($result2 = $consulta2->fetch_array()){ ?>
						        	<?php if(!($result2['id'] == 1 && $_SESSION['login']['id_nivel_acesso'] == 2)){ ?>
		                                <option value="<?php echo $result2['id']; ?>">
											<?php echo $result2['permissao']; ?>
		                                </option>
								 	<?php } ?>
							 	<?php } ?>
							</select>	
				        </div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/> 
							<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>     
							<input type="hidden" name="acao" value="update"/>
							<input type="submit" value="Alterar" class="btn btn-info"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>