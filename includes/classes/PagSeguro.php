<?php 
	
class PagSeguro extends Db {
			
	public static function iniciaPagamentoAction() { //gera o código de sessão obrigatório para gerar identificador (hash)
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data['token'] = TOKEN;

		//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = EMAIL;

		$data = http_build_query($data);
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/v2/sessions';

		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml = simplexml_load_string($xml);
		$idSessao = $xml -> id;
		echo $idSessao;
		exit;
	}

	public static function efetuaPagamentoCartao($dados) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data = $dados;
		
		$data['token'] = TOKEN; //token sandbox ou produção
		$data['paymentMode'] = 'default';
		$data['paymentMethod'] = 'creditCard';
		$data['receiverEmail'] = EMAIL;
		$data['noInterestInstallmentQuantity'] = $_SESSION['max_sem_juros'];
		$data['billingAddressCountry'] = 'Brasil';
		$data['currency'] = 'BRL';

		//$data['shippingAddressRequired'] = 'false';
		
		//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = EMAIL;

		$data = http_build_query($data);
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/v2/transactions';


		$curl = curl_init($url);

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1');

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);
		
		$arquivo = fopen('log/'.date('Y-m-d_H-i-s').'.txt','w');
		$texto = $xml;
		fwrite($arquivo, $texto);
		fclose($arquivo);

		curl_close($curl);
		
		$xml = simplexml_load_string($xml);

		$code =  $xml -> code;
		$date =  $xml -> date;
		
		$retornoCartao = array(
			'code' => $code,
			'date' => $date
		);

		return $xml;
	}

	public static function efetuaPagamentoBoleto($dados) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data = $dados;
		
		$data['token'] = TOKEN;
		$data['paymentMode'] = 'default';
		$data['paymentMethod'] = 'boleto';
		$data['currency'] = 'BRL';
		//$data['shippingAddressRequired'] = 'false';
		$data['receiverEmail'] = EMAIL;

				//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = EMAIL;

		$data = http_build_query($data);
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/v2/transactions';


		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml= simplexml_load_string($xml);

		$boletoLink =  $xml -> paymentLink;
		$code =  $xml -> code;
		$date =  $xml -> date;
		
		$retornoBoleto = array(
			'paymentLink' => $boletoLink,
			'date' => $date,
			'code' => $code
		);

		return $retornoBoleto;
	}

	public static function efetuaAssinaturaBoleto($dados) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data = $dados;
		
		$data['token'] = TOKEN;
		$data['paymentMode'] = 'default';
		$data['paymentMethod'] = 'boleto';
		$data['currency'] = 'BRL';
		$data['shippingAddressRequired'] = 'false';
		$data['receiverEmail'] = EMAIL;

				//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = EMAIL;

		$data = http_build_query($data);
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/v2/transactions';


		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml= simplexml_load_string($xml);

		$boletoLink =  $xml -> paymentLink;
		$code =  $xml -> code;
		$date =  $xml -> date;
		
		$retornoBoleto = array(
			'paymentLink' => $boletoLink,
			'date' => $date,
			'code' => $code
		);

		return $retornoBoleto;
	}
	
	public static function assinaPlano($dados) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data = array(
			'plan' => $dados['plano'],
			'sender' => array(
				'name' => $dados['senderName'],
				'email' => $dados['senderEmail'],
				'hash' => $dados['senderHash'],
				'phone' => array(
					'areaCode' => $dados['senderAreaCode'],
					'number' => $dados['senderPhone']
				),
				'address' => array(
					'street' => $dados['addressStreet'],
					'number' => $dados['addressNumber'],
					'complement' => $dados['addressComplement'],
					'district' => $dados['addressDistrict'],
					'city' => $dados['addressCity'],
					'state' => $dados['addressState'],
					'country' => 'BRA',
					'postalCode' => $dados['addressPostalCode']
				),
				'documents' => array(
					array(
						'type' => 'CPF',
						'value' => $dados['senderCPF']
					)
				)
			),
			'paymentMethod' => array(
				'type' => 'CREDITCARD',
				'creditCard' => array(
					'token' => $dados['creditCardToken'],
					'holder' => array(
						'name' => $dados['creditCardHolderName'],
						'birthDate' => $dados['creditCardHolderBirthDate'],
						'documents' => array(
							array(
								'type' => 'CPF',
								'value' => $dados['creditCardHolderCPF']
							)
						),
						'phone' => array(
							'areaCode' => $dados['creditCardHolderAreaCode'],
							'number' => $dados['creditCardHolderPhone']
						),
						'billingAddress' => array(
							'street' => $dados['billingAddressStreet'],
							'number' => $dados['billingAddressNumber'],
							'complement' => $dados['billingAddressComplement'],
							'district' => $dados['billingAddressDistrict'],
							'city' => $dados['billingAddressCity'],
							'state' => $dados['billingAddressState'],
							'country' => 'BRA',
							'postalCode' => $dados['billingAddressPostalCode']
						)
					)
				)
			)
		);
				
		$data = json_encode($data);
				
		$emailPagseguro = EMAIL;
		$tokenPagseguro = TOKEN;
		
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/pre-approvals';
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		
			CURLOPT_URL => $url."?email=".$emailPagseguro."&token=".$tokenPagseguro,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Accept: application/vnd.pagseguro.com.br.v1+json;charset=ISO-8859-1"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		return json_decode($response);
	}
	
	public static function consultaAssinatura($codigo) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data['code'] = $codigo;
				
		$emailPagseguro = EMAIL;
		$tokenPagseguro = TOKEN;
		
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/pre-approvals/'.$data['code'];
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		
			CURLOPT_URL => $url."?email=".$emailPagseguro."&token=".$tokenPagseguro,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		return json_decode($response);
	}
	
	public static function cancelaAssinatura($codigo) {
		
		$conn = Db::connect();
		
		$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
		$config = $query_config->fetch_array();

		define('AMBIENTE',$config['pagseguro_ambiente']);
		define('SECAO',((AMBIENTE == 'p')?('.'):('.sandbox.')));
		define('EMAIL',$config['pagseguro_email']);
		define('TOKEN',$config['pagseguro_token']);
		
		$data['code'] = $codigo;
				
		$emailPagseguro = EMAIL;
		$tokenPagseguro = TOKEN;
		
		$url = 'https://ws'.SECAO.'pagseguro.uol.com.br/pre-approvals/'.$data['code'].'/cancel';
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		
			CURLOPT_URL => $url."?email=".$emailPagseguro."&token=".$tokenPagseguro,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		return json_decode($response);
	}
}

?>