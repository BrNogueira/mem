
<div class="footer">
	<div class="footer-top bg-cover bg-overlay-custom">
		<img src="<?php echo $urlC.'assets/images/textura.jpg'; ?>"/>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<p class="text-center">Assine nossa Newsletter</p>
					<form class="form-inline form-newsletter" action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" name="email" placeholder="Seu e-mail" required>
								<input type="hidden" name="code" value="7bc03bc2d294a99cdf270d2189689a1d"/>
								<input type="hidden" name="acao" value="insert"/>
								<button class="input-group-addon" type="submit">Ok</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfix"></div>
			<br/>
			<div class="row">
				<div class="col-xl-12 center-sm">
					<div class="footer_social text-center float-none-md">
						<ul class="social-icon">
							<?php if(!empty($result_info['facebook'])){ ?>
							<li><a href="<?php echo $result_info['facebook']; ?>" title="Facebook" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<?php } ?>
							<?php if(!empty($result_info['instagram'])){ ?>
							<li><a href="<?php echo $result_info['instagram']; ?>" title="Linkedin" class="instagram" target="_blank"><i class="fab fa-instagram"> </i></a></li>
							<?php } ?>
							<?php if(!empty($result_info['twitter'])){ ?>
							<li><a href="<?php echo $result_info['twitter']; ?>" title="Twitter" class="twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<?php } ?>
							<?php if(!empty($result_info['linkedin'])){ ?>
							<li><a href="<?php echo $result_info['linkedin']; ?>" title="LinkedIn" class="linkedin" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<?php } ?>
							<?php if(!empty($result_info['youtube'])){ ?>
							<li><a href="<?php echo $result_info['youtube']; ?>" title="Pinterest" class="youtube" target="_blank"><i class="fab fa-youtube"> </i></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="footer-inner">
			<div class="footer-middle">
				<div class="row">
					<div class="col-lg-3 f-col logo-footer">
						<a href="<?php echo $urlC; ?>">
							<img src="<?php echo $urlC.'assets/images/logotipo.png'; ?>"/>
						</a>
					</div>
					<div class="col-lg-3 f-col">
						<div class="footer-static-block">
							<span class="opener plus"></span>
							<h3 class="title">Links<span></span></h3>
							<ul class="footer-block-contant link">
								<li><a href="<?php echo $urlC.'quem-somos'; ?>"><i class="fa fa-stop"></i>Quem Somos</a></li>
								<li><a href="<?php echo $urlC.'dicas'; ?>"><i class="fa fa-stop"></i>Dicas</a></li>
								<li><a href="<?php echo $urlC.'duvidas-frequentes'; ?>"><i class="fa fa-stop"></i>Dúvidas Frequentes</a></li>
								<li><a href="<?php echo $urlC.'fale-conosco'; ?>"><i class="fa fa-stop"></i>Fale Conosco</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 f-col">
						<div class="footer-static-block">
							<span class="opener plus"></span>
							<h3 class="title">Acesso<span></span></h3>
							<ul class="footer-block-contant link">
								<?php if(!Util::isLogged()){ ?>
								<li><a href="<?php echo $urlC.'login'; ?>"><i class="fa fa-stop"></i>Login/Cadastro</a></li>
								<?php }else{ ?>
								<li><a href="<?php echo $urlC.'minha-conta'; ?>"><i class="fa fa-stop"></i>Minha Conta</a></li>
								<li><a href="<?php echo $urlC.'meus-pedidos'; ?>"><i class="fa fa-stop"></i>Meus Pedidos</a></li>
								<?php } ?>
								<li><a href="<?php echo $urlC.'carrinho'; ?>"><i class="fa fa-stop"></i>Carrinho</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 f-col">
						<div class="footer-static-block">
							<span class="opener plus"></span>
							<h3 class="title">Central de Atendimento<span></span></h3>
							<div class="texto address-footer">
								<?php if(!empty($result_info['whatsapp'])){ ?>
								<p><a href="https://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo Util::apenasNumeros($result_info['whatsapp']); ?>" target="_blank"><i class="fa fa-whatsapp"></i>&nbsp;<?php echo $result_info['whatsapp']; ?></a></p>
								<?php } ?>
								<?php if(!empty($result_info['email'])){ ?>
								<p><a href="<?php echo 'mailto:'.$result_info['email']; ?>"><i class="fa fa-envelope"></i>&nbsp;<?php echo $result_info['email']; ?></a></p>
								<?php } ?>
								<?php if(!empty($result_info['endereco'])){ ?>
								<p><i class="fa fa-map"></i>&nbsp;<?php echo $result_info['endereco']; ?></p>
								<?php } ?>
								<?php if(!empty($result_info['atendimento'])){ ?>
								<p><i class="fa fa-clock"></i>&nbsp;<?php echo $result_info['atendimento']; ?></p>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<div class="copy-right-bg">
		<div class="container">
			<div class="row  align-center">
				<div class="col-12">
					<div class="site-link">
						<ul>
							<?php $cont = 0; ?>
							<?php $query = $conn->query("SELECT *, slug(CONCAT(nome,'__',id)) AS slug FROM pagina_institucional ORDER BY ordem DESC"); ?>
							<?php while($result = $query->fetch_array()){ ?>
								<?php $cont++; ?>
								<li><?php echo ($cont > 1)?('|'):(NULL); ?><a href="<?php echo $urlC.'institucional/'.$result['slug']; ?>"><?php echo $result['nome']; ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-12">
					<div class="copy-right "><b>M&M Kids</b> © <?php echo date('Y'); ?> - Todos os direitos reservados. Desenvolvido por <a href="http://doubleone.com.br" target="_blank">Double One</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<script src="<?php echo $urlC; ?>js/tether.min.js"></script> 
<script src="<?php echo $urlC; ?>js/bootstrap.js"></script>  
<script src="<?php echo $urlC; ?>js/jquery.downCount.js"></script>
<script src="<?php echo $urlC; ?>js/jquery-ui.min.js"></script> 
<script src="<?php echo $urlC; ?>js/fotorama.js"></script>
<script src="<?php echo $urlC; ?>js/jquery.magnific-popup.js"></script> 
<script src="<?php echo $urlC; ?>js/owl.carousel.min.js"></script>  
<script src="<?php echo $urlC; ?>js/custom.js"></script>


<script src="<?php echo $urlC; ?>assets/js/bootstrap-select.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.stellar.js"></script>
<script src="<?php echo $urlC; ?>assets/js/countUp.js"></script>
<script src="<?php echo $urlC; ?>assets/js/bootstrap-filestyle.js"></script>
<script src="<?php echo $urlC; ?>assets/datatables/datatables.min.js"></script>
<script src="<?php echo $urlC; ?>assets/chosen-multiselect/chosen.jquery.js"></script>
<script src="<?php echo $urlC; ?>assets/js/wow.min.js"></script>
<script>
new WOW({ 
	offset: 150,
	mobile: false 
}).init();
</script>
<?php if($pagina == 'pagamento'){ ?>
<script src="<?php echo $urlC; ?>assets/js/pagSeguro.js"></script>
<?php } ?>
<script src="<?php echo $urlC; ?>assets/js/masks.js"></script>
<!--[if lte IE 9]>
<script src="<?php echo $urlC; ?>assets/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->
<script src="<?php echo $urlC; ?>assets/js/jquery.matchHeight-min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/scripts.js?<?php echo date('His'); ?>"></script>


<?php if(isset($_SESSION['aviso']) && !empty($_SESSION['aviso'])){ ?>
<div class="modal fade modal-form" id="modal-aviso" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-danger alert-dismissible no-margin">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<strong>Aviso!</strong> <?php echo $_SESSION['aviso']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
		$('#modal-aviso').modal('show');
		$.ajax({url: urlC+'unset_ajax'});
	});
</script>
<?php } ?>

<?php if(isset($_SESSION['sucesso']) && !empty($_SESSION['sucesso'])){ ?>
<div class="modal fade modal-form" id="modal-sucesso" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-success alert-dismissible no-margin">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<strong>Pronto!</strong> <?php echo $_SESSION['sucesso']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
		$('#modal-sucesso').modal('show');
		$.ajax({url: urlC+'unset_ajax'});
	});
</script>
<?php } ?>

