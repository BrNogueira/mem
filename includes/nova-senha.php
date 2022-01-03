
<?php $hash = $_GET['hash']; ?>

<?php $query = $conn->query("SELECT * FROM usuario WHERE MD5(rand) = '{$hash}' LIMIT 1"); ?>

<?php if($query->num_rows == 0){ header("Location: {$urlC}"); } ?>

<?php $result = $query->fetch_array(); ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center">
			<div class="bread-crumb right-side float-none">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Recuperação de Senha</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<p class="h5">Olá, <b><?php echo $result['nome']; ?></b>! <small>(<?php echo $result['email']; ?>)</small></p>
				<br/>
				<p class="font-700">Cadastre abaixo sua nova senha:</p>
				<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent form-insert form-cadastro" autocomplete="new-password">
					<div class="row">
						<div class="col-12 col-sm-6">
							<div class="form-group relative">
								<label>Nova senha*</label>
								<input type="password" name="senha" class="form-control input-senha" required>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group relative">
								<label>Confirme a sua nova senha*</label>
								<input type="password" class="form-control confirma-senha" autocomplete="off" required>
							</div>
						</div>
						<div class="col-12">      
							<input type="hidden" name="hash" value="<?php echo $hash; ?>"/> 
							<input type="hidden" name="acao" value="nova_senha"/>
							<button type="submit" class="btn btn-custom">Cadastrar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

