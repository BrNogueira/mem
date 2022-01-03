<?php

if($paymentMethod == 'eft'){
	
	$bankName = $_POST['bankName'];
	
	$request['bankName'] = $bankName;	
}elseif($paymentMethod == 'creditCard'){
	
	$token 		= $_POST['token'];
	$phone 		= str_replace('(','', str_replace(')','',$_POST['holderPhone']));
	$phone 		= explode(' ', $phone);
	$ddd 		= $phone[0];
	$telefone 	= Util::apenasNumeros($phone[1]);
	
	$request['creditCardToken'] = $token;
	$request['installmentQuantity'] = $_POST['installmentQuantity'];
	$request['installmentValue'] = number_format($_POST['installmentValue'], 2, '.', '');
	$request['noInterestInstallmentQuantity'] = $_SESSION['max_sem_juros'];
	$request['creditCardHolderName'] = $_POST['creditCardHolderName'];
	$request['creditCardHolderCPF'] = Util::apenasNumeros($_POST['creditCardHolderCPF']);
	$request['creditCardHolderBirthDate'] = $_POST['creditCardHolderBirthDate'];
	$request['creditCardHolderAreaCode'] = $ddd;
	$request['creditCardHolderPhone'] = $telefone;
	$request['billingAddressStreet'] = $_POST['billingAddressStreet'];
	$request['billingAddressNumber'] = $_POST['billingAddressNumber'];
	$request['billingAddressComplement'] = $_POST['billingAddressComplement'];
	$request['billingAddressDistrict'] = $_POST['billingAddressDistrict'];
	$request['billingAddressPostalCode'] = Util::apenasNumeros($_POST['billingAddressPostalCode']);
	$request['billingAddressCity'] = $_POST['billingAddressCity'];
	$request['billingAddressState'] = $_POST['billingAddressState'];
	$request['billingAddressCountry'] = 'BRA';
}

?>