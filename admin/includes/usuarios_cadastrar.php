<?php if(isset($_SESSION['login']) && in_array($_SESSION['login']['id_nivel_acesso'], array(1,2))){
	
	$pagina_anterior = 'usuarios';
	
	$table = $insert_table = 'admin';
	
	$select_fields	= '*';			
	$select_table	= $table;	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= '';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
		$select_limit);	
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            Usuários <small>/cadastrar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>">Usuários</a>
                </li>
	            <li class="active">
	                Cadastrar Usuário
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
				            <input type="text" name="nome" class="form-control"/>
				        </div>
						<div class="form-group">
				        	<label>E-mail</label>
				            <input type="text" name="email" class="form-control"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Login</label>
				            <input type="text" name="login" class="form-control"/>
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
								<option value="">...selecione</option>
		                       	<?php $query2 = $conn->query("SELECT * FROM nivel_acesso"); ?>
		                       	<?php while($result2 = $query2->fetch_array()){ ?>
		                       		<?php if(!($result2['id'] == 1 && $_SESSION['login']['id_nivel_acesso'] == 2)){ ?>
			                            <option value="<?php echo $result2['id']; ?>">
											<?php echo $result2['permissao']; ?>
			                            </option>
							 		<?php }?>
							 	<?php }?>
							</select>
				        </div>
				    </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="tabela" value="<?php echo $insert_table; ?>"/>      
							<input type="hidden" name="acao" value="insert"/>
							<input type="submit" value="Cadastrar"  class="btn btn-success"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{
	
	header("location:".$urlC."login");
} ?>