
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="language" content="pt">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo $urlC; ?>assets/images/favicon.ico" type="image/x-icon">
<meta name="keywords" content="roupa infantil, m&m kids, mem kids, m e m kids, roupa infantil menino e menina, body, moda infantil, moda bebê, roupa para batizado para o bebê, macacão infantil,  body macacão, blusa infantil, casaco bebê, camisa para menino e menina">
<meta name="description" content="Ser referência como loja de roupas infantil, que facilita a rotina de toda a família do bebê ou da criança, para encontrar as roupas ideais para a cada etapa do crescimento, até os 4 anos de idade.">

<title><?php echo $result_info['nome']; ?></title>

<?php if($pagina == 'noticia'){ ?>

	<?php 
	$id = 0;
	if(isset($parametro)){
		
		$slug = explode('__',$parametro);
		$id = end($slug);
	}
	?>
	<?php $query = $conn->query("SELECT * FROM noticia WHERE ativo = 't' AND id = {$id}"); ?>
	<?php if($query->num_rows > 0){ ?> 
		<?php $result = $query->fetch_array(); ?>
		
		<meta property="og:site_name" content="<?php echo $result_info['nome']; ?>"/>
		<meta property="og:title" content="<?php echo $result['nome']; ?>"/>
		<meta property="og:url" content="<?php echo $urlFull; ?>"/>
		<meta property="og:description" content="<?php echo strip_tags($result['texto']); ?>"/>
		
		<?php $queryG = $conn->query("SELECT * FROM noticia_galeria WHERE id_noticia = {$result['id']} ORDER BY capa DESC, ordem DESC LIMIT 1"); ?>
		<?php if($queryG->num_rows > 0){ ?>
            <?php $resultG = $queryG->fetch_array(); ?>
			<meta property="og:image" content="<?php echo $urlC.'admin/'.$resultG['arquivo']; ?>"/>
		<?php } ?>
	<?php } ?>
<?php }else{ ?>

	<meta property="og:site_name" content="<?php echo $result_info['nome']; ?>"/>
	<meta property="og:title" content="<?php echo $result_info['nome']; ?>"/>
	<meta property="og:url" content="<?php echo $urlC; ?>"/>
	<meta property="og:description" content=""/>
	<meta property="og:image" content="<?php echo $urlC.'assets/images/logotipo.png'; ?>"/>
<?php } ?>

<link rel="stylesheet" type="text/css" href="<?php echo $urlC ?>css/custome67d.css?v=1.3">
<link rel="stylesheet" type="text/css" href="<?php echo $urlC ?>css/responsivee67d.css?v=1.3">

<style>
@import url("<?php echo $urlC ?>assets/font-awesome/css/font-awesome.min.css");
@import url("<?php echo $urlC ?>assets/css/bootstrap-select.min.css");
@import url("<?php echo $urlC ?>assets/css/jquery.bootstrap-touchspin.min.css");
@import url("<?php echo $urlC ?>assets/datatables/datatables.min.css");
@import url("<?php echo $urlC ?>assets/css/bootstrap-radio-checkbox.css");
@import url("<?php echo $urlC ?>assets/lightgallery/lightgallery.css");
@import url("<?php echo $urlC ?>assets/css/animate.min.css");
@import url("<?php echo $urlC ?>assets/revslider/css/revolution.settings.css");
@import url("<?php echo $urlC ?>assets/chosen-multiselect/bootstrap-chosen.css");
@import url("<?php echo $urlC ?>assets/css/styles.css?<?php echo date('His'); ?>");
</style>

<?php if($pagina == 'pagamento'){ ?>

	<?php if($config['pagseguro_ambiente'] == 'p'){ ?>
	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<?php }else{ ?>
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<?php } ?>
<?php } ?>

<script src="https://config.confirmic.com/config.js?id=prj:fff783be-9fea-4677-9315-e0066d8c2a42" crossorigin charset="utf-8"></script>
<script src="https://consent-manager.confirmic.com/embed.js" crossorigin charset="utf-8"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GME44DGB4W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GME44DGB4W');
</script>

</head>

<body <?php echo ($pagina == 'home')?('class="homepage"'):('id="page-top" data-spy="scroll" data-target=".navbar-fixed-top"') ?>>


<!-- JQUERY -->
<script src="<?php echo $urlC; ?>js/jquery-1.12.3.min.js"></script>

<script src="<?php echo $urlC ?>assets/lightgallery/lightgallery.min.js"></script>
<script src="<?php echo $urlC ?>assets/lightgallery/lg-thumbnail.min.js"></script>
<script src="<?php echo $urlC ?>assets/lightgallery/lg-fullscreen.min.js"></script>
<script src="<?php echo $urlC ?>assets/lightgallery/lg-zoom.min.js"></script>
<script src="<?php echo $urlC ?>assets/lightgallery/lg-video.js"></script>
<script src="<?php echo $urlC ?>assets/lightgallery/lg-autoplay.js"></script>

<div class="loader"></div>

<?php $_SESSION['max_sem_juros'] = 6; ?>


