
<section class="main-wrap">
	<div class="row">
		<div class="col-12">
			<section class="banner-main">
				<div class="banner">
					<div class="main-banner">
						<?php $cont = 0; ?>
						<?php $query = $conn->query("SELECT * FROM banner WHERE ativo = 't' AND arquivo != '' AND ((DATE(NOW()) >= data_inicio OR data_inicio IS NULL OR data_inicio = '0000-00-00') AND (DATE(NOW()) <= data_fim OR data_fim IS NULL OR data_fim = '0000-00-00')) ORDER BY ordem DESC"); ?>
						<?php while($result = $query->fetch_array()){ ?>
							<?php $cont++; ?>
							<div class="<?php echo 'banner-'.$cont; ?>">
								<figure class="bg-cover bg-p40">
									<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>">
								</figure>
								<div class="banner-detail">
									<div class="row">
										<div class="col-lg-4"></div>
										<div class="col-lg-4 col-12 align-center">
											<div class="banner-detail-inner">
												<h1 class="banner-title"><?php echo $result['nome']; ?></h1>
												<div class="texto">
													<?php echo $result['texto']; ?>
												</div>
											</div>
											<?php if(!empty($result['link'])){ ?>
												<a class="btn big-btn btn-color" href="<?php echo Util::trataLink($result['link']); ?>">Veja mais</a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>

<?php
$sql = "SELECT produto.*, slug(CONCAT(produto.nome,' ',produto.referencia)) AS slug, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
WHERE produto.destaque = 't' AND produto.ativo = 't' AND rel_produto_var.valor > 0
GROUP BY produto.id
ORDER BY RAND()
LIMIT 8";

$query = $conn->query("{$sql}");
?>
<section class="featured-product ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part align-center mb-30">
					<h2 class="main_title heading">Nossos Produtos</h2>
				</div>
			</div>
		</div>
		<div class="pro_cat tab_content product-listing grid-type">
			<div class="row">
				<?php $delay = 0; ?>
				<?php while($result = $query->fetch_array()){ ?>
					<?php $delay += 200; ?>
					<?php $delay = ($delay > 800)?(200):($delay); ?>
					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
						<div class="product-item mb-20 wow fadeInUp" data-wow-delay="<?php echo $delay.'ms'; ?>">
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
									ORDER BY tamanho.ordem DESC
									LIMIT 6"); ?>
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
			</div>
		</div>
		
	</div>
</section>

<section class="sub-banner-block">
	<div class="container">
		<div class="center-sm">
			<div class="row mlr_-20">
				<?php $delay = 0; ?>
				<?php $query = $conn->query("SELECT * FROM banner_oferta_medio WHERE ativo = 't' AND ((DATE(NOW()) >= data_inicio OR data_inicio IS NULL OR data_inicio = '0000-00-00') AND (DATE(NOW()) <= data_fim OR data_fim IS NULL OR data_fim = '0000-00-00')) ORDER BY RAND() LIMIT 2"); ?>
				<?php while($result = $query->fetch_array()){ ?>
					<?php $delay += 200; ?>
					<div class="col-lg-4 col-md-6 col-sm-6 plr-20">
						<?php if(!empty($result['link'])){ ?><a href="<?php echo Util::trataLink($result['link']); ?>"><?php } ?>
						<div class="sub-banner sub-banner1 wow fadeInLeft" data-wow-delay="<?php echo $delay.'ms'; ?>">
							<figure class="bg-cover bg-p125b">								
								<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>" >
							</figure>
						</div>
						<?php if(!empty($result['link'])){ ?></a><?php } ?>
					</div>
				<?php } ?>
				<div class="col-lg-4 col-ms-12 plr-20">
					<div class="row mlr_-20">
						<?php $query = $conn->query("SELECT * FROM banner_oferta_pequeno WHERE ativo = 't' AND ((DATE(NOW()) >= data_inicio OR data_inicio IS NULL OR data_inicio = '0000-00-00') AND (DATE(NOW()) <= data_fim OR data_fim IS NULL OR data_fim = '0000-00-00')) ORDER BY RAND() LIMIT 2"); ?>
						<?php while($result = $query->fetch_array()){ ?>
							<?php $delay += 200; ?>
							<div class="col-lg-12 col-md-6 col-sm-6 plr-20">
								<?php if(!empty($result['link'])){ ?><a href="<?php echo Util::trataLink($result['link']); ?>"><?php } ?>
								<div class="sub-banner sub-banner2 wow fadeInUp" data-wow-delay="<?php echo $delay.'ms'; ?>">
									<figure class="bg-cover bg-p60">								
										<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>" >
									</figure>
								</div>
								<?php if(!empty($result['link'])){ ?></a><?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$sql = "SELECT produto.*, slug(CONCAT(produto.nome,' ',produto.referencia)) AS slug, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
WHERE produto.destaque = 't' AND produto.ativo = 't' AND rel_produto_var.valor > 0
GROUP BY produto.id
ORDER BY RAND()
LIMIT 8";

$query = $conn->query("{$sql}");
?>
<section class="featured-product ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part align-center">
					<h2 class="main_title heading">Confira também</h2>
				</div>
			</div>
		</div>
		<div class="pro_cat product-listing grid-type">
			<div class="row mlr_-20">
				<div class="owl-carousel best-seller-pro">
					<?php while($result = $query->fetch_array()){ ?>
						<div class="item">
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
										ORDER BY tamanho.ordem DESC
										LIMIT 6"); ?>
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
					
				</div>
			</div>
		</div>
	</div>
</section>


<section class="banner-main">
	<div class="banner">
		<?php $cont = 0; ?>
		<?php $query = $conn->query("SELECT * FROM banner_oferta_grande WHERE ativo = 't' AND ((DATE(NOW()) >= data_inicio OR data_inicio IS NULL OR data_inicio = '0000-00-00') AND (DATE(NOW()) <= data_fim OR data_fim IS NULL OR data_fim = '0000-00-00')) ORDER BY RAND()"); ?>
		<div class="banner-oferta">
			<?php while($result = $query->fetch_array()){ ?>
				<?php $cont++; ?>
				<div class="<?php echo 'banner-'.$cont; ?>">
					<figure class="bg-cover bg-overlay auto-height">
						<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>"/>
						<div class="container">
							<div class="row">
								<div class="col-lg-7 col-md-5 col-12"></div>
								<div class="col-lg-5 col-md-7 col-12">
									<div class="perellex-delail ptb-95 align-center">
										<div class="perellex-subtitle mtb-20s">Oferta!!!</div>
										<div class="perellex-title"><?php echo $result['nome']; ?></div>
										<div class="texto">
											<?php echo $result['texto']; ?>
										</div>
										<?php if(!empty($result['link'])){ ?>
											<br/>
											<a href="<?php echo Util::trataLink($result['link']); ?>" class="btn btn-color">Veja mais</a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</figure>
				</div>
			<?php } ?>
		</div>
	</div>
</section>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part align-center">
					<h2 class="main_title heading">Últimas Dicas</h2>
				</div>
			</div>
		</div>
		<div class="row mlr_-20">
			<div id="blog" class="owl-carousel">
				<?php $delay = 0; ?>
				<?php $query = $conn->query("SELECT *, slug(CONCAT(nome,'__',id)) AS slug FROM noticia WHERE ativo = 't' ORDER BY data DESC LIMIT 3"); ?>
				<?php while($result = $query->fetch_array()){ ?>
					<?php $delay += 200; ?>
					<div class="item">
						<div class="blog-item wow fadeInUp" data-wow-delay="<?php echo $delay.'ms'; ?>">
							<div class="blog-media mb-20">
								<a href="<?php echo $urlC.'dica/'.$result['slug']; ?>">
									<figure class="bg-cover bg-p75">
										<?php $queryG = $conn->query("SELECT * FROM noticia_galeria WHERE id_noticia = ".$result['id']." ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
										<?php if($queryG->num_rows > 0){ ?>
											<?php $resultG = $queryG->fetch_array(); ?>
												<img data-src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
										<?php }else{ ?>
												<img data-src="<?php echo $urlC.'assets/images/no-image.jpg'; ?>"/>
										<?php } ?>
									</figure>
								</a>
								<div class="date">
									<?php $data = Util::dataPost($result['data']); ?>
									<?php echo $data[2]; ?> <br>
									<span><?php echo ucfirst($data[1]); ?></span>
								</div>
							</div>
							<div class="blog-detail">
								<h3 class="blog-title"><a href="<?php echo $urlC.'dica/'.$result['slug']; ?>"><?php echo $result['nome']; ?></a></h3>
								<div class="dot-custom dot2">
									<div class="texto">
										<?php echo $result['texto']; ?>
									</div>
								</div>
								<a href="<?php echo $urlC.'dica/'.$result['slug']; ?>">Leia mais<i class="fa fa-angle-double-right"></i></a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php $query = $conn->query("SELECT * FROM marca ORDER BY ordem DESC"); ?>
<?php if($query->num_rows > 0){ ?>
<div class="brand-logo">
	<div class="container">
		<div class="row brand">
			<div class="col-md-12">
				<div id="brand-logo" class="owl-carousel align_center">
					<?php while($result = $query->fetch_array()){ ?>
						<div class="item">
							<?php if(!empty($result['link'])){ ?><a href="<?php echo Util::trataLink($result['link']); ?>" target="_blank"><?php } ?>
								<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>" title="<?php echo $result['nome']; ?>">
							<?php if(!empty($result['link'])){ ?></a><?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
