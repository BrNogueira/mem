<?php
require 'vendor/autoload.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;

use Cielo\API30\Ecommerce\Request\CieloRequestException;
// ...
// Configure o ambiente
$environment = $environment = Environment::sandbox();
//$environment = $environment = Environment::production();

// Configure seu merchant
$merchant = new Merchant('853c04c6-ca37-4e7f-ae9a-4151b459a843', 'GSPBREAACKBTFCQBQHXEXYIGDGWOIFRENNPJGUVU');

$id_novo_pedido = $_SESSION['id_novo_pedido'];
// Crie uma instância de Sale informando o ID do pedido na loja
$sale = new Sale($id_novo_pedido);

$complemento = (!empty($_SESSION['cliente_dados']['complemento']))?(' - '.$_SESSION['cliente_dados']['complemento']):(NULL);
// Crie uma instância de Customer informando o nome do cliente,
// documento e seu endereço
$customer = $sale->customer($_SESSION['cliente_dados']['nome'].' '.$_SESSION['cliente_dados']['sobrenome'])
                  ->setIdentity($_SESSION['cliente_dados']['cpf'])
                  ->setIdentityType('CPF')
                  ->address()->setZipCode(Util::apenasNumeros($_SESSION['cliente_dados']['cep']))
                             ->setCountry('BRA')
                             ->setState($_SESSION['cliente_dados']['uf'])
                             ->setCity($_SESSION['cliente_dados']['cidade'])
                             ->setDistrict($_SESSION['cliente_dados']['bairro'])
                             ->setStreet($_SESSION['cliente_dados']['endereco'].$complemento)
                             ->setNumber($_SESSION['cliente_dados']['numero']);

// Crie uma instância de Payment informando o valor do pagamento
$payment = $sale->payment(number_format($_SESSION['valor_total'], 2, '', ''))
                ->setType(Payment::PAYMENTTYPE_BOLETO)
                ->setAddress('Rua de Teste')
                ->setBoletoNumber('1234')
                ->setAssignor('Modacasa')
                ->setDemonstrative('Desmonstrative Teste')
                ->setExpirationDate(date('d/m/Y', strtotime('+1 month')))
                ->setIdentification('11884926754')
                ->setInstructions('Instruções');

// Crie o pagamento na Cielo
try {
    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
    // dados retornados pela Cielo
    $paymentId = $sale->getPayment()->getPaymentId();
    $boletoURL = $sale->getPayment()->getUrl();
} catch (CieloRequestException $e) {
    // Em caso de erros de integração, podemos tratar o erro aqui.
    // os códigos de erro estão todos disponíveis no manual de integração.
    $error = $e->getCieloError();
}
?>