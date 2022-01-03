
<span data-active="noticias"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Dicas';
	
	$pagina_anterior 	= 'noticias';
	
	$table = $insert_table = 'noticia';
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small>/cadastrar</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	        	<li>
                    <a href="<?php echo $urlC.$pagina_anterior; ?>"><?php echo $titulo; ?></a>
                </li>
	            <li class="active">
	                Cadastrar
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
				        	<label>Nome</label>
				            <input type="text" name="nome" class="form-control"/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Data</label>
				            <input type="text" name="data" class="form-control data_completa" required/>
				        </div>
			        </div>
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Ativo</label>
				            <select name="ativo" class="form-control" required>
								<option value="t">Sim</option>
								<option value="f">Não</option>
							</select>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<label>Vídeo <small>(URL do vídeo no Youtube)</small></label>
							<input type="text" name="video" class="form-control"/>
						</div>
				    </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Texto</label> 
			        		<textarea class="form-control" rows="3" name="texto"></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
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