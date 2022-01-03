<?php

$base_domain = ($config['pagseguro_ambiente'] == 'p')?('pagseguro.uol.com.br'):('sandbox.pagseguro.uol.com.br');

$url = 'https://ws.'.$base_domain.'/v2/sessions';

$request['email'] = $config['pagseguro_email'];
$request['token'] = $config['pagseguro_token'];

$request = http_build_query($request);
 
$curl = curl_init($url);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

$xml = curl_exec($curl);

curl_close($curl);
 
$xml = simplexml_load_string($xml);

?>

<?php if(isset($xml->id) && !empty($xml->id)){ ?>
	<?php $id_sessao_checkout = $xml->id; ?>
	<script type="text/javascript">
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
		PagSeguroDirectPayment.setSessionId('<?php echo $id_sessao_checkout ?>');
		
		PagSeguroDirectPayment.getPaymentMethods({
			amount: "<?php echo $_SESSION['valor_total'] ?>",
			success:function(response){
				
				var dir 	= window.location.href.split('/');
				var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
				$.ajax({
					type: 'POST',
					url: urlC+'checkout_metodos_ajax',
					data: {
						retorno: response
					},
				    success: function(data){
						$('.metodos-pagamento').html(data);
				    },
					beforeSend: function(){
						$('.loader').fadeIn(100);
					},
					complete: function(){
						$('.loader').fadeOut(100);
					}
				});
			},
			error:function(response){
				//tratamento do erro
			},
			complete:function(response){
				//tratamento comum para todas chamadas
			}
		});
	</script>
<?php } ?>