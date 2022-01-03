
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

<?php 
$id = 0;
if(isset($parametro)){
	
	$slug = explode('__',$parametro);
	$id = end($slug);
}
?>
<?php $query = $conn->query("SELECT * FROM noticia WHERE ativo = 't' AND id = {$id}"); ?>
<?php if($query->num_rows == 0){ header("Location: $urlC"); } ?>
<?php $result = $query->fetch_array(); ?>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8 wow fadeInLeft" data-wow-delay="500ms">
				<div class="box-noticia">
					<div class="row">
						<div class="col-12">
							<div class="">
								<div data-mh="topo-noticia">
									<blockquote>
										<h3 class="text-uppercase font-600">
											<?php echo $result['nome']; ?>
										</h3>
										<small class="data-custom text-custom"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo Util::fixData($result['data']); ?></small>
									</blockquote>
									<p class="text-grey text-right">
										Compartilhe:&nbsp;&nbsp;
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlFull; ?>" title="Compartilhe no Facebook!" target="_blank" class="link-share"><i class="fa fa-facebook-square text-facebook"></i></a>&nbsp;&nbsp;
										<a href="https://twitter.com/intent/tweet?url=<?php echo $urlFull; ?>&text=<?php echo Util::fixData($result['data']); ?> - <?php echo $result['nome']; ?>&hashtags=M&MKIDS" title="Compartilhe no Twitter!" target="_blank" class="link-share"><i class="fa fa-twitter-square text-twitter"></i></a>&nbsp;&nbsp;
										<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $urlFull; ?>&title=<?php echo urlencode($result['nome']); ?>&source=memkids.com.br" title="Compartilhe no LinkedIn!" target="_blank" class="link-share"><i class="fa fa-linkedin-square"></i></a>&nbsp;&nbsp;
										<a href="https://api.whatsapp.com/send?1=pt_BR&text=<?php echo Util::fixData($result['data']); ?> - M&MKIDS - <?php echo $result['nome']; ?> (<?php echo $urlFull; ?>)" title="Compartilhe no WhatsApp!" target="_blank" class="link-share"><i class="fa fa-whatsapp text-whatsapp"></i></a>&nbsp;&nbsp;
										<a href="mailto:?subject=<?php echo Util::fixData($result['data']); ?> - M&MKIDS&body=<?php echo $urlFull; ?>" title="Compartilhe por e-mail!" target="_blank" class="link-share"><i class="fa fa-send-o"></i></a>
									</p>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-12">
							<div class="info-noticia">
								<div class="texto text-justify">
									<?php echo $result['texto']; ?>
									<?php if(!empty($result['fonte'])){ ?>
									<br/>
									<p class="font-700"><i>Fonte: <?php echo $result['fonte']; ?></i></p>
									<?php } ?>
								</div>
								<br/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<?php $queryG = $conn->query("SELECT * FROM noticia_galeria WHERE id_noticia = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
				<?php if($queryG->num_rows > 0){ ?>
					<div class="col-12 no-padding area-zoom wow fadeInUp" data-wow-delay="1000ms">
						<?php $resultG = $queryG->fetch_array(); ?>
						<a href="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>" data-light-gallery>
							<figure class="bg-cover bg-p60 bordered img-maior">
								<img src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
							</figure>
						</a>
						<?php $queryG2 = $conn->query("SELECT * FROM noticia_galeria WHERE id_noticia = {$result['id']} ORDER BY capa DESC, ordem DESC"); ?>
						<?php if($queryG2->num_rows > 1){ ?>
							<div class="owl-carousel owl-zoom owl-theme">
								<?php while($resultG2 = $queryG2->fetch_array()){ ?>
									<div>
										<a href="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>">
											<figure class="bg-cover bg-p75 bordered">
												<img src="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>"/>
											</figure>
										</a>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="light-gallery hidden">
							<?php $queryG2->data_seek(0); ?>
							<?php while($resultG2 = $queryG2->fetch_array()){ ?>
								<a href="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>" title="<?php echo $resultG2['nome']; ?>">
									<img src="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>"/>
								</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
				<?php if(!empty($result['video'])){ ?>
				<br/>
				<div class="row">
					<div class="col-12 wow fadeInUp" data-wow-delay="500ms">
						<a href="https://www.youtube.com/watch?v=<?php echo $result['video']; ?>" data-light-gallery>
							<figure class="bg-cover bg-p50 figure-video">
								<img src="https://i.ytimg.com/vi/<?php echo $result['video']; ?>/hqdefault.jpg"/>
							</figure>
						</a>
						<div class="light-gallery hidden">
							<a href="https://www.youtube.com/watch?v=<?php echo $result['video']; ?>">
								<figure class="bg-cover bg-p75">                        			
							    	<img src="https://i.ytimg.com/vi/<?php echo $result['video']; ?>/hqdefault.jpg"/>
								</figure>
							</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<br/>
				<div class="row">
					<div class="col-12 wow fadeInUp" data-wow-delay="500ms">
						<p class="h5 dot-title text-uppercase font-600 mt-0 text-grey">Últimas Dicas</p>
						<ul class="lista-topicos">
							<?php $query = $conn->query("SELECT *, slug(CONCAT(noticia.nome,'__',noticia.id)) AS slug FROM noticia WHERE ativo = 't' AND id != {$result['id']} ORDER BY data DESC LIMIT 5"); ?>
							<?php while($result = $query->fetch_array()){ ?>
								<li>
									<a href="<?php echo $urlC.'dica/'.$result['slug']; ?>">
										<b><i class="fa fa-newspaper-o text-custom"></i>&nbsp;&nbsp;<?php echo $result['nome']; ?></b><br/>
										<small class="text-muted"><?php echo Util::fixData($result['data']); ?></small>
									</a>
								</li>
							<?php } ?>
						</ul>
						<br/>
						<a href="<?php echo $urlC.'dicas'; ?>" class="btn btn-custom">Ver todas as dicas</a>
					</div>
				</div>
				<br/>
			</div>
		</div>
	</div>
</section>

