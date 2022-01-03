
<?php if(Util::isLogged()){ header("Location: {$urlC}carrinho"); } ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Login/Cadastro</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="ui-tabs tabs-login">
					<ul>
						<li><a href="#tabs-1">Já sou cadastrado</a></li>
						<li><a href="#tabs-2">Ainda não sou cadastrado</a></li>
					</ul>
					<div id="tabs-1">
						<div class="row">
							<div class="col-12">
								<p class="font-700">Entre com os seus dados cadastrados abaixo:</p>
								<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-signin">
									<div class="row">
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon" id="label-user">
														<i class="fa fa-user"></i>
													</span>
													<input type="email" name="email" class="form-control" placeholder="E-mail" required>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6">
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
								<p>Esqueceu sua senha? Clique <a href="javascript:void(0)" data-toggle-trigger="pass"><u><b>aqui</b></u></a>!</p>
								<div class="form-pass display-none" data-toggle-target="pass">
									<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-signin">
										<div class="row">
											<div class="col-12 col-sm-6">
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon" id="label-user">
															<i class="fa fa-unlock"></i>
														</span>
														<input type="email" name="email" class="form-control" placeholder="E-mail cadastrado" required>
													</div>
												</div>
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
					<div id="tabs-2">
						<div class="row">
							<div class="col-12">
								<p class="font-700">Informe seu dados abaixo para se cadastrar:</p>
								<form action="<?php echo $urlC.'acao'; ?>" enctype="multipart/form-data" method="post" class="form-prevent form-insert">
									<div class="row">
										<div class="col-12 col-sm-6">
											<div class="form-group">
											    <input type="text" name="nome" class="form-control" placeholder="Nome*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="cpf" class="form-control cpf-mask" placeholder="CPF*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="nascimento" class="form-control data-mask" placeholder="Nascimento (dd/mm/aaaa)*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="tel" name="telefone_contato" class="form-control fone-mask" placeholder="Telefone Contato*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="tel" name="telefone_celular" class="form-control fone-mask" placeholder="Telefone Celular">
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<select name="uf" class="form-control uf-select" required>
													<option value="">Estado*...</option>
													<?php $query = $conn->query("SELECT * FROM estado ORDER BY uf"); ?>
													<?php while($result = $query->fetch_array()){ ?>
													
														<option value="<?php echo $result['uf']; ?>"><?php echo $result['uf']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="cep" data-id-cep="1" class="form-control cep-mask" placeholder="CEP*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="cidade" data-id-cidade="1" class="form-control" placeholder="Cidade*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="bairro" data-id-bairro="1" class="form-control" placeholder="Bairro*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="endereco" data-id-endereco="1" class="form-control" placeholder="Endereço*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="numero" data-id-numero="1" class="form-control" placeholder="Número*" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="text" name="complemento" class="form-control" placeholder="Complemento (opcional)">
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="email" name="email" class="form-control" placeholder="E-mail (login)*" alt="" required>
											</div>
										</div>
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<input type="password" name="senha" class="form-control" placeholder="Senha*" required>
											</div>
										</div>
										<div class="col-12">      
											<input type="hidden" name="code" value="e86b161aa19a936df00032a39d83cce6"/> 
											<input type="hidden" name="acao" value="insert"/>
											<button type="submit" class="btn btn-secondary pull-right">Cadastrar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
		<br/><br/>
	</div>
</section>