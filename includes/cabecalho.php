
<div class="main">

<header class="navbar navbar-custom container-full-sm" id="header">
	<div class="header-top">
		<div class="container">
			<div class="row m-0">
				<div class="col-12 col-md-6 col-sm-5 p-0">
					<div class="top-right-link d-none d-sm-block">
						<ul>
							<?php if(!empty($result_info['whatsapp'])){ ?>
							<li class="info-link">
								<a href="https://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo Util::apenasNumeros($result_info['whatsapp']); ?>" target="_blank"><i class="fa fa-whatsapp"></i><?php echo $result_info['whatsapp']; ?></a>
							</li>
							<?php } ?>
							<?php if(!empty($result_info['email'])){ ?>
							<li class="info-link">
								<a href="<?php echo 'mailto:'.$result_info['email']; ?>"><i class="fa fa-envelope-o"></i><?php echo $result_info['email']; ?></a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-12 col-md-6 col-sm-7 p-0">
					<div class="top-right-link right-side d-none d-sm-block">
						<ul>
							<?php if(!Util::isLogged()){ ?>
							<li class="info-link">
								<a href="<?php echo $urlC.'login'; ?>"><i class="fa fa-lock"></i>Login/Cadastro</a>
							</li>
							<?php }else{ ?>
							<li class="info-link">
								<a style="text-decoration: none;"><b>Olá, <?php echo $_SESSION['cliente_dados']['nome']; ?>!</b></a>
							</li>
							<li class="info-link">
								<a href="<?php echo $urlC.'minha-conta'; ?>"><i class="fa fa-user"></i>Minha Conta</a>
							</li>
							<li class="info-link">
								<a href="<?php echo $urlC.'meus-pedidos'; ?>"><i class="fa fa-cubes"></i>Meus Pedidos</a>
							</li>
							<?php } ?>
							<li class="info-link">
								<a href="<?php echo $urlC.'carrinho'; ?>"><i class="fa fa-shopping-bag"></i>Carrinho</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-middle">
		<div class="container">
			<div class="row mlr_-20">
				<div class="col-md-3 col-sm-12 plr-20">
					<div class="header-middle-left">
						<div class="navbar-header float-none-sm">
							<a class="navbar-brand" href="<?php echo $urlC.'home'; ?>">
							<img alt="M&M Kids" src="<?php echo $urlC.'assets/images/logotipo.png'; ?>">
							</a> 
						</div>
					</div>
				</div>
				<div class="col-md-9 col-sm-12 plr-20">
					<div class="row">
						<div class="col-12">
							<div class="main-right-part">
								<div class="header-right-part">
									<div class="category-main">
										<div class="main-search">
											<div class="header_search_toggle desktop-view">
												<form method="get" action="<?php echo $urlC.'produtos'; ?>">
													<div class="search-box">
														<input class="input-text" type="text" name="busca" placeholder="O que você está procurando?" required>
														<button class="search-btn"></button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="right-part">
									<ul>
										<li class="login-icon content">
											<a href="<?php echo (!Util::isLogged())?($urlC.'login'):($urlC.'minha-conta'); ?>" class="content-link">
												<span class="content-icon"></span> 
											</a>
										</li>
										<li class="cart-icon cart-box-main">
											<a href="<?php echo $urlC.'carrinho'; ?>">
												<span class="cart-icon-main"><small class="cart-notification"><?php echo (isset($_SESSION['carrinho_item']))?(count($_SESSION['carrinho_item'])):(0); ?></small></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom bg-cover bg-overlay-custom">
		<img src="<?php echo $urlC.'assets/images/textura.jpg'; ?>"/>
		<div class="container">
			<div class="header-line">
				<div class="row position-r mlr_-20">
					<div class="col-lg-12 plr-20 bottom-part">
						<div class="nav_sec position-r float-none-md">
							<div class="mobilemenu-title mobilemenu">
								<span>Menu</span>
								<i class="fa fa-bars pull-right"></i>
							</div>
							<div class="mobilemenu-content">
								<ul class="nav navbar-nav" id="menu-main">
									<?php
		                        	$query = $conn->query("SELECT secao.* 
		                        	FROM secao
		                        	INNER JOIN produto ON produto.secoes LIKE CONCAT('%,', secao.id, '%') OR produto.secoes LIKE CONCAT('%', secao.id, ',%') OR produto.secoes = secao.id
		                        	INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
		                        	INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
		                        	GROUP BY secao.id
		                        	ORDER BY secao.ordem DESC"); ?>
									<?php while($result = $query->fetch_array()){ ?>
										<li class="level dropdown">
											<span class="opener plus"></span>
											<a href="<?php echo $urlC.'secao/'.$result['slug']; ?>"><span><?php echo $result['nome']; ?></span></a>
											<div class="megamenu mobile-sub-menu">
												<div class="megamenu-inner-top">
													<ul class="sub-menu-level1">
														<?php
				                            			$query2 = $conn->query("SELECT categoria.*
				                            			FROM categoria
				                            			INNER JOIN subcategoria ON subcategoria.id_categoria = categoria.id
				                            			INNER JOIN produto ON produto.id_subcategoria = subcategoria.id
				                            			WHERE produto.secoes LIKE '%,{$result['id']}%' OR produto.secoes LIKE '%{$result['id']},%' OR produto.secoes = '{$result['id']}'
				                            			GROUP BY categoria.id
				                            			ORDER BY categoria.ordem DESC"); ?>
														<?php while($result2 = $query2->fetch_array()){ ?>
															<li class="level2">
																<a href="<?php echo $urlC.'categoria/'.$result2['slug'].'?secao='.$result['slug']; ?>"><span><?php echo $result2['nome']; ?></span></a>
																<ul class="sub-menu-level2">
																	<?php
							                            			$query3 = $conn->query("SELECT subcategoria.*
							                            			FROM subcategoria
							                            			INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
							                            			INNER JOIN produto ON produto.id_subcategoria = subcategoria.id
							                            			WHERE subcategoria.id_categoria = {$result2['id']} AND ( produto.secoes LIKE '%,{$result['id']}%' OR produto.secoes LIKE '%{$result['id']},%' OR produto.secoes = '{$result['id']}' )
							                            			GROUP BY subcategoria.id
							                            			ORDER BY subcategoria.ordem DESC"); ?>
																	<?php while($result3 = $query3->fetch_array()){ ?>
																		<li class="level3"><a href="<?php echo $urlC.'subcategoria/'.$result2['slug'].'__'.$result3['slug'].'?secao='.$result['slug']; ?>"><span>■</span><?php echo $result3['nome']; ?></a></li>
																	<?php } ?>
																</ul>
															</li>
														<?php } ?>
													</ul>
												</div>
											</div>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="popup-links">
		<div class="popup-links-inner">
			<ul>
				<?php if(!empty($result_info['whatsapp'])){ ?>
				<li class="account">
					<a href="https://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo Util::apenasNumeros($result_info['whatsapp']); ?>" target="_blank"><span class="icon"><i class="fa fa-whatsapp"></i></span><span class="icon-text">WhatsApp</span></a>
				</li>
				<?php } ?>
				<?php if(!empty($result_info['facebook'])){ ?>
				<li class="account">
					<a href="<?php echo $result_info['facebook']; ?>" target="_blank"><span class="icon"><i class="fa fa-facebook"></i></span><span class="icon-text">Facebook</span></a>
				</li>
				<?php } ?>
				<?php if(!empty($result_info['instagram'])){ ?>
				<li class="account">
					<a href="<?php echo $result_info['instagram']; ?>" target="_blank"><span class="icon"><i class="fa fa-instagram"></i></span><span class="icon-text">Instagram</span></a>
				</li>
				<?php } ?>
				<?php if(!empty($result_info['twitter'])){ ?>
				<li class="account">
					<a href="<?php echo $result_info['twitter']; ?>" target="_blank"><span class="icon"><i class="fa fa-twitter"></i></span><span class="icon-text">Twitter</span></a>
				</li>
				<?php } ?>
				<?php if(!empty($result_info['linkedin'])){ ?>
				<li class="account">
					<a href="<?php echo $result_info['linkedin']; ?>" target="_blank"><span class="icon"><i class="fa fa-linkedin"></i></span><span class="icon-text">LinkedIn</span></a>
				</li>
				<?php } ?>
				<?php if(!empty($result_info['youtube'])){ ?>
				<li class="account">
					<a href="<?php echo $result_info['youtube']; ?>" target="_blank"><span class="icon"><i class="fa fa-youtube-play"></i></span><span class="icon-text">Youtube</span></a>
				</li>
				<?php } ?>
				<li class="account scrollup">
					<a href="#"><span class="icon"><i class="fa fa-angle-double-up"></i></span><span class="icon-text">Topo</span></a>
				</li>
			</ul>
		</div>
		
	</div>
</header>
