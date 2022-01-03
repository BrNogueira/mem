
<?php if(isset($_SESSION['novo_endereco']) && $_SESSION['novo_endereco']['ativo'] == TRUE && empty($_SESSION['novo_endereco']['cep'])){ ?>
	
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('#modal-endereco-alternativo').modal('show');
			}, 1000);
		});
	</script>
<?php } ?>


<?php

$carrinho_obj = new Carrinho();
$frete_obj = new Frete();

$_SESSION['carrinho_ok'] = FALSE;

$_SESSION['novo_endereco'] = (!isset($_SESSION['novo_endereco']))?(NULL):($_SESSION['novo_endereco']);

if(count($_SESSION['carrinho_item']) == 0){ header("Location: {$urlC}"); }

if(Util::isLogged()){

	if(!isset($_SESSION['id_novo_pedido']) or empty($_SESSION['id_novo_pedido']) or $_SESSION['id_novo_pedido'] == 0){
		
		$id_cliente = $_SESSION['cliente_dados']['id'];

		$conn->query("INSERT INTO pedido (id_usuario) VALUES ($id_cliente)");
		$_SESSION['id_novo_pedido'] = $id_novo_pedido = $conn->insert_id;
	}
}
?>

<?php 
/*echo '<pre>';
print_r($_SESSION['carrinho_item']);
echo '</pre>';*/
/*echo '<pre>';
print_r($_SESSION['lista']);
echo '</pre>';*/
?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Carrinho</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
    <div class="container">      
        
        <?php $query_frete = $conn->query("SELECT * FROM frete LIMIT 1"); ?>
        <?php $result_frete = $query_frete->fetch_array(); ?>
        
        <?php if($result_frete['valor_minimo_frete_gratis'] > 0){ ?>
			
			<?php 
			$sub_frete = 0;
			foreach($_SESSION['carrinho_item'] as $var => $carrinho){
				if(isset($carrinho['id'])){
					
					$queryB = $conn->query("SELECT * FROM produto WHERE id = ".$carrinho['id']);
					$resultB = $queryB->fetch_array();
					
					$valor_produto = (isset($carrinho['desconto']) && $carrinho['desconto'] > 0)?(($carrinho['valor_por'] * $carrinho['quantidade']) - number_format(($carrinho['valor_por']) * ($carrinho['desconto'] / 100), 2) * $carrinho['quantidade']):($carrinho['valor_por'] * $carrinho['quantidade']);
					
					$sub_frete += $valor_produto;
				}
			}
			
			$adicione = $result_frete['valor_minimo_frete_gratis'] - $sub_frete;
			?>
			
			<?php if(!isset($_SESSION['lista'])){ ?> 
	        <div class="row">
	            <div class="col-12">
		            <p class="frete-gratis text-center bg-custom text-white">
		            	<?php if($result_frete['valor_minimo_frete_gratis'] > $sub_frete){ ?>
			                Acima de <span class="font-800"><?php echo 'R$ '.Util::fixValor($result_frete['valor_minimo_frete_gratis']); ?></span> o SEU FRETE É <span class="font-800">GRÁTIS!</span><br/>
			                ADICIONE + <span class="font-800"><?php echo 'R$ '.Util::fixValor($adicione); ?></span> EM PRODUTOS NO SEU CARRINHO e ganhe o <span class="font-800">FRETE GRÁTIS!</span>
						<?php }else{ ?>
							<span class="font-800">PARABÉNS!</span> SEU FRETE SERÁ <span class="font-800">GRÁTIS!</span>
						<?php } ?>
					</p>
	            </div>
	        </div>
	        <?php } ?>
	        <br/>
		<?php } ?>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive no-tables col-12 ">
                    <table class="table-carrinho table table-striped">
                        <thead>
                            <tr>
                                <th class="text-uppercase">Produto</th>
                                <th></th>
                                <th class="text-uppercase text-center">Quantidade</th>
                                <th class="text-uppercase text-center text-nowrap">Valor Unit.</th>
                                <th class="text-uppercase text-center">Subtotal</th>
                                <th class="text-uppercase text-center">Remover</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$subtotal = 0;
							$frete_gratis = FALSE;
							
							foreach($_SESSION['carrinho_item'] as $var => $carrinho){

								$query = $conn->query("SELECT * FROM produto WHERE id = {$carrinho['id']} LIMIT 1");
								
								$result = $query->fetch_array();
																	
								$valor_produto = (isset($carrinho['desconto']) && $carrinho['desconto'] > 0)?(($carrinho['valor_por'] * $carrinho['quantidade']) - number_format($carrinho['valor_por'] * ($carrinho['desconto'] / 100), 2) * $carrinho['quantidade']):($carrinho['valor_por'] * $carrinho['quantidade']);
								
								$subtotal += $valor_produto;
								
								$query_var = $conn->query("SELECT * FROM rel_produto_var WHERE id = ".$carrinho['id_rel_produto_var']." LIMIT 1");
								$result_var = $query_var->fetch_array();
								
								$query_processo = $conn->query("SELECT SUM(carrinho.quantidade) AS em_processo
								FROM carrinho
								INNER JOIN pedido ON pedido.id = carrinho.id_pedido
								WHERE carrinho.id_rel_produto_var = ".$carrinho['id_rel_produto_var']." AND pedido.id_status IN(1,2)");
								$em_processo = $query_processo->fetch_array();
								?>
                        
                                <tr>
                                    <td>
                                        <?php $queryG = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = ".$result['id']." AND id_cor = {$carrinho['id_cor']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
										<?php if($queryG->num_rows > 0){ ?>
							                <?php $resultG = $queryG->fetch_array(); ?>
	                                        <figure class="bg-contain bg-p75 bordered bg-white">
	                                            <img src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
	                                        </figure>
										<?php }else{ ?>
	                                        <figure class="bg-contain bg-p75 bordered bg-white">
	                                            <img src="<?php echo $urlC.'assets/images/no-image.png'; ?>"/>
	                                        </figure>
										<?php } ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <p>
                                        	<b class="text-uppercase"><?php echo $result['nome']; ?></b><br/> 
                                        	<?php if($carrinho['id_cor'] > 0){ ?>
												<?php $query_cor = $conn->query("SELECT nome FROM cor WHERE id = ".$carrinho['id_cor']); ?>
												<?php $cor = $query_cor->fetch_array(); ?>
                                            	<b>Cor: </b><?php echo $cor['nome']; ?><br/> 
                                            <?php } ?>
                                            
                                            <?php if($carrinho['id_tamanho'] > 0){ ?>
												<?php $query_tamanho = $conn->query("SELECT nome FROM tamanho WHERE id = ".$carrinho['id_tamanho']); ?>
												<?php $tamanho = $query_tamanho->fetch_array(); ?>
												<b>Tamanho: </b><?php echo $tamanho['nome']; ?><br/>
											<?php } ?>  
						                </p>
						            </td>
                                    <td>
                                    	<?php if(isset($_SESSION['lista'])){ ?>
                                    		<?php $queryPL = $conn->query("SELECT *, (quantidade - vendido) AS disponivel FROM lista_produto WHERE id_lista = {$_SESSION['lista']} AND id_produto = {$result['id']}"); ?>
                                    		<?php $resultPL = $queryPL->fetch_array(); ?>
	                                    	<form method="post" action="<?php echo $urlC.'acao'; ?>">
	                                            <div class="valor text-center">
	                                            	<label class="visible-xs-block visible-sm-block">Quantidade: </label>
	                                            	<input type="text" class="form-control number-spin text-center do-input-qt input-quantidade atualiza-quantidade" name="quantidade" data-stock="<?php echo $resultPL['disponivel']; ?>" value="<?php echo $carrinho['quantidade']; ?>"/>
	                                                <input type="hidden" name="var" value="<?php echo $var; ?>"/>
													<input type="hidden" name="acao" value="atualiza_carrinho"/>
	                                            </div>
	                                        </form>
	                                        <p class="text-center"><small><small style="color: #aaa;" class="center-block"><?php echo $resultPL['disponivel']; ?> disp.</small></small></p>
                                        <?php }else{ ?>
	                                        <form method="post" action="<?php echo $urlC.'acao'; ?>">
	                                            <div class="valor text-center">
	                                            	<label class="visible-xs-block visible-sm-block">Quantidade: </label>
	                                            	<input type="text" class="form-control number-spin text-center do-input-qt input-quantidade atualiza-quantidade" name="quantidade" data-stock="<?php echo ($result_var['estoque'] - $em_processo['em_processo']); ?>" value="<?php echo $carrinho['quantidade']; ?>"/>
	                                                <input type="hidden" name="var" value="<?php echo $var; ?>"/>
													<input type="hidden" name="acao" value="atualiza_carrinho"/>
	                                            </div>
	                                        </form>
                                        	<p class="text-center"><small><small style="color: #aaa;" class="center-block"><?php echo ($result_var['estoque'] - $em_processo['em_processo']) ?> disp.</small></small></p>
                                        <?php } ?>
                                    </td>
                                    <td data-title="Valor Unit.">
                                        <p class="text-center text-color"><?php echo 'R$ '.Util::fixValor($carrinho['valor_por']); ?></p>
                                    </td>
                                    <td data-title="Subtotal">
                                        <p class="text-center text-color"><?php echo 'R$ '.Util::fixValor($valor_produto); ?></p>
                                    </td>
                                    <td>
                                    	<form method="post" action="<?php echo $urlC.'acao'; ?>" class="form-remove-carrinho text-center">
											<input type="hidden" name="acao" value="remove_carrinho"/>
											<input type="hidden" name="var" value="<?php echo $var; ?>"/>
											<button class="remover-produto btn btn-danger btn-xs" type="submit"><i  class="fa fa-trash"></i></button>
										</form>
                                    </td>
                                </tr>  
                            <?php } ?>                              
                        </tbody>
                    </table>
                    <br/>
                </div>
                    
                <?php
				$subtotal_produtos 	= $subtotal;
				
				$checked_atual 	= NULL;
				$checked_novo 	= NULL;
				$onclick_atual 	= NULL;
				$onclick_novo 	= NULL;
							
				if(isset($_SESSION['novo_endereco']) && $_SESSION['novo_endereco']['ativo'] == TRUE){
					
					$onclick_atual = "$('.endereco_ativa').submit();";
					$checked_novo = 'checked';
				}else{
					
					$onclick_novo = "$('.endereco_ativa').submit();";
					$checked_atual = 'checked';
				}
				
				if(isset($_SESSION['cliente_dados']['cep']) && strlen(preg_replace('#[^0-9]#','',strip_tags($_SESSION['cliente_dados']['cep']))) < 8){ ?>
						
					<?php $_SESSION['aviso'] = 'Seu CEP não está preenchido corretamente!<br/>Por favor, corrija para finalizar a compra.'; ?>
					
					<script>
						$(document).ready(function(){
							var urlC = "http://"+document.domain+"/";
							$('#modal-aviso').modal('show');
							$.ajax({url: urlC+'unset_ajax'});
						});
					</script>
				<?php }elseif(isset($_SESSION['cliente_dados']['cep'])){
					
					$peso_total = $carrinho_obj->calculaPesoTotal();
								
					$_SESSION['cep_base']['cep'] = ($_SESSION['novo_endereco']['ativo'] == TRUE && isset($_SESSION['novo_endereco']['cep']))?($_SESSION['novo_endereco']['cep']):($_SESSION['cliente_dados']['cep']);
					
					if($peso_total <= 30){
							
						$valorFreteEN = $frete_obj->calculaFrete($_SESSION['cep_base']['cep'], $peso_total, $subtotal, 'EN');
		            	$valorFreteSD = $frete_obj->calculaFrete($_SESSION['cep_base']['cep'], $peso_total, $subtotal, 'SD');
					}else{
						
						$valorFreteEN = $frete_obj->calculaFrete($_SESSION['cep_base']['cep'], 30, $subtotal, 'EN');
	            		$valorFreteSD = $frete_obj->calculaFrete($_SESSION['cep_base']['cep'], 30, $subtotal, 'SD');
					}
					
					$_SESSION['frete_pac'] = $valorFreteEN = str_replace(',', '.', $valorFreteEN);
		            $_SESSION['frete_sedex'] = $valorFreteSD = str_replace(',', '.', $valorFreteSD);
					?>
					
                    <form method="post" action="<?php echo $urlC.'acao'; ?>">
                    	<?php $_SESSION['frete_pac'] = $valorFreteEN = ($result_frete['valor_minimo_frete_gratis'] > 0 && $subtotal >= $result_frete['valor_minimo_frete_gratis'])?(0):($valorFreteEN); ?>
                    	
						<?php $_SESSION['subtotal'] = $subtotal; ?>
                    	<?php $_SESSION['total_carrinho'] = $subtotal; ?>
						<?php $desconto_real = 0; ?>
						<input type="hidden" name="acao" value="pagamento"/> 
						
							<div class="table-responsive no-tables col-12 ">
								<table class="table-carrinho table table-striped">
		                            <thead>
		                                <tr>
		                                    <th class="text-uppercase">Endereço de Entrega</th>
		                                    <th class="text-uppercase">Frete</th>
		                                    <th class="text-uppercase">Cupom de Desconto</th>
		                                    <th class="text-uppercase text-right">Totais</th>
		                                </tr>
		                            </thead>
		                            <tbody>									
										<tr>
											<td>
									            <h4 class="text-uppercase visible-xs-block visible-sm-block">Endereço de entrega</h4>
									            <?php if($_SESSION['novo_endereco']['ativo'] == FALSE || empty($_SESSION['novo_endereco']['cep'])){ ?>
										            <h5 class="text-uppercase">Endereço Cadastrado</h5>
							                        <p>
							                            <?php echo $_SESSION['cliente_dados']['endereco'].', '.$_SESSION['cliente_dados']['numero']; ?>
							                        
							                            <?php echo $complemento = (!empty($_SESSION['cliente_dados']['complemento']))?(' - '.$_SESSION['cliente_dados']['complemento']):(NULL); ?><br/>
							                            <?php echo 'Bairro '.$_SESSION['cliente_dados']['bairro'].' - '.$_SESSION['cliente_dados']['cidade'].' / '.$_SESSION['cliente_dados']['uf']; ?><br/>
							                           	<?php echo 'CEP: '.$_SESSION['cliente_dados']['cep']; ?>
							                        </p>
									            <?php }else{ ?>
									            	
									            	<h5 class="text-uppercase">Endereço Alternativo</h5>
						                       		<p>
						                       			<?php $novo_complemento = (!empty($_SESSION['novo_endereco']['complemento']))?(' - '.$_SESSION['novo_endereco']['complemento']):(NULL); ?>
						                       			<?php echo $_SESSION['novo_endereco']['endereco'].', '.$_SESSION['novo_endereco']['numero'].$novo_complemento.'<br/> Bairro '.$_SESSION['novo_endereco']['bairro'].' - '.$_SESSION['novo_endereco']['cidade'].' - '.$_SESSION['novo_endereco']['uf'].'<br/>CEP '.$_SESSION['novo_endereco']['cep']; ?>
						                       		</p>
						                       		<p>
						                       			<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-endereco-alternativo" href="#" onclick="<?php echo $onclick_novo; ?>">ALTERAR</a>
						                       		</p>
									            <?php } ?>
									            <br/>
						                       	<div class="radio"> 
						                       		<input type="radio" name="endereco_entrega" id="endereco-atual" value="endereco_atual" <?php echo $checked_atual; ?> onclick="<?php echo $onclick_atual; ?>" required/>
						                       		<label for="endereco-atual">ENTREGAR NO MEU ENDEREÇO CADASTRADO</label>
						                       	</div>
						                        <div class="radio"> 
						                        	<input type="radio" name="endereco_entrega" id="endereco-novo" value="endereco_novo" <?php echo $checked_novo; ?> onclick="<?php echo $onclick_novo; ?>" required/>
						                       		<label for="endereco-novo">ENTREGAR EM OUTRO ENDEREÇO</label>
						                       	</div>
											</td>
											<td>
												<h4 class="text-uppercase visible-xs-block visible-sm-block">Frete</h4>
												<h5 class="text-uppercase">Entrega por</h5>
							                    <div class="radio">
						                            <input type="radio" name="frete" id="frete-pac" value="pac" class="radio-frete" required <?php echo $frete_checked = (!isset($_SESSION['frete_escolhido']) || $_SESSION['frete_escolhido'] == 'pac')?('checked'):(NULL); ?>>
						                            <label for="frete-pac">PAC = <span class="text-color"><?php echo $frete_pac = ($valorFreteEN == 0)?('Frete Grátis'):('R$ '.Util::fixValor($valorFreteEN)); ?></span></label>
							                    </div>
							                    <div class="radio">
							                        <input type="radio" name="frete" id="frete-sedex" value="sedex" class="radio-frete" required <?php echo $frete_checked = (isset($_SESSION['frete_escolhido']) && $_SESSION['frete_escolhido'] == 'sedex')?('checked'):(NULL); ?>>
							                        <label for="frete-sedex">SEDEX = <span class="text-color"><?php echo 'R$ '.Util::fixValor($valorFreteSD); ?></span></label>
							                    </div>
											</td>
											<td>
												<h4 class="text-uppercase visible-xs-block visible-sm-block">Cupom de Desconto</h4>
												<h5 class="text-uppercase">Código</h5>
												<div class="form-group">
													<input type="text" class="form-control codigo-cupom input-upper" placeholder="Código" value="<?php echo $codigo_cupom = (isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE)?($_SESSION['cupom']['codigo']):(NULL); ?>">
												</div>
												<div class="clearfix"></div>
												<div class="label-cupom">
													<p>
														<?php if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){ ?>
															<b class="text-success text-uppercase">Cupom OK!</b><br/>
															Cupom: <span class="text-color"><?php echo $_SESSION['cupom']['nome']; ?></span><br/>
															Desconto: <span class="text-color"><?php echo $desconto_cupom = ($_SESSION['cupom']['tipo'] == 'p')?($_SESSION['cupom']['valor'].'%'):('R$ '.Util::fixValor($_SESSION['cupom']['valor'])); ?></span>
														<?php }else{ ?>
															Possui um cupom de desconto?<br/>
															Informe o código acima!
														<?php } ?>
													</p>
												</div>
											</td>
											<td class="text-right">
											
												<h4 class="text-uppercase visible-xs-block visible-sm-block">Total da compra</h4>
												
												<h5 class="text-uppercase">Total em produtos</h5>
												
												<span class="text-color"><b><?php echo 'R$ '.Util::fixValor($subtotal); ?></b></span>
												
												<?php if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){ ?>
													
													<h5 class="text-uppercase">Desconto</h5>
												
													<?php $desconto_real = ($_SESSION['cupom']['tipo'] == 'r')?($_SESSION['cupom']['valor']):(number_format(($subtotal * ($_SESSION['cupom']['valor'] / 100)), 2, '.', '')); ?>
													<span class="text-color">
														<?php echo $desconto_compra = ($_SESSION['cupom']['tipo'] == 'r')?('R$ '.Util::fixValor($_SESSION['cupom']['valor'])):('<small>('.$_SESSION['cupom']['valor'].'%)</small> R$ '.Util::fixValor($subtotal * ($_SESSION['cupom']['valor'] / 100))); ?>
													</span>
													
												<?php } ?>
												<div class="clearfix"></div>
												<br/>
												<h5 class="text-uppercase">Total + Frete <?php if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){ echo ' + Desconto'; } ?></h5>
												
												<strong class="total-pac text-color <?php echo $frete_display = (!isset($_SESSION['frete_escolhido']) || $_SESSION['frete_escolhido'] == 'pac')?(NULL):('display-none'); ?>"><big><?php echo 'R$ '.Util::fixValor($subtotal + $valorFreteEN - $desconto_real); ?></big></strong>
						                        <strong class="total-sedex text-color <?php echo $frete_display = (isset($_SESSION['frete_escolhido']) && $_SESSION['frete_escolhido'] == 'sedex')?(NULL):('display-none'); ?>"><big><?php echo 'R$ '.Util::fixValor($subtotal + $valorFreteSD - $desconto_real); ?></big></strong>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<div class="container-fluid">
													<div class="row">
														<div class="col-12 ">
		                                                <?php if(Util::isLogged()){ ?>
											            	<?php if($_SESSION['novo_endereco']['ativo'] == TRUE && empty($_SESSION['novo_endereco']['cep'])){ ?>
											            		<a class="open-modal button-carrinho-final pull-right btn btn-success text-uppercase" data-toggle="modal" data-target="#modal-endereco-alternativo">Finalizar</a>
											            	<?php }else{ ?>
												            	<button type="submit" class="pull-right btn btn-custom text-uppercase">Finalizar</button>
											            	<?php } ?>
											            <?php } ?>
		                                                <a href="<?php echo (isset($_SESSION['lista']))?($urlC.'lista?c='.$_SESSION['lista']):($urlC.'produtos'); ?>">
		                                                	<button type="button" class="continuar pull-left btn btn-custom-2 hidden-xs text-uppercase">Continuar comprando</button>
		                                                	<button type="button" class="continuar pull-left btn btn-custom-2 visible-xs-inline-block text-uppercase">Comprar+</button>
		                                            	</a>
		                                            	</div>
	                                            	</div>
	                                            </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
					</form>
                <?php }else{ ?>
                	<div class="col-12 ">
                    	<table class="table-carrinho table table-striped">
                            <tbody>
                            	<tr>
                            		<td>
                            			<div class="container-fluid">
											<div class="row">
												<div class="col-12 ">
		                                			<a class="open-modal button-carrinho-final pull-right btn btn-custom text-uppercase" data-toggle="modal" data-target="#modal-login">Finalizar</a>
		                                            <a href="<?php echo (isset($_SESSION['lista']))?($urlC.'lista?c='.$_SESSION['lista']):($urlC.'produtos'); ?>">
		                                            	<button class="continuar btn btn-custom-2 hidden-xs text-uppercase">Continuar comprando</button>
		                                            	<button class="continuar btn btn-custom-2 visible-xs-inline-block text-uppercase">Comprar+</button>
		                                            </a>
		                                        </div>
		                                    </div>
		                                </div>
                            		</td>
                            	</tr>
						    </tbody>
						</table>
					</div>
                <?php } ?>
                <form method="post" action="<?php echo $urlC.'acao'; ?>" class="endereco_ativa">
					<input type="hidden" name="acao" value="ativa_endereco"/>
				</form>
            </div>
        </div>      
    </div>
