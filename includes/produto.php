
<?php $slug = (isset($parametro))?($parametro):(0); ?>
<?php $queryC = $conn->query("SELECT * FROM produto WHERE slug(CONCAT(produto.nome,' ',produto.referencia)) = '{$slug}'"); ?>
<?php $resultC = $queryC->fetch_array(); ?>

<?php $id = $resultC['id']; ?>

<?php
$query = $conn->query("SELECT produto.*, categoria.id AS id_categoria, SUM(rel_produto_var.estoque) AS var_estoque, SUM(carrinho.quantidade) AS em_andamento, pedido.id_status AS id_status, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
LEFT JOIN carrinho ON carrinho.id_rel_produto_var = rel_produto_var.id
LEFT JOIN pedido ON pedido.id = carrinho.id_pedido
WHERE produto.ativo = 't' AND rel_produto_var.valor > 0 AND produto.id = {$id}
GROUP BY produto.id LIMIT 1");
?>

<?php 
if($query->num_rows == 0){

	//header("Location: $urlC"); 
}else{
	
	$result = $query->fetch_array();
	$id = $result['id'];//
}
?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Produto</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="featured-product ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-12 col-md-5">
						<?php $cont0 = 0; ?>
						<?php $queryZ = $conn->query("SELECT produto_galeria.id_cor, MAX(produto_galeria.capa), cor.nome AS cor
						FROM produto_galeria 
						INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto_galeria.id_produto
						INNER JOIN rel_produto_var AS rel_pro ON rel_produto_var.id_cor = produto_galeria.id_cor
						INNER JOIN cor AS cor ON cor.id = produto_galeria.id_cor
						WHERE produto_galeria.id_produto = ".$result['id']."
						GROUP BY produto_galeria.id_cor
						ORDER BY MAX(produto_galeria.capa) DESC, produto_galeria.ordem DESC");
						?>
						<?php while($resultZ = $queryZ->fetch_array()){ ?>
							<?php $cont0++; ?>
							<div class="area-galeria-produto <?php echo ($cont0 == 1)?(NULL):('display-none'); ?>" data-cor-galeria="<?php echo $resultZ['id_cor']; ?>">
								<?php $queryG = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} AND id_cor = {$resultZ['id_cor']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>		
								<?php if($queryG->num_rows > 0){ ?>
					                <?php $resultG = $queryG->fetch_array(); ?>
					                <?php if($cont0 == 1){
										
										$queryV = $conn->query("SELECT * FROM rel_produto_var WHERE id_produto = {$result['id']} AND id_cor = {$resultG['id_cor']} ORDER BY valor LIMIT 1");
										$resultV = $queryV->fetch_array();
									} ?>
									<a href="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>" data-light-gallery>
										<figure class="<?php echo ($resultG['posicao'] == 'c')?('bg-contain'):('bg-cover'); ?> bg-p75 bordered img-maior">
											<img src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
											<?php if($resultZ['id_cor'] > 0){ ?>
											<span class="nome-cor"><?php echo $resultZ['cor']; ?></span>
											<?php } ?>
										</figure>
									</a>
								<?php }else{ ?>
									<figure class="bg-contain bg-p75 bordered img-maior">
										<img src="<?php echo $urlC.'assets/images/no-image.png'; ?>"/>
										<?php if($resultZ['id_cor'] > 0){ ?>
										<span class="nome-cor"><?php echo $resultZ['cor']; ?></span>
										<?php } ?>
									</figure>
								<?php } ?>
								<div class="owl-carousel owl-zoom owl-theme">
									<?php $queryG2 = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} AND id_cor = {$resultZ['id_cor']} ORDER BY capa DESC, ordem DESC"); ?>
									<?php while($resultG2 = $queryG2->fetch_array()){ ?>
										<div>
											<a href="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>">
												<figure class="<?php echo ($resultG['posicao'] == 'c')?('bg-contain'):('bg-cover'); ?> bg-p75 bordered">
													<img src="<?php echo $urlC.'admin/'.$resultG2['arquivo']; ?>"/>
												</figure>
											</a>
										</div>
									<?php } ?>
								</div>
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
						<br />
					</div>
					<div class="col-12 col-md-7">
						<h4><?php echo $result['nome']; ?></h4>
						<?php if(!empty($result['referencia'])){ ?>
							<small><b>Referência:</b> <?php echo $result['referencia']; ?></small>
						<?php } ?>
						
						
						<?php $media = Util::mediaAvaliacao($result['id']); ?>	
						<?php $queryV = $conn->query("SELECT * FROM avaliacao WHERE id_produto = {$id}"); ?>
	    				<?php $votos = $queryV->num_rows; ?>
	    				
						<div class="row">
							<div class="col-12">
								<span class="avaliacao-produto">
									<?php for($i = 1; $i <= 5; $i++){ ?>
									<i class="fa <?php echo ($i <= $media)?('fa-star'):('fa-star-o'); ?>"></i>
									<?php } ?>
								</span>
								&nbsp;					
								<span>Avaliações (<?php echo $votos; ?>)</span>
								&nbsp;&nbsp;|&nbsp;					
								<?php if(Util::isLogged()){ ?>	
									<form method="post" action="<?php echo $urlC.'acao'; ?>" class="form-avaliacao">
										<?php $queryA = $conn->query("SELECT * FROM avaliacao WHERE id_usuario = {$_SESSION['cliente_dados']['id']} AND id_produto = {$result['id']}"); ?>
										<?php if($queryA->num_rows == 1){ ?>
											<?php $resultA = $queryA->fetch_array(); ?>
											<?php $nota = $resultA['nota']; ?>
										<?php }else{ ?>
											<?php $nota = 0; ?>
										<?php } ?>
										<span>
											<?php for($i = 1; $i <= 5; $i++){ ?>
												<button type="submit" name="nota" value="<?php echo $i; ?>">	
													<i class="fa <?php echo ($i <= $nota)?('fa-star'):('fa-star-o'); ?> text-custom"></i>
												</button>
											<?php } ?>
										</span>
										<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
										<input type="hidden" name="acao" value="avaliacao"/>
									</form>
									&nbsp;
									<span>Avalie este produto</span>
								<?php }else{ ?>
									<a href="#" data-toggle="modal" data-target="#modal-login">Avalie este produto</a>
								<?php } ?>
							</div>
						</div>
						
						<br />
						
						<div class="row">
							<div class="col-12">
								<p>
									<big class="big-preco text-custom">R$&nbsp;<span class="valor-final"><?php echo Util::fixValor((isset($resultV['valor']))?($resultV['valor']):($result['valor_produto'])); ?></span></big>
									<?php if($result['valor_de'] > 0){ ?>
										<strike class="text-custom-2"><small><?php echo 'R$ '.Util::fixValor($result['valor_de']); ?></small></strike>
										&nbsp;&nbsp;
									<?php } ?>
									<?php if($_SESSION['max_sem_juros'] > 1 && Util::xSemJuros($resultV['valor']) > 1){ ?>
										<?php $parcelaX = Util::fixValor($resultV['valor'] / Util::xSemJuros($resultV['valor'])); ?>
										<br/><span class="small">em até <?php echo Util::xSemJuros($resultV['valor']); ?>x sem juros de <b><?php echo 'R$&nbsp;'.$parcelaX; ?></b></span>
									<?php } ?>
								</p>
							</div>
						</div>
						
						<hr class="no-margin"/>
						<br/>
						
						<?php if($result['var_estoque'] == 0 || ($result['em_andamento'] >= $result['var_estoque']) && in_array($result['id_status'], array(1,2))){ ?>
						
							<div class="row">
								<div class="col-12">
									<p class="text-danger"><b>PRODUTO INDISPONÍVEL</b></p>
									<a href="#" class="btn btn-secondary btn-sm btn-produto text-uppercase text-white display-block" data-toggle="modal" data-target="#modal-avise-me"><i class="fa fa-envelope-o"></i> Avise-me quando chegar!</a>
								</div>
							</div>
							
							<div id="modal-avise-me"  class="modal fade modal-form modal-avise-me" role="dialog">
								<div class="modal-dialog ">
									<div class="modal-content">
										<div class="modal-header">
											<div class="container-fluid">
												<div class="row">
													<div class="col-md-12">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h5 class="text-uppercase">Avise-me quando este produto estiver disponível</h5>
														<p class="avise-produto"><b><?php echo $result['referencia'].' - '.$result['nome']; ?></b></p>
													</div>                            
												</div>
											</div>                           
										</div>
										<div class="modal-body">
											<div class="container-fluid">
												<div class="row">
													<div class="col-12 no-padding">
														<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent">
															<?php if(Util::isLogged()){ ?>
																<input type="hidden" name="nome" value="<?php echo $_SESSION['cliente_dados']['nome'].' '.$_SESSION['cliente_dados']['sobrenome']; ?>" required>
																<input type="hidden" name="email" value="<?php echo $_SESSION['cliente_dados']['email']; ?>" required>
															<?php }else{ ?>
																<div class="form-group">
																	<input type="text" name="nome" class="form-control" placeholder="Seu nome*" aria-describedby="label-user" required>
																</div>
																<div class="form-group">
																	<input type="email" name="email" class="form-control" placeholder="Seu e-mail*" aria-describedby="label-envelope" required>
																</div>
															<?php } ?>
															<input type="hidden" name="produto" class="avise-produto" value="<?php echo $result['referencia'].' - '.$result['nome']; ?>" required/>
															<div class="form-group">
																<textarea name="observacoes" class="form-control" rows="4" placeholder="Forneça em poucas palavras detalhes do produto desejado, como: COR, TAMANHO e MODELO.*" required></textarea>
															</div>
															<input type="hidden" name="tipo" value="avise_me"/>
															<input type="hidden" name="acao" value="send"/>
															<button type="submit" class="btn btn-custom pull-right">Enviar</button>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer"></div>
										<br/>
									</div>
								</div>
							</div>
						<?php }else{ ?>
						
							<form method="post" class="form-add-carrinho" action="<?php echo $urlC.'acao'; ?>">
								
								<div class="row">
									<?php $add_sql = (isset($_SESSION['rel']) && $_SESSION['rel'])?(" AND rel_produto_var.id = {$_SESSION['c_rel']} "):(NULL); ?>
									<?php
			                        $sqlC = "SELECT cor.*, cor.id AS id_cor, MAX(produto_galeria.capa)
										FROM cor
										INNER JOIN rel_produto_var ON rel_produto_var.id_cor = cor.id
										INNER JOIN produto ON produto.id = rel_produto_var.id_produto
										INNER JOIN produto_galeria ON produto_galeria.id_cor = rel_produto_var.id_cor
										WHERE rel_produto_var.estoque > 0 AND rel_produto_var.id_produto = {$result['id']} {$add_sql}
										AND ((
											SELECT COUNT(*) 
											FROM carrinho
											INNER JOIN pedido ON pedido.id = carrinho.id_pedido
											WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
										) = 0 OR rel_produto_var.estoque > (
											SELECT SUM(carrinho.quantidade) 
											FROM carrinho
											INNER JOIN pedido ON pedido.id = carrinho.id_pedido
											WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
										))
										GROUP BY cor.id
										ORDER BY MAX(produto_galeria.capa) DESC, produto_galeria.ordem DESC";
									$consulta5 = $conn->query($sqlC);
									$consulta5b = $conn->query($sqlC);
			                        ?>
			                        
			                        <?php $display_cor = NULL; ?>
			                        <?php if($consulta5b->num_rows == 1){ ?>
			                        	
			                        	<?php $result5b = $consulta5b->fetch_array(); ?>
			                        	<?php $display_cor = ($result5b['id_cor'] == 0)?('hide'):(NULL); ?>
			                        <?php } ?>
			                        
			                        <span class="id_produto" id="<?php echo $result['id']; ?>"></span>
			                        
			                        <div class="col-12 col-sm-5 product-chooser chooser-cor">
			                        	<p class="no-margin"><b>Cor:</b></p>
			                        	<?php if($consulta5->num_rows == 1){ ?>
				                            	
				                            	<?php $result5 = $consulta5->fetch_array(); ?>
				                            	<div class="" style="width: 50px;">
										    		<div class="product-chooser-item selected">
										    			<?php $queryC2 = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} AND id_cor = {$result5['id_cor']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
						                				<?php $resultC2 = $queryC2->fetch_array(); ?>
						                				<figure class="bg-cover bg-p100 bordered">
						                					<img src="<?php echo $urlC.'admin/'.$resultC2['arquivo']; ?>"/>
						                					<input type="radio" name="id_cor" value="<?php echo $result5['id_cor']; ?>" checked required/>
						                				</figure>
										    			<div class="clearfix"></div>
										    		</div>
										    	</div>
										    	<script>
				                            		$(document).ready(function(){
				                            			
				                            			var dir = window.location.href.split('/');
														var urlC = (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				                            			var id_produto = $('.id_produto').attr('id');
														var id_cor = $('[name=id_cor]:checked').val();
														
														$('.tamanhos-ok').html('');
														$('.modelos-ok').html('');
														
														$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val('');
														
														if(id_cor != ''){
															
															$.ajax({
														 	
																type: "POST",
																url: urlC+'tamanhos_ajax',
																data: {
																	id_produto: id_produto,
																	id_cor: id_cor
																},
															    success: function(data){
																	
																	setTimeout(function(){
																		
																		$('.tamanhos-ok').html(data);
																		$('.tamanhos-ok').fadeIn(500);
																	}, 500);
															    },
																beforeSend: function(){
																	$('.loader').fadeIn(100);
																},
																complete: function(){
																	$('.loader').fadeOut(100);
																}
															});
														}else{
															
															$('.tamanhos-ok').html('');
														}
				                            		});
				                            	</script>									    	
				                        <?php }else{ ?>
				                        	<?php while($result5 = $consulta5->fetch_array()){ ?>
				                        		<div class="pull-left" style="width: 50px;">
										    		<div class="product-chooser-item">
										    			<?php $queryC2 = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} AND id_cor = {$result5['id_cor']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
						                				<?php $resultC2 = $queryC2->fetch_array(); ?>
						                				<figure class="bg-cover bg-p100 bordered">
						                					<img src="<?php echo $urlC.'admin/'.$resultC2['arquivo']; ?>"/>
						                					<input type="radio" name="id_cor" value="<?php echo $result5['id_cor']; ?>" required/>
						                				</figure>
										    			<div class="clearfix"></div>
										    		</div>
										    	</div>
				                        	<?php } ?>
			                        	<?php } ?>
			                        </div>
			                        
			                        
			                        <div class="col-12 col-sm-7 product-chooser chooser-tamanho tamanhos-ok" data-select="<?php echo $result['id']; ?>">
			                        	<!--AJAX-->
			                        </div>
			                        <div class="clearfix"></div>
			                        <div class="col-12 col-sm-6 col-md-5 product-chooser chooser-modelo modelos-ok" data-select="<?php echo $result['id']; ?>">
			                        	<!--AJAX-->
			                        </div> 
			                    </div>
		                        
		                        <div class="clearfix"></div>
		                        <br/>
		                        
		                        <div class="row">
									<div class="col-12">
										<?php if(!empty($result['id_guia_tamanho'])){ ?>
											<?php
											$queryX = $conn->query("SELECT guia_tamanho.*
											FROM guia_tamanho
											INNER JOIN categoria_guia_tamanho ON categoria_guia_tamanho.id = guia_tamanho.id_categoria_guia_tamanho
											WHERE guia_tamanho.id = {$result['id_guia_tamanho']}
											GROUP BY guia_tamanho.id
											ORDER BY guia_tamanho.nome");
											?>
											<?php if($queryX->num_rows == 1){ ?>
												<?php $resultX = $queryX->fetch_array() ?>
												<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-guia-tamanhos" class="btn btn-default btn-sm btn-guia"><img src="<?php echo $urlC.'assets/images/rule.png'; ?>" class="regua"/>Guia de Tamanhos</a>
												<div id="modal-guia-tamanhos"  class="modal fade modal-form modal-avise-me" role="dialog">
													<div class="modal-dialog ">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="text-uppercase no-margin">Guia de Tamanhos</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>           
															</div>
															<div class="modal-body">
																<figure>
																	<img src="<?php echo $urlC.'admin/'.$resultX['arquivo']; ?>"/>
																</figure>
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<br/>
											<?php } ?>
										<?php } ?>
										<div class="texto">
											<?php echo $result['apresentacao']; ?>
										</div>
										<div class="clearfix"></div>
										<br/>
										<button type="submit" class="btn btn-custom btn-comprar text-uppercase add-trigger comprar-ok"><i class="fa fa-shopping-bag"></i> Comprar</button>
									</div>
								</div>
		                        
								
								<input type="hidden" name="acao" value="add_carrinho"/>
								<input type="hidden" name="id_rel_produto_var" value="" required/>
							</form>
							<br/>
						<?php } ?>
					</div>
				</div>
				
				<div id="tabs" class="tabs tab-zoom">
					<ul>
						<?php if(!empty($result['descricao'])){ ?>
						<li><a href="#tabs-1">Descrição</a></li>
						<?php } ?>
						<?php if(!empty($result['caracteristicas'])){ ?>
						<li><a href="#tabs-2">Características Técnicas</a></li>
						<?php } ?>
						<?php if(!empty($result['arquivo'])){ ?>
						<li><a href="<?php echo $urlC.'admin/download.php?file='.$result['arquivo'].'&nome=BULA-'.$result['nome']; ?>" class="link-tab ui-state-disabled">Baixar Bula</a></li>
						<?php } ?>
					</ul>
					<?php if(!empty($result['descricao'])){ ?>
					<div id="tabs-1">
						<div class="texto text-justify">
							<?php echo $result['descricao']; ?>
						</div>
					</div>
					<?php } ?>
					<?php if(!empty($result['caracteristicas'])){ ?>
					<div id="tabs-2" class="format-table">
						<?php echo $result['caracteristicas']; ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