<?php if(!Util::isLogged()){ ?>
<div id="modal-login" class="modal fade modal-form" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<p class="h5">Faça seu login</p>           
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p class="font-700">Entre com os seus dados cadastrados abaixo:</p>
						<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-signin">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" id="label-user">
												<i class="fa fa-user"></i>
											</span>
											<input type="email" name="email" class="form-control" placeholder="E-mail" required>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" id="label-pass">
												<i class="fa fa-key"></i>
											</span>
											<input type="password" name="senha" class="form-control" placeholder="Senha" required>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<input type="hidden" name="acao" value="login"/>
									<button type="submit" class="btn btn-secondary">Login</button>
								</div>
							</div>
						</form>
						<br/>
						<p><a href="<?php echo $urlC.'login'; ?>">ou clique AQUI para se cadastrar</a></p>
						<p>Esqueceu sua senha? Clique <a href="javascript:void(0)" data-toggle-trigger="pass"><u><b>aqui</b></u></a>!</p>
						<div class="form-pass display-none" data-toggle-target="pass">
							<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-signin form-inline">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="label-user">
											<i class="fa fa-unlock"></i>
										</span>
										<input type="email" name="email" class="form-control" placeholder="E-mail cadastrado" required>
									</div>
								</div>
								<input type="hidden" name="acao" value="pass"/>
								<button type="submit" class="btn btn-secondary">Enviar</button>
								<div class="recaptcha" id="gr_senha"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

</body>
</html>