</section>

<?php if(Util::isLogged()){ ?>
<div class="modal fade modal-form" id="modal-endereco-alternativo" role="dialog">

	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<p class="h5">Informar outro endereço</p>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form action="<?php echo $urlC.'acao'; ?>" method="post" class="form-prevent">                       
						<div class="row">		
							<div class="col-12">
								<div class="form-group">
									<select name="uf" class="form-control uf-select" required>
										<?php if(!empty($_SESSION['novo_endereco']['uf'])){ ?>
										<?php $novo_uf = $_SESSION['novo_endereco']['uf']; ?>
										<option value="<?php echo $_SESSION['novo_endereco']['uf']; ?>"><?php echo $_SESSION['novo_endereco']['uf']; ?></option>
										<?php }else{ ?>
										<option value="">Estado...</option>
										<?php $novo_uf = ''; ?>
										<?php } ?>
										
										<?php
										$consulta = $conn->query("SELECT * FROM estado WHERE uf != '{$novo_uf}' ORDER BY uf");
										while($result = $consulta->fetch_array()){ ?>
										
											<option value="<?php echo $result['uf']; ?>" ><?php echo $result['uf']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>                       
							<div class="col-12 ">
								<?php $inputHide = ($_SESSION['novo_endereco']['ativo'] == TRUE)?(NULL):('hidden'); ?>
								<div class="form-group">
									<input type="text" name="cep" data-id-cep="3" class="form-control cep-mask <?php echo $inputHide; ?>" placeholder="CEP*" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['cep']))?($_SESSION['novo_endereco']['cep']):(NULL); ?>" required>
								</div>
								<div class="form-group">
									<input type="text" name="cidade" data-id-cidade="3" class="form-control cidade-mask <?php echo $inputHide; ?>" placeholder="Cidade*" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['cidade']))?($_SESSION['novo_endereco']['cidade']):(NULL); ?>" required>
								</div>
								<div class="form-group">
									<input type="text" name="endereco" data-id-endereco="3" class="form-control <?php echo $inputHide; ?>" placeholder="Endereço*" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['endereco']))?($_SESSION['novo_endereco']['endereco']):(NULL); ?>" required>
								</div>
								<div class="form-group">
									<input type="text" name="bairro" data-id-bairro="3" class="form-control <?php echo $inputHide; ?>" placeholder="Bairro*" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['bairro']))?($_SESSION['novo_endereco']['bairro']):(NULL); ?>" required>
								</div>
								<div class="form-group">
									<input type="text" name="numero" data-id-numero="3" class="form-control <?php echo $inputHide; ?>" placeholder="Número*" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['numero']))?($_SESSION['novo_endereco']['numero']):(NULL); ?>" required>
								</div>
								<div class="form-group">
									<input type="text" name="complemento" class="form-control <?php echo $inputHide; ?>" placeholder="Complemento (opcional)" value="<?php echo $value =(!empty($_SESSION['novo_endereco']['complemento']))?($_SESSION['novo_endereco']['complemento']):(NULL); ?>">
								</div>
							</div>
							<div class="col-12">
								<div class="radio">
									<input type="radio" name="definicao" value="entrega_atual" id="entrega-atual" <?php echo $checked = (!empty($_SESSION['novo_endereco']['definicao']) && $_SESSION['novo_endereco']['definicao'] != 'entrega_geral')?('checked'):(NULL); ?> required/>
									<label for="entrega-atual">Definir apenas para esta compra</label>
								</div>
							</div>
							<div class="col-12">
								<div class="radio">
									<input type="radio" name="definicao" value="entrega_geral" id="entrega-geral" <?php echo $checked = (!empty($_SESSION['novo_endereco']['definicao']) && $_SESSION['novo_endereco']['definicao'] == 'entrega_geral')?('checked'):(NULL); ?> required/>
									<label for="entrega-geral">Definir para as próximas compras</label>
								</div>
							</div>
							<div class="col-12 ">
								<input type="hidden" name="acao" value="novo_endereco"/>
								<button type="submit" class="btn btn-custom pull-right">Salvar</button>
							</div>
						</div>
					</form>
				</div>		
			</div>
		</div>
	</div>
</div>
<?php } ?>

