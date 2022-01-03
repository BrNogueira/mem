<?php if(isset($_SESSION['login']) && $_SESSION['login']['id'] == 1){
		
	$update_table 	= 'configuracao';
	
	$select_fields	= '*';			
	$select_table	= 'configuracao';	
	$select_join	= '';			
	$select_where	= "";
	$select_group	= '';
	$select_order	= '';
	$select_limit 	= 'LIMIT 1';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	$result = $consulta->fetch_array();
	?>
    
    <div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            Configurações
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                Configurações
	            </li>
	        </ol>
	    </div>
	</div>
	
    <div class="row">
		<div class="col-xs-12">
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
    			<div class="row">
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>CEP Remetente</label>
				            <input type="text" name="cep_remetente" class="form-control cep-mask" value="<?php echo $result['cep_remetente']; ?>" required/>
				        </div>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Pagseguro - Ambiente</label>
				            <select name="pagseguro_ambiente" class="form-control" required>
								<option value="p" <?php echo $selected = ($result['pagseguro_ambiente'] == 'p')?('selected'):(NULL); ?>>Produção</option>
								<option value="s" <?php echo $selected = ($result['pagseguro_ambiente'] == 's')?('selected'):(NULL); ?>>Sandbox</option>
							</select>
				        </div>
						<div class="form-group">
				        	<label>Pagseguro - E-mail</label>
				            <input type="text" name="pagseguro_email" class="form-control" value="<?php echo $result['pagseguro_email']; ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>Pagseguro - Token</label>
				            <input type="text" name="pagseguro_token" class="form-control" value="<?php echo $result['pagseguro_token']; ?>" required/>
				        </div>
				        <div class="form-group">
				        	<label>E-mail de Autenticação (PHP Mailer)</label>
				            <input type="text" name="mailer_email" class="form-control" value="<?php echo $result['mailer_email']; ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>Senha do E-mail de Autenticação (PHP Mailer)</label>
				            <input type="text" name="mailer_senha" class="form-control" value="<?php echo $result['mailer_senha']; ?>" required/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Servidor SMTP</label>
				            <input type="text" name="servidor_smtp" class="form-control" value="<?php echo $result['servidor_smtp']; ?>" required/>
				        </div>
				        <div class="form-group">
				        	<label>Servidor SMTP - Porta</label>
				            <input type="text" name="servidor_smtp_porta" class="form-control" value="<?php echo $result['servidor_smtp_porta']; ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>E-mail Notificação</label>
				            <input type="text" name="email_notificacao" class="form-control" value="<?php echo $result['email_notificacao']; ?>" required/>
				        </div>
						<div class="form-group">
				        	<label>E-mail Notificação (cópia)</label>
				            <input type="text" name="email_notificacao_copia" class="form-control" value="<?php echo $result['email_notificacao_copia']; ?>"/>
				        </div>
						<div class="form-group">
				        	<label>E-mail Notificação (cópia oculta)</label>
				            <input type="text" name="email_notificacao_copia_oculta" class="form-control" value="<?php echo $result['email_notificacao_copia_oculta']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
							<label>Imagem do cabeçalho do E-mail de Notificação <small>(dimensões: 850x280px)</small></label>
							<?php if(!empty($result['arquivo'])){ ?>
							<a href="<?php echo $urlC.$result['arquivo']; ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
							<?php } ?>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo">
							</span>
						</div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
							<label>Imagem do rodapé do E-mail de Notificação <small>(dimensões: 850x90px)</small></label>
							<?php if(!empty($result['arquivo2'])){ ?>
							<a href="<?php echo $urlC.$result['arquivo2']; ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
							<?php } ?>
							<span class="btn btn-default btn-file btn-file-lg">
								<input type="file" name="arquivo2">
							</span>
						</div>
				    </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Mensagem de Notificação para Novos Cadastros</label> 
			        		<textarea class="form-control" rows="3" name="texto_cadastro"><?php echo $result['texto_cadastro']; ?></textarea>
			        	</div>
			        </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Mensagem de Notificação para Novos Pedidos</label> 
			        		<textarea class="form-control" rows="3" name="texto_pedido"><?php echo $result['texto_pedido']; ?></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/> 
							<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>    
							<input type="hidden" name="acao" value="update"/>
							<input type="submit" value="Alterar"  class="btn btn-info"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>