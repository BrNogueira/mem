<?php

$acao = FALSE;

switch($_POST['acao']){
	
	case 'send'					: include('acoes/send.php');				break;
	case 'delete'				: include('acoes/delete.php');				break;
	case 'update'				: include('acoes/update.php');				break;
	case 'insert'				: include('acoes/insert.php');				break;
	case 'cadastro'				: include('acoes/cadastra.php');			break;
	case 'login'				: include('acoes/login.php');				break;
	case 'cep_simulacao'		: include('acoes/cep_simulacao.php');		break;
	case 'novo_endereco'		: include('acoes/novo_endereco.php');		break;
	case 'ativa_endereco'		: include('acoes/ativa_endereco.php');		break;
	case 'contrato'				: include('acoes/contrato.php');			break;
	case 'add_carrinho'			: include('acoes/add_carrinho.php');		break;
	case 'remove_carrinho'		: include('acoes/remove_carrinho.php');		break;
	case 'atualiza_carrinho'	: include('acoes/atualiza_carrinho.php');	break;
	case 'fecha_pedido'			: include('acoes/fecha_pedido.php');		break;
	case 'pass'					: include('acoes/pass.php');				break;
	case 'avaliacao'			: include('acoes/avaliacao.php');			break;
	case 'mural'				: include('acoes/mural.php');				break;
	case 'efetuar_pagamento'	: include('acoes/efetuar_pagamento.php');	break;
	case 'cupom'				: include('acoes/cupom.php');				break;
	case 'add_produto'			: include('acoes/add_produto.php');			break;
	case 'remove_produto_lista'	: include('acoes/remove_produto_lista.php');break;
	case 'remove_lista'			: include('acoes/remove_lista.php');		break;
	case 'pagamento'			: include('acoes/pagamento.php');			break;
	case 'avaliacao'			: include('acoes/avaliacao.php');			break;
	case 'login_lista'			: include('acoes/login_lista.php');			break;
	case 'add_lista'			: include('acoes/add_lista.php');			break;
	case 'criar_lista'			: include('acoes/criar_lista.php');			break;
	case 'excluir_arquivo'		: include('acoes/excluir_arquivo.php');		break;
	case 'marca_montagem'		: include('acoes/marca_montagem.php');		break;
	case 'marca_desmontagem'	: include('acoes/marca_desmontagem.php');	break;
	case 'busca'				: include('acoes/busca.php');				break;
	case 'pagar'				: include('acoes/pagar.php');				break;
	case 'pagar_ps'				: include('acoes/pagar_ps.php');			break;
	case 'nova_senha'			: include('acoes/nova_senha.php');			break;
}

?>