

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Quem Somos</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<?php $query = $conn->query("SELECT * FROM quem_somos LIMIT 1"); ?>
<?php $result = $query->fetch_array(); ?>

<section class="our_story">
	<div class="container">
		<div class="ptb-60">
			<div class="row">
				<div class="col-md-6">
					<div class="story_detail_part">
						<div class="heading-part">
							<h2 class="main_title heading"><?php echo $result['nome']; ?></h2>
						</div>
						<div class="texto">
							<?php echo $result['texto']; ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<figure>
						<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>"/>
					</figure>
				</div>
			</div>
		</div>
		<hr>
	</div>
</section>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="responsive-part">
					<div class="row">
						<?php $query = $conn->query("SELECT * FROM quem_somos_texto ORDER BY ordem DESC"); ?>
						<?php while($result = $query->fetch_array()){ ?>
							<div class="col-md-4">
								<div class="heading-part">
									<h2 class="main_title heading"><?php echo $result['nome']; ?></h2>
								</div>
								<div class="texto">
									<?php echo $result['texto']; ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $query = $conn->query("SELECT * FROM equipe ORDER BY ordem DESC"); ?>
<?php if($query->num_rows > 0){ ?>
<section class="client-bg ptb-60">
	<div class="top-shadow">
		<img src="images/top-shadow.png">
	</div>
	<div class="container">
		<div class="team-part team-opt-1">
			<div class="row">
				<div class="col-12">
					<div class="heading-part align-center">
						<h2 class="main_title heading">Equipe M&M Kids</h2>
					</div>
				</div>
			</div>
			<div class="pro_cat">
				<div class="row mlr_-20">
					<div class="owl-carousel our-team ">
						<?php while($result = $query->fetch_array()){ ?>
							<div class="item plr-20">
								<div class="team-item listing-effect col-sm-margin-b">
									<figure class="bg-cover bg-p125">
										<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>">
									</figure>
									<div class="team-item-detail">
										<h3 class="sub-title listing-effect-title"><?php echo $result['nome']; ?></h3>
										<div class="listing-meta"><?php echo $result['informacao']; ?></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-shadow">
		<img src="<?php echo $urlC.'images/bottom-shadow.png'; ?>">
	</div>
</section>
<?php } ?>

<?php $query = $conn->query("SELECT * FROM depoimento WHERE ativo = 't' ORDER BY data_hora DESC"); ?>
<?php if($query->num_rows > 0){ ?>
<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part align-center">
					<h2 class="main_title heading">Depoimentos de Clientes</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="client-main style-02">
					<div class="client-inner align-center">
						<div id="client" class="owl-carousel">
							<?php while($result = $query->fetch_array()){ ?>
								<div class="item client-detail">
									<div class="client-img ">
										<figure class="bg-cover img-depoimento">
											<?php if(!empty($result['arquivo'])){ ?>
												<img src="<?php echo $urlC.'admin/'.$result['arquivo']; ?>"> 
											<?php }else{ ?>
												<img src="<?php echo $urlC.'assets/images/icone-depoimentos.png'; ?>"> 
											<?php } ?>
										</figure>
										<h4 class="sub-title client-title">- <?php echo $result['nome']; ?> - </h4>
										<div class="designation"><?php echo $result['cidade']; ?></div>
									</div>
									<div class="quote">
										<div class="texto">
											<?php echo $result['texto']; ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-12 text-center">
				<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-depoimento" class="btn btn-custom">Envie seu Depoimento</a>
			</div>
		</div>
	</div>
</section>

<div id="modal-depoimento" class="modal fade modal-form" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<p class="h5">Envie seu depoimento abaixo:</p>           
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-signin" enctype="multipart/form-data">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<input type="email" name="email" class="form-control" placeholder="E-mail" required>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<input type="text" name="telefone" class="form-control fone-mask" placeholder="Telefone" required>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<input type="text" name="cidade" class="form-control" placeholder="Cidade/UF" required>
							</div>
						</div>
                		<div class="col-12">
                    		<div class="form-group">
								<span class="btn btn-secondary btn-file btn-foto">
									<input type="file" name="arquivo">
								</span>
		                    </div>
                		</div>
	                    <div class="col-12">
                        	<div class="form-group">
		                        <textarea name="depoimento" class="form-control" rows="5" placeholder="Depoimento" style="height: auto;" required></textarea>
                        	</div>
	                    </div>
						<div class="col-12">
	                    	<input type="hidden" name="tipo" value="depoimento"/>
							<input type="hidden" name="acao" value="send"/>
							<button type="submit" class="btn btn-custom">Enviar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>