
<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Dicas</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60 noticias">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part">
					<h2 class="main_title heading">Dicas</h2>
				</div>
			</div>
		</div>
		<div class="row mlr_-20">
			<?php $delay = 0; ?>
			<?php $sql_pag = "SELECT noticia.*, slug(CONCAT(noticia.nome,'__',noticia.id)) AS slug FROM noticia WHERE ativo = 't' ORDER BY data DESC"; ?>
			<?php $paginacao_limite = Util::paginacao_front(6, $sql_pag); ?>
			<?php $sql = "{$sql_pag} {$paginacao_limite[2]}"; ?>
			<?php $query = $conn->query($sql); ?>
	        <?php while($result = $query->fetch_array()){ ?>
	        	<?php $delay += 200; ?>
				<?php $delay = ($delay > 600)?(200):($delay); ?>
				<div class="col-12 col-sm-6 col-md-4">
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
		
		<?php if($paginacao_limite[0] > 0){ ?>
		<br/>
		<div class="row">
	    	<div class="col-12">
	    		<nav>
					<?php if(!empty($paginacao_limite[1])){ ?>
				    	<?php echo $paginacao_limite[1]; ?>
		    		<?php } ?>
			    </nav>
		    </div>
	    </div>
		<?php } ?>
	</div>
</section>
