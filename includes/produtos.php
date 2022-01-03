
<?php

$secao_nome = NULL;

if(isset($_GET['secao']) && !is_numeric($_GET['secao'])){
	
	$_GET['secao_nominal'] = $_GET['secao'];
	 $queryS = $conn->query("SELECT * FROM secao WHERE slug(nome) = '{$_GET['secao']}'");	
	 $resultS = $queryS->fetch_array();
	 $_GET['secao'] = $resultS['id'];
	 
	 $secao_nome = ' - '.$resultS['nome'];
}

$busca 			= (isset($_GET['busca']) && !empty($_GET['busca']))?($_GET['busca']):(FALSE);
$secao			= (isset($_GET['secao']) && !empty($_GET['secao']))?($_GET['secao']):(FALSE);
$categoria		= (isset($_GET['categoria']) && !empty($_GET['categoria']))?($_GET['categoria']):(FALSE);
$subcategoria	= (isset($_GET['subcategoria']) && !empty($_GET['subcategoria']))?($_GET['subcategoria']):(FALSE);

$add_join = NULL;
$add_where = NULL;
$add_whereX = NULL;

if(isset($_GET['busca']) && empty($_GET['busca'])){ header("Location: $urlC"); }

if(isset($_GET['busca']) && !empty($_GET['busca'])){
				
	$add_where .= " AND CONCAT_WS(' ',produto.nome,subcategoria.nome,categoria.nome,produto.referencia) LIKE '%".str_replace(" ","%",$_GET['busca'])."%'";
}

if (isset($_GET['secao']) && !empty($_GET['secao'])) {

	$add_where .= " AND (secao.id = {$secao} OR produto.secoes LIKE '%,{$secao}%' OR produto.secoes LIKE '%{$secao},%' OR produto.secoes = '{$secao}' )";
}

if(isset($_GET['categoria']) && !empty($_GET['categoria'])){
				
	$add_where .= " AND categoria.id = {$_GET['categoria']}";
}

if(isset($_GET['subcategoria']) && !empty($_GET['subcategoria'])){
				
	$add_where .= " AND subcategoria.id = {$_GET['subcategoria']}";
}

if(isset($_GET['tamanho']) && !empty($_GET['tamanho'])){
				
	$add_whereX .= " AND tamanho.nome = '{$_GET['tamanho']}'";
}
if(isset($_GET['cor']) && !empty($_GET['cor'])){
				
	$add_whereX .= " AND cor.nome = '{$_GET['cor']}'";
}
if(isset($_GET['tecido']) && !empty($_GET['tecido'])){
				
	$add_whereX .= " AND tecido.nome = '{$_GET['tecido']}'";
}

$add_select = NULL;

if(isset($_GET['filtro'])){
	
	if($_GET['filtro'] == 'mais-relevantes'){
		$add_order = 'ORDER BY produto.ordem DESC';
	}elseif($_GET['filtro'] == 'melhor-avaliados'){
		$add_select = ' , ( SELECT (SUM(nota)/COUNT(*)) FROM avaliacao WHERE id_produto = produto.id ) AS media ';
		$add_order = 'ORDER BY media DESC';
	}elseif($_GET['filtro'] == 'menor-preco'){
		$add_order = 'ORDER BY rel_produto_var.valor';
	}elseif($_GET['filtro'] == 'maior-preco'){
		$add_order = 'ORDER BY rel_produto_var.valor DESC';
	}elseif($_GET['filtro'] == 'AaZ'){
		$add_order = 'ORDER BY produto.nome';
	}elseif($_GET['filtro'] == 'ZaA'){
		$add_order = 'ORDER BY produto.nome DESC';
	}
}else{
	$add_order = 'ORDER BY produto.ordem DESC';
}
?>

<?php if(isset($parametro)){ ?>
	<?php $slug = (isset($parametro))?($parametro):(0); ?>
	
	<?php
	$array_parametro = explode('__', $slug);
	if(count($array_parametro) == 2){
		$slug = $array_parametro[1];
	}
	?>
	
	<?php $queryC = $conn->query("SELECT * FROM {$pagina} WHERE slug(nome) = '{$slug}'"); ?>
	<?php if($queryC->num_rows > 0){
		
		$resultC = $queryC->fetch_array();
					
		$add_where .= " AND {$pagina}.id = {$resultC['id']}";
	} ?>
<?php } ?>

