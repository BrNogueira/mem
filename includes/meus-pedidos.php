
<?php if(!Util::isLogged()){ header('Location:'.$urlC); } ?>
<?php $id = (isset($_GET['c']) && is_numeric($_GET['c']))?($_GET['c']):(FALSE); ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Meus Pedidos</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
    <div class="container">
        <div class="row">
        
        	<?php if(isset($id) && is_numeric($id)){ ?>
        		
        		<?php $query0 = $conn->query("SELECT * FROM pedido WHERE id = {$id}"); ?>
        		<?php $result0 = $query0->fetch_array(); ?>
        		
                <div class="col-12">
                    
                    <h3 class="text-uppercase">Pedido nº: <span class="text-color">#<?php echo $id; ?></span></h3>	
                    <a href="<?php echo $urlC.'meus-pedidos'; ?>" class="pull-right btn btn-default btn-xs">&laquo; voltar</a>
                    <div class="clearfix"></div>
                    <br/>
                </div>
                <div class="col-12">
                    <div class="table-responsive no-tables">
                        <table class="table-pedido table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Forma de Pagamento</th>
                                    <?php if($result0['forma_pagamento'] == 'credito'){ ?>
                                    <th class="text-uppercase text-center">Parcelamento</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody> 
                            	<tr>
                                    <td data-title="Forma de Pag.">
                                        <p>
                                        	<?php echo ($result0['forma_pagamento'] == 'boleto')?('Boleto'):('Cartão de Crédito'); ?>
                                        	<?php if($result0['forma_pagamento'] == 'boleto'){ ?>
                                        		&nbsp;&nbsp;&nbsp;<a href="<?php echo $result0['boleto_link']; ?>" class="btn btn-sm btn-default" target="_blank"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Visualizar Boleto</a>
                                        	<?php } ?>
                                        </p>
                                    </td>
                                    <?php if($result0['forma_pagamento'] == 'credito'){ ?>
                                    <td data-title="Parcelamento">
                                        <p class="text-center"><?php echo $result0['parcelamento'].'x'; ?> <?php echo ($result0['juros'] == 't')?('com juros'):('sem juros'); ?></p>
                                    </td>
                                    <?php } ?>
                                </tr>   
                            </tbody>
                        </table>
                    </div> 
                    <div class="table-responsive no-tables">
                        <table class="table-pedido table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Produto</th>
                                    <th class="text-uppercase">Detalhes</th>
                                    <th class="text-uppercase text-center">Quantidade</th>
                                    <th class="text-uppercase text-center text-nowrap">Valor Unit.</th>
                                    <th class="text-uppercase text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query = $conn->query("SELECT * FROM carrinho WHERE id_pedido = {$id}"); ?>
								<?php while($result = $query->fetch_array()){ ?>
                                    <tr>
                                        <td class="text-nowrap">
                                            <p>
                                            	<b class="text-uppercase"><?php echo $result['nome_produto']; ?></b>
                                            	<?php if(!empty($result['referencia'])){ ?>
	                                            	<br/>
									                <b>Referência:</b> <?php echo $result['referencia']; ?>
								                <?php } ?>
							                </p>
							            </td>
                                        <td class="text-nowrap">
                                        	<p>
	                                        	<?php if(!empty($result['cor'])){ ?>
	                                        		<b>Cor:</b> <?php echo $result['cor']; ?>
	                                        	<?php } ?> 
	                                        	<?php if(!empty($result['tamanho'])){ ?>
	                                        		<br/>
	                                        		<b>Tamanho:</b> <?php echo $result['tamanho']; ?>
	                                        	<?php } ?> 
	                                        	<?php if(!empty($result['voltagem'])){ ?>
	                                        		<br/>
	                                        		<b>Voltagem:</b> <?php echo $result['voltagem']; ?>
	                                        	<?php } ?> 
											</p>
                                        </td>
                                        <td data-title="Quantidade">
                                        	<p class="text-center">
                                        		<?php echo $result['quantidade']; ?>
                                        	</p>
                                        </td>
                                        <td data-title="Valor Unit.">
                                            <p class="text-center"><?php echo 'R$ '.Util::fixValor($result['valor_corrente']); ?></p>
                                        </td>
                                        <td data-title="Subtotal">
                                            <p class="text-center"><?php echo 'R$ '.Util::fixValor($result['valor_total']); ?></p>
                                        </td>
                                    </tr>
                            	<?php } ?>     
                            </tbody>
                        </table>
                    </div>
            	</div>
			<?php }else{ ?>
					
				<div class="col-12 tabela-meus-pedidos">
				
                	<h3 class="text-uppercase">Meus Pedidos</h3>
                	<div class="clearfix"></div>
                    <br/>
                    <div class="table-responsive no-tables">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Pedido</th>
                                    <th class="text-uppercase text-center">Data</th>
                                    <th class="text-uppercase text-center">Produtos</th>
                                    <th class="text-uppercase text-center">Frete</th>
                                    <th class="text-uppercase text-center">Desconto</th>
                                    <th class="text-uppercase text-center">Total</th>
                                    <th class="text-uppercase text-center">Pagamento</th>
                                    <th class="text-uppercase text-center">Status</th>
                                    <th class="text-uppercase text-center">Situação e Rastreio</th>
                                    <th class="text-uppercase text-center">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
					        	$select_fields	= 'pedido.*, status.nome AS status';			
								$select_table	= 'pedido';	
								$select_join	= 'INNER JOIN status ON status.id = pedido.id_status';			
								$select_where	= "WHERE pedido.valor_total > 0 AND pedido.id_usuario = ".$_SESSION['cliente_dados']['id'];
								$select_group	= '';
								$select_order	= 'ORDER BY pedido.id DESC';
								$select_limit	= '';
								$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
								
								while($result = $consulta->fetch_array()){ ?>
                            		
                            		<?php
									$color = NULL;
									switch($result['id_status']){
										case 1: $color.= 'color:#517091;'; break;
										case 2: $color.= 'color:#0d3eff;'; break;
										case 3: $color.= 'color:#508642;'; break;
										case 4: $color.= 'color:#385e2f;'; break;
										case 5: $color.= 'color:#f58b2c;'; break;
										case 6: $color.= 'color:#9f9f4d;'; break;
										case 7: $color.= 'color:#de4145;'; break;
										case 8: $color.= 'color:#696969;'; break;
										default: $color.= 'color:#555555;';
									}
									?>
									
                            		<?php 
									$desconto_real = 0;
									if(!empty($result['cupom_codigo'])){
										
										$desconto_real = ($result['cupom_tipo'] == 'r')?($result['cupom_valor']):(($result['valor_total'] - $result['valor_entrega']) * ($result['cupom_valor'] / 100));
									}			
									
									$queryC = $conn->query("SELECT SUM(valor_total) AS total_carrinho FROM carrinho WHERE id_pedido = {$result['id']}");
									$resultC = $queryC->fetch_array();			
									?>
					
                                    <tr>
                                        <td data-title="Pedido">
											<p><b class="text-color"><?php echo '#'.$result['id']; ?></b></p>
                                        </td>
                                        <td data-title="Data">
                                        	<p class="text-center"><?php echo $result['data_hora']; ?></p>
                                        </td>
	                                    <td data-title="Produtos">
	                                        <p class="text-center"><?php echo 'R$ '.Util::fixValor($resultC['total_carrinho']); ?></p>
	                                    </td>
	                                    <td data-title="Frete">
	                                        <p class="text-center"><?php echo ($result['valor_entrega'] > 0)?('R$ '.Util::fixValor($result['valor_entrega'])):('Grátis'); ?></p>
	                                    </td>
                                        <td data-title="Desconto">
                                        	<p class="text-center">
                                        		<?php if(!empty($result['cupom_codigo'])){ ?>
													<?php echo $desconto_compra = ($result['cupom_tipo'] == 'r')?('R$ '.Util::fixValor($result['cupom_valor'])):('<small>('.$result['cupom_valor'].'%)</small> R$ '.Util::fixValor($resultC['total_carrinho'] * ($result['cupom_valor'] / 100))); ?>
												<?php }else{ echo '-'; } ?>
                                        	</p>
                                        </td>
                                        <td data-title="Total">
                                        	<p class="text-center"><b><?php echo 'R$ '.Util::fixValor($result['valor_total']); ?></b></p>
                                        </td>
                                        <td data-title="Total">
                                        	<p class="text-center"><?php echo ($result['forma_pagamento'] == 'credito')?($result['parcelamento'].'x '.(($result['juros'] == 't')?('c/ juros'):('s/ juros'))):('Boleto'); ?></p>
                                        </td>
                                        <td data-title="Status">
                                        	<p class="text-center" style="<?php echo $color; ?>"><?php echo $result['status']; ?></p>
                                        </td>
                                        <td data-title="Situação">
                                        	<p class="text-center">
                                        		<?php echo (!empty($result['observacao']))?($result['observacao']):('-'); ?>
                                        	</p>
                                        </td>
                                        <td data-title="Visualizar">
                                        	<p class="text-center"><a href="<?php echo $urlC.$pagina.'?c='.$result['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-shopping-basket"></i></a></p>
                                        </td>
                                    </tr>
                            	<?php } ?>     
                            </tbody>
                        </table>
                    </div>
            	</div>
			<?php } ?>
		</div>      
	</div>
</section>