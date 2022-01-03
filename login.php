<?php if(Util::isLogged()){
	
	header('Location:'.$urlC);
}else{ ?>
	
	<section>	
		<div class="container">
			<div class="login-container">
	            <div id="output"></div>
	            <div class="avatar">
	            	<img src="<?php echo $urlC.'img/logo-doubleone.jpg'; ?>" class="img-responsive"/>
	            </div>
	            <div class="form-box">
	                <form method="post" action="<?php echo $urlC.'logar'; ?>">
	                    <input name="login" type="text" placeholder="login" autofocus required>
	                    <input type="password" name="senha" placeholder="senha" required>
	                    <button class="btn btn-info btn-block login" type="submit">Entrar</button>
	                </form>
	            </div>
	        </div>
		</div>
	</section>
<?php } ?>