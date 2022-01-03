
<?php $_SESSION['parcelamento'] = $parcelamento = $_POST['retorno']; ?>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-5">
		<div class="form-group">
			<label for="cardNumber">Escolha uma forma de parcelamento:</label>
			<select name="parcelamento" class="form-control select-parcelamento" required>
				<option value="">...selecione a quantidade de parcelas</option>
				<?php $cont = 0; ?>
				<?php foreach($parcelamento['installments'] as $var => $item_parcelamento){ ?>
					<?php foreach($item_parcelamento as $var2 => $parcelas){ ?>
						<?php $sem_juros = ($parcelas['interestFree'] == 'true')?('s/ juros'):('c/ juros'); ?>
						<?php $cont++; ?>
						<?php if($cont <= 12){ ?>
							<option value="<?php echo $var.'-'.$var2; ?>" data-valor-final="<?php echo 'R$&nbsp;'.Util::fixValor($parcelas['totalAmount']); ?>">
								<?php echo $parcelas['quantity'].'x de R$&nbsp;'.Util::fixValor($parcelas['installmentAmount']).' '.$sem_juros.' = R$&nbsp;'.Util::fixValor($parcelas['totalAmount']); ?>
							</option>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
</div>

<script>
	$('select[name="parcelamento"]').change(function(e){
		
		var valor = $('option:selected', this).data('valor-final');
		
		$('.valor-final').html(valor).effect('pulsate', {times:3}, 1000);
	});
</script>