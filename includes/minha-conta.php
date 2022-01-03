<?php if(!Util::isLogged()){ header("Location:".$urlC); } ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Minha Conta</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
    <div class="container">
		<div class="row">
			<div class="col-12">
				<p class="h2 text-center">Minha Conta</p>
			</div>
		</div>
		<br/> 
		
        <div class="row">
            <div class="col-12">
                <div class="row">
                	<div class="col-12 col-md-6">
                		<h4 class="text-uppercase">Meu Perfil</h4>
						<dl class="dl-horizontal">
							<dt>Nome</dt>
							<dd><?php echo $_SESSION['cliente_dados']['nome'].' '.$_SESSION['cliente_dados']['sobrenome']; ?></dd>
							<dt>CPF</dt>
							<dd><?php echo $_SESSION['cliente_dados']['cpf']; ?></dd>
							<?php if(!empty($_SESSION['cliente_dados']['rg'])){ ?>
							<dt>CPF</dt>
							<dd><?php echo $_SESSION['cliente_dados']['rg']; ?></dd>
							<?php } ?>
							<dt>E-mail</dt>
							<dd><?php echo $_SESSION['cliente_dados']['email']; ?></dd>
							<dt>Nascimento</dt>
							<dd><?php echo Util::fixData($_SESSION['cliente_dados']['nascimento']); ?></dd>
							<dt>Telefone</dt>
							<dd><?php echo $_SESSION['cliente_dados']['telefone_contato']; ?></dd>
							<dt>Celular</dt>
							<dd><?php echo $_SESSION['cliente_dados']['telefone_celular']; ?></dd>
							<dt>CEP</dt>
							<dd><?php echo $_SESSION['cliente_dados']['cep']; ?></dd>
							<dt>Endereço</dt>
							<dd><?php echo $_SESSION['cliente_dados']['endereco'].', '.$_SESSION['cliente_dados']['numero']; ?></dd>
							<dt>Complemento</dt>
							<dd><?php echo $_SESSION['cliente_dados']['complemento']; ?></dd>
							<dt>Bairro</dt>
							<dd><?php echo $_SESSION['cliente_dados']['bairro']; ?></dd>
							<dt>Cidade</dt>
							<dd><?php echo $_SESSION['cliente_dados']['cidade'].' / '.$_SESSION['cliente_dados']['uf']; ?></dd>
						</dl>
                	</div>
                	<div class="col-12 col-md-6 bg-minha-conta">
                        <h4 class="text-uppercase">Painel de controle</h4>
                        <a href="<?php echo $urlC.'meus-pedidos'; ?>" class="text-uppercase text-color"><u>Meus Pedidos</u></a>
                        <br/>
	                    <a class="open-modal text-uppercase text-color" data-toggle="modal" data-target="#modal-cadastro" href="#"><u>Alterar informações</u></a>
	                    <br/>
                        <a href="<?php echo $urlC.'logout'; ?>" class="text-uppercase text-color"><u>Sair</u></a>
                    </div>
                </div>
            </div>
        </div>     
    </div>
</section>

<div class="modal fade modal-form" id="modal-cadastro" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<p class="h5">Alterar cadastro</p>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form action="<?php echo $urlC.'acao'; ?>" enctype="multipart/form-data" method="post" class="form-prevent form-insert">                       
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group">
								    <input type="text" name="nome" class="form-control" placeholder="Nome*" value="<?php echo $_SESSION['cliente_dados']['nome']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome*" value="<?php echo $_SESSION['cliente_dados']['sobrenome']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="cpf" class="form-control cpf-mask" placeholder="CPF*" value="<?php echo $_SESSION['cliente_dados']['cpf']; ?>" required>
								</div>
							</div>
							<?php if(!empty($_SESSION['cliente_dados']['rg'])){ ?>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="rg" class="form-control" placeholder="RG*" value="<?php echo $_SESSION['cliente_dados']['rg']; ?>" required>
								</div>
							</div>
							<?php } ?>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="nascimento" class="form-control data-mask" placeholder="Nascimento (dd/mm/aaaa)*" value="<?php echo Util::fixData($_SESSION['cliente_dados']['nascimento']); ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="tel" name="telefone_contato" class="form-control fone-mask" placeholder="Telefone Contato*" value="<?php echo $_SESSION['cliente_dados']['telefone_contato']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="tel" name="telefone_celular" class="form-control fone-mask" placeholder="Telefone Celular" value="<?php echo $_SESSION['cliente_dados']['telefone_celular']; ?>">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<select name="uf" class="form-control uf-select" required>
										<option value="">Estado...</option>
										<?php $consulta = $conn->query("SELECT * FROM estado ORDER BY uf"); ?>
										<?php while($result = $consulta->fetch_array()){ ?>
										
											<option value="<?php echo $result['uf']; ?>" <?php echo ($result['uf'] == $_SESSION['cliente_dados']['uf'])?('selected'):(NULL); ?>><?php echo $result['uf']; ?></option>
										<?php } ?>
									</select>
								</div>       
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="cep" data-id-cep="2" class="form-control cep-mask" placeholder="CEP*" value="<?php echo $_SESSION['cliente_dados']['cep']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="cidade" data-id-cidade="2" class="form-control" placeholder="Cidade*" value="<?php echo $_SESSION['cliente_dados']['cidade']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="bairro" data-id-bairro="2" class="form-control" placeholder="Bairro*" value="<?php echo $_SESSION['cliente_dados']['bairro']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="endereco" data-id-endereco="2" class="form-control" placeholder="Endereço*" value="<?php echo $_SESSION['cliente_dados']['endereco']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="numero" data-id-numero="2" class="form-control" placeholder="Número*" value="<?php echo $_SESSION['cliente_dados']['numero']; ?>" required>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" name="complemento" class="form-control" placeholder="Complemento (opcional)" value="<?php echo $_SESSION['cliente_dados']['complemento']; ?>">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="E-mail (login)*" alt="<?php echo $_SESSION['cliente_dados']['email']; ?>" value="<?php echo $_SESSION['cliente_dados']['email']; ?>" required>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<input type="password" name="senha" class="form-control" placeholder="Senha">
								</div>
							</div>
							<div class="col-12">      
								<input type="hidden" name="code" value="e86b161aa19a936df00032a39d83cce6"/> 
								<input type="hidden" name="acao" value="update"/>
								<button type="submit" class="btn btn-custom pull-right">Alterar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<br/><br/>
		</div>
	</div>
</div>