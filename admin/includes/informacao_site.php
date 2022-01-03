
<span data-active="info"></span>

<?php if(isset($_SESSION['login'])){ ?>
	
	<?php
	$table = $update_table = 'informacao_site';
	
	$query = $conn->query("SELECT * FROM $table LIMIT 1");
	
	$result = $query->fetch_array();
	$result2 = Util::trataHtml($result);
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            Informações do Site <small>/alterar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                Informações do Site
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
					<div class="col-xs-12">
						<div class="form-group">
				        	<label>Título do Site</label>
				            <input type="text" name="nome" class="form-control" value="<?php echo $result['nome']; ?>" required/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>WhatsApp</label>
				            <input type="text" name="whatsapp" class="form-control fone-mask" value="<?php echo $result['whatsapp']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Telefone</label>
				            <input type="text" name="telefone" class="form-control fone-mask" value="<?php echo $result['telefone']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>E-mail</label>
				            <input type="text" name="email" class="form-control" value="<?php echo $result['email']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Facebook</label>
				            <input type="text" name="facebook" class="form-control" value="<?php echo $result['facebook']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Instagram</label>
				            <input type="text" name="instagram" class="form-control" value="<?php echo $result['instagram']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Twitter</label>
				            <input type="text" name="twitter" class="form-control" value="<?php echo $result['twitter']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>LinkedIn</label>
				            <input type="text" name="linkedin" class="form-control" value="<?php echo $result['linkedin']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Youtube</label>
				            <input type="text" name="youtube" class="form-control" value="<?php echo $result['youtube']; ?>"/>
				        </div>
			        </div>
			        <div class="col-xs-12">
						<div class="form-group">
							<label>Mapa (código do Mapa Incorporado do Google) - <a href="<?php echo $urlC.'img/mapa-exemplo.jpg'; ?>" class="fancybox">ver exemplo</a></label>
							<?php if(!empty($result['mapa'])){ ?>
								<div class="input-group">
									<input type="text" name="mapa" class="form-control" value="<?php echo $result2['mapa']; ?>">
									<a class="btn btn-success input-group-addon open-modal" data-toggle="modal" data-target="#modal-mapa" href="#"><i class="fa fa-globe fa-inverse"></i></a>
								</div>
							<?php }else{ ?>
								<input type="text" name="mapa" class="form-control" value="<?php echo $result2['mapa']; ?>"/>
							<?php } ?>
						</div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Endereço</label>
				            <input type="text" name="endereco" class="form-control" value="<?php echo $result['endereco']; ?>"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Atendimento</label>
				            <input type="text" name="atendimento" class="form-control" value="<?php echo $result['atendimento']; ?>"/>
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
			<div id="modal-mapa" class="modal fade modal-map" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title h2-titulo-section">Mapa</h4>
						</div>
						<div class="modal-body">
							<div class="row">                            
								<div class="col-xs-12">
									<?php echo $result['mapa']; ?>
								</div>                            
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>