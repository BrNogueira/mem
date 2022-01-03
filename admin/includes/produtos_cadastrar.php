
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){	
	
	$titulo = 'Produtos';
	
	$id_principal = 'id_subcategoria';
	
	$pagina_anterior = 'produtos/'.$parametro;
	
	$table = $insert_table = 'produto';
	
	$query0 = $conn->query("SELECT * FROM subcategoria WHERE id = {$parametro}");
	$result0 = $query0->fetch_array();
	
	$query0b = $conn->query("SELECT * FROM categoria WHERE id = {$result0['id_categoria']}");
	$result0b = $query0b->fetch_array();
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small>/categoria: "<?php echo $result0b['nome']; ?>" /subcategoria: "<?php echo $result0['nome']; ?>" /cadastrar</small>
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
	
	<p>* Obs.: Os valores de venda do produto são cadastrados de forma independente para cada variação na guia "ESTOQUE". Pode-se cadastrar diferentes valores considerando seu tamanho, peso e cor.</p><br/>
	
	<div class="row">
	   	<div class="col-xs-12">
		    <form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Seções</label>
				            <select name="secoes[]" class="form-control chosen-select" data-placeholder="...selecione as seções" multiple required>
				            	<?php $queryR = $conn->query("SELECT * FROM secao ORDER BY nome"); ?>
								<?php while($resultR = $queryR->fetch_array()){ ?>
									<option value="<?php echo $resultR['id']; ?>"><?php echo $resultR['nome']; ?></option>
								<?php } ?>
							</select>
				        </div>
				    </div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome*</label>
				            <input type="text" name="nome" class="form-control" required/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Referência*</label>
				            <input type="text" name="referencia" class="form-control" required/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Tipo de Tecido</label>
				            <select name="id_tecido" class="form-control">
								<option value="">...selecione</option>
								<?php $queryX = $conn->query("SELECT * FROM tecido ORDER BY nome"); ?>
								<?php while($resultX = $queryX->fetch_array()){ ?>
									<option value="<?php echo $resultX['id']; ?>"><?php echo $resultX['nome']; ?></option>
								<?php } ?>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Guia de Tamanho</label>
				            <select name="id_guia_tamanho" class="form-control">
								<option value="">...selecione</option>
								<?php
								$queryX = $conn->query("SELECT categoria_guia_tamanho.*
								FROM categoria_guia_tamanho
								INNER JOIN guia_tamanho ON guia_tamanho.id_categoria_guia_tamanho = categoria_guia_tamanho.id
								GROUP BY categoria_guia_tamanho.id
								ORDER BY categoria_guia_tamanho.nome");
								?>
								<?php while($resultX = $queryX->fetch_array()){ ?>
									<optgroup label="<?php echo $resultX['nome']; ?>">
										<?php $queryX2 = $conn->query("SELECT * FROM guia_tamanho WHERE id_categoria_guia_tamanho = {$resultX['id']} ORDER BY nome"); ?>
										<?php while($resultX2 = $queryX2->fetch_array()){ ?>
											<option value="<?php echo $resultX2['id']; ?>"><?php echo $resultX2['nome']; ?></option>
										<?php } ?>
									</optgroup>
								<?php } ?>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				    	<div class="form-group">
				        	<label>Valor antigo <small>(opcional)</small></label>
				            <input type="text" name="valor_de" class="form-control moeda_real"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Destaque* <small>(destaques aparecem aleatoriamente na página principal)</small></label>
				            <select name="destaque" class="form-control" required>
								<option value="">...selecione</option>
								<option value="t">Sim</option>
								<option value="f">Não</option>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Ativo*</label>
				            <select name="ativo" class="form-control" required>
								<option value="">...selecione</option>
								<option value="t">Sim</option>
								<option value="f">Não</option>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Apresentação</label> 
			        		<textarea class="form-control" rows="3" name="apresentacao"></textarea>
			        	</div>
			        </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Descrição</label> 
			        		<textarea class="form-control" rows="3" name="descricao"></textarea>
			        	</div>
			        </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Características</label> 
		        			<textarea class="form-control textarea-table" rows="3" name="caracteristicas"></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
							<input type="hidden" name="<?php echo $id_principal; ?>" value="<?php echo $parametro; ?>"/>      
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