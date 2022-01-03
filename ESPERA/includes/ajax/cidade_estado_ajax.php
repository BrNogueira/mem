<?php
$uf = $_POST['uf'];

$select_fields	= 'cidade.*';			
$select_table	= 'cidade';	
$select_join	= 'INNER JOIN estado ON estado.id = cidade.id_estado';			
$select_where	= (is_numeric($uf))?("WHERE estado.id = $uf"):("WHERE estado.uf = '$uf'");
$select_group	= 'GROUP BY cidade.id';
$select_order	= 'ORDER BY cidade.nome';
$select_limit	= '';
$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, 
	$select_group, $select_order, $select_limit);
?>

<option value="">Selecione uma cidade...</option>
	
<?php while($result = $consulta->fetch_array()){ ?>

	<option value="<?php echo $cidade = (is_numeric($uf))?($result['id']):($result['nome']); ?>"><?php echo $result['nome']; ?></option>
<?php } ?>
