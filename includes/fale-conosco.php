
<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Fale Conosco</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<?php $query = $conn->query("SELECT * FROM contato LIMIT 1"); ?>
<?php $result = $query->fetch_array(); ?>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part">
					<h2 class="main_title heading">Fale Conosco</h2>
				</div>
			</div>
		</div>
		<div class="row">
	        <div class="col-12 col-lg-8">	        
	         	<div class="texto"><?php echo $result['texto']; ?></div>
	         	<br/>
	        </div>
	        <div class="col-12 col-lg-8">
	            <form method="post" action="<?php echo $urlC.'acao'; ?>" class="form-prevent">
	                <div class="row">
                        <div class="col-12">
                        	<div class="form-group">
                                <input type="text" name="nome" class="form-control" placeholder="Nome*" required/>
                        	</div>
                        </div>
                        <div class="col-12 col-sm-6">
                        	<div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="E-mail*" required/>
                        	</div>
                        </div>
                        <div class="col-12 col-sm-6">
                        	<div class="form-group">
                                <input type="text" name="telefone" class="form-control fone-mask" placeholder="Telefone" />
                        	</div>
                        </div>
                        <div class="col-12 col-sm-6">
                        	<div class="form-group">
                                <input type="text" name="cidade" class="form-control" placeholder="Cidade*" required/>
                        	</div>
                        </div>
                        <div class="col-12 col-sm-6">
                        	<div class="form-group">
                                <input type="text" name="uf" class="form-control uf-mask" placeholder="UF*" required/>
                        	</div>
                        </div>
	                    <div class="col-12">
                        	<div class="form-group">
		                        <textarea name="mensagem" class="form-control" rows="5" placeholder="Mensagem*" style="height: auto;" required></textarea>
                        	</div>
	                    </div>
	                    <div class="col-12">
	                    	<input type="hidden" name="tipo" value="contato"/>
							<input type="hidden" name="acao" value="send"/>
	                        <button type="submit" class="btn btn-custom pull-right">Enviar</button>
	                    </div>
	                </div>
	            </form>
		    </div>
		    <div class="col-12 col-lg-4">
		    	<div class="texto">
		    		<ul class="list-custom">
	            		<?php if(!empty($result_info['telefone'])){ ?>
	            		<li><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $result_info['telefone']; ?></li>
	            		<?php } ?>
	            		<?php if(!empty($result_info['whatsapp'])){ ?>
	            		<li><i class="fa fa-whatsapp"></i>&nbsp;&nbsp;<?php echo $result_info['whatsapp']; ?></li>
	            		<?php } ?>
	            		<?php if(!empty($result_info['email'])){ ?>
	            		<li><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<a href="mailto:<?php echo $result_info['email']; ?>"><?php echo $result_info['email']; ?></a></li>
	            		<?php } ?>
	            		<?php if(!empty($result_info['endereco'])){ ?>
	            		<li><i class="fa fa-map-o"></i>&nbsp;&nbsp;<?php echo $result_info['endereco']; ?></li>
	            		<?php } ?>
	            		<?php if(!empty($result_info['atendimento'])){ ?>
	            		<li><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo $result_info['atendimento']; ?></li>
	            		<?php } ?>
	            	</ul>
		    	</div>
		    </div>
		</div>
	</div>
</section>

<?php if(!empty($result_info['mapa'])){ ?>
    <section class="mapa bg-grey">
    	<?php echo $result_info['mapa']; ?>
    </section>
<?php } ?>