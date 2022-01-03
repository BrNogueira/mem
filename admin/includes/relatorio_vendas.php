
<span data-active="relatorio-vendas"></span>

<?php if(isset($_SESSION['login'])){
	
	$titulo = 'Relatório de Vendas';
	
	$update_table = 'pedido';
	
	$where = 'WHERE pedido.valor_total > 0';
			
	$select_fields	= 'pedido.*, usuario.nome as nome, usuario.sobrenome as sobrenome, status.nome as status';
	$select_table	= 'pedido';	
	$select_join	= 'INNER JOIN usuario ON usuario.id = pedido.id_usuario 
						INNER JOIN status ON status.id = pedido.id_status';	
	$select_where	= $where;
	$select_group	= 'GROUP BY pedido.id';
	$select_order	= 'ORDER BY pedido.id DESC';
	
	$select_limit 	= "";
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            <?php echo $titulo; ?>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                <?php echo $titulo; ?>
	            </li>
	        </ol>
	    </div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
						<th class="p5">Código</th>
			            <th>Cliente</th>
						<th>Data</th>
						<th>Total</th>
						<th>Desconto</th>
						<th>Forma pagamento</th>
						<th class="p5 nowrap">Ver Pedido</th>
						<th>Status</th>
						<th class="p5">Situação e Rastreio</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<?php
						$queryC = $conn->query("SELECT SUM(valor_total) AS total_carrinho FROM carrinho WHERE id_pedido = {$result['id']}");
						$resultC = $queryC->fetch_array();
						
						$background = NULL;
						
						switch($result['id_status']){
							case 1: $background.= 'background-color:#cbd6e2;';
							break;
							case 2: $background.= 'background-color:#ced8ff;';
							break;
							case 3: $background.= 'background-color:#6fb05e;';
							break;
							case 4: $background.= 'background-color:#6fb05e;';
							break;
							case 5: $background.= 'background-color:#fbcda4;';
							break;
							case 6: $background.= 'background-color:#d8d8ad;';
							break;
							case 7: $background.= 'background-color:#f1adaf;';
							break;
							case 8: $background.= 'background-color:#eeeeee;';
							break;
							default: $background.= 'background-color:#ffffff;';
						}
						?>
						
						<?php 
						$desconto_real = 0;
						if(!empty($result['cupom_codigo'])){
							
							$desconto_real = ($result['cupom_tipo'] == 'r')?($result['cupom_valor']):(($result['valor_total'] - $result['valor_entrega']) * ($result['cupom_valor'] / 100));
						}						
						?>
						
						<tr>
							<td><?php echo $result['id']; ?></td>								
							<td class="text-left"><?php echo $result['nome'].' '.$result['sobrenome']; ?></td>								
							<td class="nowrap"><?php echo $result['data_hora']; ?></td>
							<td class="nowrap"><?php echo 'R$ '.Util::fixValor($result['valor_total']); ?></td>
							<td class="nowrap">
								<?php if(!empty($result['cupom_codigo'])){ ?>
									<?php echo $desconto_compra = ($result['cupom_tipo'] == 'r')?('R$ '.Util::fixValor($result['cupom_valor'])):('<small>('.$result['cupom_valor'].'%)</small> R$ '.Util::fixValor(($resultC['total_carrinho']) * ($result['cupom_valor'] / 100))); ?>
								<?php }else{ echo '-'; } ?>
							</td>
							<td class="nowrap">
								<?php echo ($result['forma_pagamento'] == 'boleto')?('Boleto'):('Cartão de Crédito'); ?>		
							</td>
				            <td>
				                <a href="<?php echo $urlC.'relatorio_detalhe/'.$result['id']; ?>" target="_blank">
				                    <i class="fa fa-clipboard"></i>
				                </a>
				            </td>
				            <td class="text-center">
								<button class="btn btn-sm" style="cursor: default; margin-top: -5px; font-weight: bold; <?php echo $background; ?>"><?php echo $result['status']; ?></button>
							</td>
				            <td>
				                <a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-info-'.$result['id']; ?>" href="#">
				                    <i class="fa fa-truck"></i>
				                </a>
				            </td>
						</tr>
					<?php } ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
	<?php $consulta->data_seek(0); ?>
	<?php while($result = $consulta->fetch_array()){ ?>
	<div id="<?php echo 'modal-info-'.$result['id']; ?>" class="modal fade" role="dialog">

		<div class="modal-dialog">
			<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title h2-titulo-section">Situação e Código de Rastreio</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form enctype="multipart/form-data" action="<?php echo $urlC.'acao'; ?>" method="post">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
						        	<label>Situação</label>
						            <input type="text" name="observacao" class="form-control" value="<?php echo $result['observacao']; ?>" required/>
						        </div>
					        </div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
						        	<label>Cód. Rastreio (opcional)</label>
						            <input type="text" name="codigo_rastreamento" class="form-control" value="<?php echo $result['codigo_rastreamento']; ?>"/>
						        </div>
					        </div>
							<div class="col-xs-12 col-sm-6">
						        <div class="form-group">
									<input type="checkbox" name="notificado_atualizacao_pedido" value="t"/> Enviar ao cliente por e-mail?
								</div>
						    </div>
					        <div class="col-xs-12">
						        <div class="form-group">
									<input type="hidden" name="tabela" value="<?php echo $update_table; ?>" required/> 
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>" required/>     
									<input type="hidden" name="acao" value="update"/>
									<input type="submit" value="Gravar" class="btn btn-info"/>
								</div>
							</div>
						</form>                        
					</div>
					<?php 
					$select_fields7	= '*';			
					$select_table7	= 'historico_pedido_andamento';	
					$select_join7	= '';			
					$select_where7	= 'WHERE id_pedido = '.$result['id'];
					$select_group7	= '';
					$select_order7	= 'ORDER BY data_hora DESC';
					$select_limit7	= '';
					$consulta7 = $select->selectDefault($select_fields7, $select_table7, $select_join7, $select_where7, $select_group7, $select_order7, $select_limit7);	
					
					if($consulta7->num_rows > 0){ ?>
					<hr />
					<div class="row">                            
						<div class="col-xs-12">
							
							<h4 class="modal-title h2-titulo-section">Histórico</h4>
							
							<hr />
							
							<?php while($result7 = $consulta7->fetch_array()){
									
								$notificado = ($result7['notificado'] == 't')?('FOI'):('NÃO FOI');
								?>
							
								<p>
									<small>
										<b><?php echo Util::fixDataHora($result7['data_hora']); ?></b><br/>
										As informações do pedido <b><?php echo $result['id']; ?></b> foram alteradas. O cliente <b><?php echo $notificado; ?></b> notificado!
									</small>
								</p>
							<?php } ?>
						</div>                            
					</div>
					<?php } ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
<?php }else{

	header("location:".$urlC."login");
} ?>