<?php
$sql = "SELECT produto.*, slug(CONCAT(produto.nome,' ',produto.referencia)) AS slug, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores {$add_select}
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN secao ON produto.secoes LIKE CONCAT('%,', secao.id, '%') OR produto.secoes LIKE CONCAT('%', secao.id, ',%') OR produto.secoes = secao.id
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
WHERE produto.ativo = 't' AND rel_produto_var.valor > 0
{$add_where}
GROUP BY produto.id
{$add_order}";

$queryX = $conn->query("{$sql}");
?>

<?php
$sql = "SELECT produto.*, slug(CONCAT(produto.nome,' ',produto.referencia)) AS slug, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores {$add_select}
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN secao ON produto.secoes LIKE CONCAT('%,', secao.id, '%') OR produto.secoes LIKE CONCAT('%', secao.id, ',%') OR produto.secoes = secao.id
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
LEFT JOIN cor ON cor.id = rel_produto_var.id_cor
LEFT JOIN tamanho ON tamanho.id = rel_produto_var.id_tamanho
LEFT JOIN tecido ON tecido.id = produto.id_tecido
WHERE produto.ativo = 't' AND rel_produto_var.valor > 0
{$add_where} {$add_whereX}
GROUP BY produto.id
{$add_order}";

$query = $conn->query("{$sql}");
?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Produtos</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="featured-product ptb-60">
    <div class="container">
    	<div class="pro_cat tab_content product-listing grid-type">
	    	<?php if($busca){ ?>					
			<div class="row">
				<div class="col-12">
					<ol class="breadcrumb">
						<li>Busca por: "<b><?php echo $busca; ?></b>"</li>
					</ol>
				</div>
			</div>
			<?php } ?>
			<?php if(isset($parametro)){ ?>
				<?php if($queryC->num_rows > 0){ ?>
				<div class="row">
					<div class="col-12">
						<h3 class="text-center"><?php echo $resultC['nome'].$secao_nome; ?></h3>
					</div>
				</div>
				<?php } ?>
			<?php } ?>
			<br/>
			<div class="row">
				<div class="col-12 text-right ordenar">
					<?php
					$p = parse_url($urlFull, PHP_URL_QUERY);
					parse_str($p, $pmr); $pmr['filtro'] = 'mais-relevantes'; $url_mr = http_build_query($pmr);
					parse_str($p, $pma); $pma['filtro'] = 'melhor-avaliados'; $url_ma = http_build_query($pma);
					parse_str($p, $pmenor); $pmenor['filtro'] = 'menor-preco'; $url_menor = http_build_query($pmenor);
					parse_str($p, $pmaior); $pmaior['filtro'] = 'maior-preco'; $url_maior = http_build_query($pmaior);
					parse_str($p, $paz); $paz['filtro'] = 'AaZ'; $url_az = http_build_query($paz);
					parse_str($p, $pza); $pza['filtro'] = 'ZaA'; $url_za = http_build_query($pza);
					?>
					Ordenar por:&nbsp;&nbsp;&nbsp;
					<a href="<?php echo $urlX.'?'.$url_mr; ?>" class="btn btn-custom btn-sm <?php echo (!isset($_GET['filtro']) || $_GET['filtro'] == 'mais-relevantes')?('active'):(NULL); ?>">Mais relevantes</a>
					<a href="<?php echo $urlX.'?'.$url_ma; ?>" class="btn btn-custom btn-sm <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'melhor-avaliados')?('active'):(NULL); ?>">Melhor avaliados</a>
					<a href="<?php echo $urlX.'?'.$url_menor; ?>" class="btn btn-custom btn-sm <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'menor-preco')?('active'):(NULL); ?>">Menor preço</a>
					<a href="<?php echo $urlX.'?'.$url_maior; ?>" class="btn btn-custom btn-sm <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'maior-preco')?('active'):(NULL); ?>">Maior preço</a>
					<a href="<?php echo $urlX.'?'.$url_az; ?>" class="btn btn-custom btn-sm <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'AaZ')?('active'):(NULL); ?>">A a Z</a>
					<a href="<?php echo $urlX.'?'.$url_za; ?>" class="btn btn-custom btn-sm <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'ZaA')?('active'):(NULL); ?>">Z a A</a>
				</div>
			</div>
			<br/><br/>
			<div class="row">
				<?php if($queryX->num_rows > 0){ ?>
				<div class="col-12 col-sm-3">	
					<div class="sidebar-box mb-30">
						<span class="opener plus"></span>
						<div class="sidebar-title">
							<h3><i class="fa fa-filter"></i> Filtro</h3>
						</div>
						<div class="sidebar-contant">
							<?php $array_ids = array(); ?>
							<?php $array_ids[] = 0; ?>
							<?php while($resultX = $queryX->fetch_array()){
								
								$array_ids[] = $resultX['id'];
							} ?>
							<?php $in_ids = implode(',',$array_ids); ?>
							<form action="<?php echo $urlFull; ?>" method="get" class="form-filtro">
								<div class="mb-20">
									<div class="inner-title">Tamanho</div>
									<ul>
										<?php
										$queryX = $conn->query("SELECT tamanho.*
										FROM tamanho
										INNER JOIN rel_produto_var ON rel_produto_var.id_tamanho = tamanho.id
										INNER JOIN produto ON produto.id = rel_produto_var.id_produto
										INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
										INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
										WHERE produto.ativo = 't' AND produto.id IN ({$in_ids})
										GROUP BY tamanho.id
										ORDER BY tamanho.ordem DESC"); ?>
										<?php while($resultX = $queryX->fetch_array()){ ?>
										<li>
											<div class="radio-box"> 
												<span>
												<input type="radio" class="radio" id="<?php echo 'tamanho'.$resultX['id']; ?>" name="tamanho" value="<?php echo $resultX['nome']; ?>" <?php echo (isset($_GET['tamanho']) && $_GET['tamanho'] == $resultX['nome'])?('checked'):(NULL); ?>>
												<label for="<?php echo 'tamanho'.$resultX['id']; ?>"><?php echo $resultX['nome']; ?></label>
												</span>
											</div>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="mb-20">
									<div class="inner-title">Cor</div>
									<ul>
										<?php
										$queryX = $conn->query("SELECT cor.*
										FROM cor
										INNER JOIN rel_produto_var ON rel_produto_var.id_cor = cor.id
										INNER JOIN produto ON produto.id = rel_produto_var.id_produto
										INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
										INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
										WHERE produto.ativo = 't' AND produto.id IN ({$in_ids})
										GROUP BY cor.id
										ORDER BY cor.nome"); ?>
										<?php while($resultX = $queryX->fetch_array()){ ?>
										<li>
											<div class="radio-box"> 
												<span>
												<input type="radio" class="radio" id="<?php echo 'cor'.$resultX['id']; ?>" name="cor" value="<?php echo $resultX['nome']; ?>" <?php echo (isset($_GET['cor']) && $_GET['cor'] == $resultX['nome'])?('checked'):(NULL); ?>>
												<label for="<?php echo 'cor'.$resultX['id']; ?>"><?php echo $resultX['nome']; ?></label>
												</span>
											</div>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="mb-20">
									<div class="inner-title">Tecido</div>
									<ul>
										<?php
										$queryX = $conn->query("SELECT tecido.*
										FROM tecido
										INNER JOIN produto ON produto.id_tecido = tecido.id
										INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
										INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
										INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
										WHERE produto.ativo = 't' AND produto.id IN ({$in_ids})
										GROUP BY tecido.id
										ORDER BY tecido.nome"); ?>
										<?php while($resultX = $queryX->fetch_array()){ ?>
										<li>
											<div class="radio-box"> 
												<span>
												<input type="radio" class="radio" id="<?php echo 'tecido'.$resultX['id']; ?>" name="tecido" value="<?php echo $resultX['nome']; ?>" <?php echo (isset($_GET['tecido']) && $_GET['tecido'] == $resultX['nome'])?('checked'):(NULL); ?>>
												<label for="<?php echo 'tecido'.$resultX['id']; ?>"><?php echo $resultX['nome']; ?></label>
												</span>
											</div>
										</li>
										<?php } ?>
									</ul>
								</div>
								<?php if(isset($_GET['secao_nominal'])){ ?>
								<input type="hidden" name="secao" value="<?php echo $_GET['secao_nominal']; ?>"/>
								<?php } ?>
								<?php if(isset($_GET['busca'])){ ?>
								<input type="hidden" name="busca" value="<?php echo $_GET['busca']; ?>"/>
								<?php } ?>
								<button type="submit" class="btn btn-color">Filtrar</button>
							</form>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="col-12 <?php if($queryX->num_rows > 0){ ?>col-sm-9 <?php } ?>">
			    	<div class="row area-produtos">
						<?php if($query->num_rows == 0){ ?>
							<div class="col-12">
								<div class="alert alert-warning alert-dismissable text-center">
				                    <i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Nenhum produto encontrado!
				                </div>
							</div>
						<?php }else{ ?>
							<?php $query->data_seek(0); ?>
							<?php while($result = $query->fetch_array()){ ?>
					    		<div class="col-12 col-sm-6 col-md-4 item-produtos">
					    			<div class="product-item mb-20">
										<div class="product-item-inner">
											<div class="product-image">
												<a href="<?php echo $urlC.'produto/'.$result['slug']; ?>"> 
													<?php $queryG = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
													<?php if($queryG->num_rows > 0){ ?>
										                <?php $resultG = $queryG->fetch_array(); ?>
										                <?php 
										                $queryV = $conn->query("SELECT * FROM rel_produto_var WHERE id_produto = {$result['id']} AND id_cor = {$resultG['id_cor']} LIMIT 1");
														$resultV = $queryV->fetch_array();
										                ?>
														<figure class="<?php echo ($resultG['posicao'] == 'c')?('bg-contain'):('bg-cover'); ?> bg-p100">
															<img data-src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
														</figure>
													<?php }else{ ?>
														<figure class="bg-contain bg-p100 bordered">
															<img data-src="<?php echo $urlC.'assets/images/no-image.png'; ?>"/>
														</figure>
													<?php } ?>
												</a>
												<?php
												$queryZ = $conn->query("SELECT tamanho.*
												FROM tamanho
												INNER JOIN rel_produto_var ON rel_produto_var.id_tamanho = tamanho.id
												WHERE rel_produto_var.id_produto = {$result['id']}
												GROUP BY tamanho.id
												ORDER BY tamanho.ordem DESC"); ?>
												<?php if($queryZ->num_rows > 0){ ?>
													<div class="product-detail-inner">
														<div class="detail-inner-left align-center">
															<ul>
																<?php $cont = 0; ?>
																<?php while($resultZ = $queryZ->fetch_array()){ ?>
																	<?php $cont++; ?>
																	<?php if($cont <= 3){ ?>
																		<li class="pro-cart-icon">
																			<a><span><?php echo $resultZ['nome']; ?></span></a>
																		</li>
																	<?php } ?>
																<?php } ?>
																<?php if($queryZ->num_rows > 3){ ?>
																	<?php $queryZ->data_seek(0); ?>
																	<?php $tamanhos = array(); ?>
																	<?php while($resultZ = $queryZ->fetch_array()){ ?>
																		
																		<?php $tamanhos[] = $resultZ['nome']; ?>
																	<?php } ?>
																	<?php $tamanhos = implode(', ',$tamanhos); ?>
																	<li class="pro-cart-icon">
																		<a><span data-toggle="popover" data-trigger="hover" data-placement="top" title="Tamanhos" data-content="<?php echo $tamanhos; ?>">+</span></a>
																	</li>
																<?php } ?>
															</ul>
														</div>
													</div>
												<?php } ?>
											</div>
											<div class="product-item-details">
												<div class="product-item-name"> 
													<a href="<?php echo $urlC.'produto/'.$result['slug']; ?>"><?php echo $result['nome']; ?></a> 
												</div>
												<div class="rating-summary-block">
													<?php $media = Util::mediaAvaliacao($result['id']); ?>
													<?php $por_cento = $media * 20; ?>
													<div title="<?php echo $por_cento.'%'; ?>" class="rating-result"> 
														<span style="width:<?php echo $por_cento.'%'; ?>"></span>
													</div>
												</div>
												<div class="price-box"> 
													<?php if($resultV['valor'] > 0){ ?>
														<span class="price"><?php echo 'R$&nbsp;'.Util::fixValor($resultV['valor']); ?></span> 
														<?php if($result['valor_de'] > 0){ ?>
														<del class="price old-price"><?php echo 'R$&nbsp;'.Util::fixValor($result['valor_de']); ?></del> 
														<?php } ?>
														<?php if($_SESSION['max_sem_juros'] > 1 && Util::xSemJuros($resultV['valor']) > 1){ ?>
															<?php $parcelaX = Util::fixValor($resultV['valor'] / Util::xSemJuros($resultV['valor'])); ?>
															<p class="small"><?php echo Util::xSemJuros($resultV['valor']); ?>x sem juros de <b><?php echo 'R$&nbsp;'.$parcelaX; ?></b></p>
														<?php } ?>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
					    		</div>
				    		<?php } ?>
						<?php } ?>
			    	</div>
	    		</div>
	    	</div>
    	</div>
    </div>
</section>

