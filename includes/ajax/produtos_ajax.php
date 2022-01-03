<?php

$busca 			= (isset($_POST['busca']) && !empty($_POST['busca']))?($_POST['busca']):(FALSE);
$secao			= (isset($_POST['secao']) && !empty($_POST['secao']))?($_POST['secao']):(FALSE);
$categoria		= (isset($_POST['categoria']) && !empty($_POST['categoria']))?($_POST['categoria']):(FALSE);
$subcategoria	= (isset($_POST['subcategoria']) && !empty($_POST['subcategoria']))?($_POST['subcategoria']):(FALSE);

$maximo			= $_POST['maximo'];
$inicio			= $_POST['inicio'];

$add_order		= $_POST['add_order'];
$add_select		= $_POST['add_select'];

$add_join = NULL;
$add_where = NULL;

if($busca){
				
	$add_where .= " AND CONCAT_WS(' ',produto.nome,subcategoria.nome,categoria.nome,produto.referencia) LIKE '%".str_replace(" ","%",$_GET['busca'])."%'";
}

if($secao){
				
	$add_where .= " AND secao.id = {$_POST['secao']}";
}

if($categoria){
				
	$add_where .= " AND categoria.id = {$_POST['categoria']}";
}

if($subcategoria){
				
	$add_where .= " AND subcategoria.id = {$_POST['subcategoria']}";
}

?>

<?php
$sql = "SELECT produto.*, MIN(rel_produto_var.valor) AS valor_produto, COUNT(rel_produto_var.id) AS valores {$add_select}
FROM produto
INNER JOIN rel_produto_var ON rel_produto_var.id_produto = produto.id
INNER JOIN subcategoria ON subcategoria.id = produto.id_subcategoria
INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
INNER JOIN secao ON produto.secoes LIKE CONCAT('%,', secao.id, '%') OR produto.secoes LIKE CONCAT('%', secao.id, ',%') OR produto.secoes = secao.id
INNER JOIN produto_galeria ON produto_galeria.id_produto = produto.id
WHERE produto.ativo = 't' AND rel_produto_var.valor > 0
$add_where
GROUP BY produto.id
{$add_order}";

$query = $conn->query("{$sql} LIMIT {$inicio}, {$maximo}");
?>

<?php while($result = $query->fetch_array()){ ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 item-produtos">
		<a href="<?php echo $urlC.'produto/'.$result['slug']; ?>">
			<div class="box-produto">
				<?php $queryG = $conn->query("SELECT * FROM produto_galeria WHERE id_produto = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
					<?php if($queryG->num_rows > 0){ ?>
		                <?php $resultG = $queryG->fetch_array(); ?>
		                <?php 
		                $queryV = $conn->query("SELECT * FROM rel_produto_var WHERE id_produto = {$result['id']} AND id_cor = {$resultG['id_cor']} LIMIT 1");
						$resultV = $queryV->fetch_array();
		                ?>
						<figure class="<?php echo ($resultG['posicao'] == 'c')?('bg-contain'):('bg-cover'); ?> bg-p75">
							<img data-src="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
						</figure>
					<?php }else{ ?>
						<figure class="bg-contain bg-p75 bordered">
							<img data-src="<?php echo $urlC.'assets/images/no-image.png'; ?>"/>
						</figure>
					<?php } ?>
				<p class="h5 text-custom-2">
						<?php $media = Util::mediaAvaliacao($result['id']); ?>
						<span class="avaliacoes">
							<?php for($i = 1; $i <= 5; $i++){ ?>
							<i class="fa <?php echo ($i <= $media)?('fa-star'):('fa-star-o'); ?>"></i>
							<?php } ?>
						</span>
					</p>
					<div data-mh="titulo-produto">
						<p class="h5"><?php echo $result['nome']; ?></p>
					</div>
					<p class="preco">
						<?php if($result['valor_de'] > 0){ ?>
						<strike class="small text-muted"><?php echo 'R$&nbsp;'.Util::fixValor($result['valor_de']); ?></strike>
						<?php } ?>
						<big class="text-custom"><?php echo 'R$&nbsp;'.Util::fixValor((isset($resultV['valor']))?($resultV['valor']):($result['valor_produto'])); ?></big>
					</p>
					<button class="btn btn-sm btn-custom-3 btn-comprar"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Comprar</button>
			</div>
		</a>
		<br/>
	</div>
<?php } ?>
