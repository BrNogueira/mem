
<?php 
$id = 0;
if(isset($parametro)){
	
	$slug = explode('__',$parametro);
	$id = end($slug);
}
?>
<?php $query = $conn->query("SELECT * FROM pagina_institucional WHERE id = {$id}"); ?>
<?php if($query->num_rows == 0){ header("Location: $urlC"); } ?>
<?php $result = $query->fetch_array(); ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Institucional</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part">
					<h2 class="main_title heading"><?php echo $result['nome']; ?></h2>
				</div>
				<div class="texto">
					<?php echo $result['texto']; ?>
				</div>
			</div>
		</div>
	</div>
</section>
