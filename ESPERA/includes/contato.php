
<?php
    include_once("header.php");
?>
<div class="page-section pt-60 pb-60">
	<div class="container">
		<div class="row">		
			<div class="col-xs-12">
				<h3 class="text-center text-uppercase">Contato</h3>
				<div class="texto text-center">
				</div>
			</div>
		</div>
		<br/>
		<br/>
		<div class="row">		
			<div class="col-xs-12 col-sm-6">
				
				<div class="row">
						<div class="col-md-12">
							<div class="cis-cont">
								<div class="cis-icon">
									<div class="icon icon-basic-mail"></div>
								</div>
								<div class="cis-text">
									<h3 class="text-uppercase"><span class="bold">E-mail </span></h3>
									<p><a href="<?php echo 'mailto:'.@$result['email']; ?>"><?php echo @$result['email']; ?></a></p>
								</div>
							</div>
						</div>
				</div>

			</div>
			<div class=" col-xs-12 col-sm-6">
				
				<form class="" id="contact-form" action="#" method="post">
					<div class=" row">
						<div class="form-group">
							<input class="form-control" type="text" value="" name="name" id="name" placeholder="Nome" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<input class="form-control" type="email" value="" name="email" id="email" placeholder="E-mail" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<textarea class="form-control" maxlength="5000" rows="3" name="message" id="message" placeholder="Digite sua mensagem" required></textarea>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-center-xxs">
							<input type="submit" value="Enviar" class="button medium gray" data-loading-text="Enviando...">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<?php
    include_once("rodape.php");
?>