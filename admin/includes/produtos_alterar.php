
<span data-active="produtos"></span>

<?php if(isset($_SESSION['login'])){
		
	$titulo = 'Produtos';
	
	$table = $update_table = 'produto';
	
	$select_fields	= "*";			
	$select_table	= $table;	
	$select_join	= "";
	$select_where	= "WHERE id = $parametro";
	$select_group	= "";
	$select_order	= "";
	$select_limit 	= "";
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	$result = $consulta->fetch_array();
	
	$query0 = $conn->query("SELECT * FROM subcategoria WHERE id = {$result['id_subcategoria']}");
	$result0 = $query0->fetch_array();
	
	$query0b = $conn->query("SELECT * FROM categoria WHERE id = {$result0['id_categoria']}");
	$result0b = $query0b->fetch_array();
	
	$pagina_anterior = 'produtos/'.$result['id_subcategoria'];
	?>
    
    <div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?> <small> /categoria: "<?php echo $result0b['nome']; ?>" /subcategoria: "<?php echo $result0['nome']; ?>" /alterar</small>
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
	                Alterar
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
						<?php $secoes = explode(',', $result['secoes']); ?>
			        	<div class="form-group">
				        	<label>Seções</label>
				            <select name="secoes[]" class="form-control chosen-select" data-placeholder="...selecione as seções" multiple required>
				            	<?php $queryR = $conn->query("SELECT * FROM secao ORDER BY nome"); ?>
								<?php while($resultR = $queryR->fetch_array()){ ?>
									<option value="<?php echo $resultR['id']; ?>" <?php echo (in_array($resultR['id'], $secoes))?('selected'):(NULL); ?>><?php echo $resultR['nome']; ?></option>
								<?php } ?>
							</select>
				        </div>
				    </div>
			    	<div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Nome*</label>
				            <input type="text" name="nome" class="form-control" required value="<?php echo htmlentities($result['nome']); ?>"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Categoria &raquo; Subcategoria</label>
				            <select name="id_subcategoria" class="form-control chosen-select">
								<option value="">...selecione</option>
								<?php 
								$queryX2 = $conn->query("SELECT categoria.* 
								FROM categoria 
								INNER JOIN subcategoria ON subcategoria.id_categoria = categoria.id
								GROUP BY categoria.id
								ORDER BY categoria.nome"); 
								?>
								<?php while($resultX2 = $queryX2->fetch_array()){ ?>
									<optgroup label="<?php echo 'Categoria: '.$resultX2['nome']; ?>">
										<?php 
										$queryX3 = $conn->query("SELECT subcategoria.* 
										FROM categoria 
										INNER JOIN subcategoria ON subcategoria.id_categoria = categoria.id
										GROUP BY subcategoria.id
										ORDER BY subcategoria.nome"); 
										?>
										<?php while($resultX3 = $queryX3->fetch_array()){ ?>		
											<option value="<?php echo $resultX3['id']; ?>" <?php echo ($resultX3['id'] == $result['id_subcategoria'])?('selected'):(NULL); ?>><?php echo $resultX2['nome'].' &raquo; '.$resultX3['nome']; ?></option>
										<?php } ?>
									</optgroup>
								<?php } ?>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Referência*</label>
				            <input type="text" name="referencia" class="form-control" value="<?php echo $result['referencia']; ?>" required/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
						<div class="form-group">
				        	<label>Tipo de Tecido</label>
				            <select name="id_tecido" class="form-control">
								<option value="">...selecione</option>
								<?php $queryX = $conn->query("SELECT * FROM tecido ORDER BY nome"); ?>
								<?php while($resultX = $queryX->fetch_array()){ ?>
									<option value="<?php echo $resultX['id']; ?>" <?php echo ($resultX['id'] == $result['id_tecido'])?('selected'):(NULL); ?>><?php echo $resultX['nome']; ?></option>
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
											<option value="<?php echo $resultX2['id']; ?>" <?php echo ($resultX2['id'] == $result['id_guia_tamanho'])?('selected'):(NULL); ?>><?php echo $resultX2['nome']; ?></option>
										<?php } ?>
									</optgroup>
								<?php } ?>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				    	<div class="form-group">
				        	<label>Valor antigo <small>(opcional)</small></label>
				            <input type="text" name="valor_de" class="form-control moeda_real" value="<?php echo number_format($result['valor_de'],2,'.',''); ?>"/>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Destaque* <small>(destaques aparecem aleatoriamente na página principal)</small></label>
				            <select name="destaque" class="form-control" required>
								<option value="t" <?php echo ($result['destaque'] == 't')?('selected'):(NULL); ?>>Sim</option>
								<option value="f" <?php echo ($result['destaque'] == 'f')?('selected'):(NULL); ?>>Não</option>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
				        	<label>Ativo*</label>
				            <select name="ativo" class="form-control" required>
								<option value="t" <?php echo ($result['ativo'] == 't')?('selected'):(NULL); ?>>Sim</option>
								<option value="f" <?php echo ($result['ativo'] == 'f')?('selected'):(NULL); ?>>Não</option>
							</select>
				        </div>
				    </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Apresentação</label> 
			        		<textarea class="form-control" rows="3" name="apresentacao"><?php echo $result['apresentacao']; ?></textarea>
			        	</div>
			        </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Descrição</label> 
			        		<textarea class="form-control" rows="3" name="descricao"><?php echo $result['descricao']; ?></textarea>
			        	</div>
			        </div>
				    <div class="col-xs-12">
			        	<div class="form-group">
			        		<label>Características</label> 
			        		<textarea class="form-control textarea-table" rows="3" name="caracteristicas"><?php echo $result['caracteristicas']; ?></textarea>
			        	</div>
			        </div>
			        <div class="col-xs-12">
				        <div class="form-group">
							<!-- INPUT ORDEM OBRIGATORIO EM LISTAGENS - PADRAO VAZIO - O SISTEMA APENAS PRECISA RECEBER ESTE POST -->
							<input type="hidden" name="ordem" value=""/>
							<!---->
				        	<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
							<input type="hidden" name="tabela" value="<?php echo $update_table; ?>"/>      
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