<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <title><?php echo $result_info['nome']; ?> - Administrador</title>

    <!-- BOOTSTRAP CORE CSS -->
    <link href="<?php echo $urlC.'css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="<?php echo $urlC.'css/sb-admin.css'; ?>" rel="stylesheet">
    <!-- CUSTOM FONTS -->
    <link href="<?php echo $urlC.'font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css">
	<!-- FANCYBOX -->
	<link rel="stylesheet" href="<?php echo $urlC.'js/fancybox/source/jquery.fancybox.css'; ?>" media="screen"/>
	<!-- MULTISELECT -->
	<link rel="stylesheet" href="<?php echo $urlC.'js/chosen-multiselect/bootstrap-chosen.css'; ?>"/>
	<!-- ICONPICKER -->
	<link rel="stylesheet" href="<?php echo $urlC.'js/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css'; ?>"/>
	<!-- SELECTPICKER -->
	<link rel="stylesheet" href="<?php echo $urlC.'css/bootstrap-select.min.css'; ?>"/>
	<!-- RADIO/CHECKBOX -->
	<link rel="stylesheet" href="<?php echo $urlC.'css/bootstrap-radio-checkbox.css'; ?>"/>
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?php echo $urlC.'css/styles.css'; ?>"/>
	
	<!-- JQUERY -->
	<script type="text/javascript" src="<?php echo $urlC.'js/jquery-1.11.3.min.js'; ?>"></script>	
    <!-- BOOTSTRAP CORE JAVASCRIPT -->
    <script src="<?php echo $urlC.'js/bootstrap.min.js'; ?>"></script>
    <!-- FILESTYLE -->
	<script type="text/javascript" src="<?php echo $urlC.'js/bootstrap-filestyle.js'; ?>"></script>
	<!-- FANCYBOX -->
	<script type="text/javascript" src="<?php echo $urlC.'js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'; ?>"></script>
	<link rel="stylesheet" href="<?php echo $urlC.'js/fancybox/source/jquery.fancybox.css?v=2.1.5'; ?>" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo $urlC.'js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5'; ?>"></script>	
	<!--  PLUGIN SOURCES -->
	<script src="<?php echo $urlC.'js/dataHora_mask.js'; ?>"></script>
	<script src="<?php echo $urlC.'js/jquery.maskedinput.js'; ?>"></script>
	<script src="<?php echo $urlC.'js/jquery.maskMoney.js'; ?>"></script>
	<script src="<?php echo $urlC.'js/chosen-multiselect/chosen.jquery.js'; ?>"></script>
	<!-- DATATABLES -->
	<link rel="stylesheet" href="<?php echo $urlC.'js/datatables/datatables.css'; ?>"/>
	<script src="<?php echo $urlC.'js/datatables/datatables.js'; ?>"></script>
	<!-- MASKS -->
	<script src="<?php echo $urlC.'js/mask.js'; ?>"></script>
	<!-- SELECTPICKER -->
	<script src="<?php echo $urlC.'js/bootstrap-select.min.js'; ?>"></script>
	<script src="<?php echo $urlC.'js/bootstrap-select-pt_BR.js'; ?>"></script>
	<!-- CUSTOM SCRIPTS -->
	<script src="<?php echo $urlC.'js/scripts.js'; ?>"></script>
	<!-- BOOTSTRAP CONFIRMATION -->
	<script src="<?php echo $urlC.'js/bootstrap-tooltip.js'; ?>"></script>
	<script src="<?php echo $urlC.'js/bootstrap-confirmation.js'; ?>"></script>
	<!-- CKEDITOR -->
	<script type="text/javascript" src="<?php echo $urlC.'ckeditor/ckeditor.js'; ?>"></script>
	<!-- ICONPICKER -->
	<script type="text/javascript" src="<?php echo $urlC.'js/bootstrap-iconpicker/js/iconset/iconset-all.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo $urlC.'js/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js'; ?>"></script>
	<!-- JSCOLOR -->
	<script type="text/javascript" src="<?php echo $urlC.'js/jscolor/jscolor.js'; ?>"></script>
	<!-- CONFIRM -->
	<link rel="stylesheet" href="<?php echo $urlC.'js/confirm/jquery-confirm.min.css'; ?>"/>
	<script type="text/javascript" src="<?php echo $urlC.'js/confirm/jquery-confirm.min.js'; ?>"></script>
		
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php if($_SESSION['login']['id_nivel_acesso'] == 3 && !in_array($pagina, array('login', 'home', 'logar', 'sair', 'acao', 'orcamentos', 'enviar_orcamento', 'orcamentos_enviados', 'pre_visualizar'))){ header("Location: {$urlC}"); } ?>

<body>

<?php if(isset($_SESSION['login'])){ ?>

<div id="wrapper">        
    
    <?php include('includes/cabecalho.php'); ?>

    <div id="page-wrapper">

        <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-12">
            		
        		<?php if(isset($_SESSION['sucesso']) && !empty($_SESSION['sucesso']) && !is_array($_SESSION['sucesso'])){ ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i>  <strong>Pronto! </strong> <?php echo $_SESSION['sucesso']; ?>
                    </div>
                <?php }elseif(isset($_SESSION['aviso']) && !empty($_SESSION['aviso']) && !is_array($_SESSION['aviso'])){ ?>
            		<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i>  <strong>Alerta! </strong> <?php echo $_SESSION['aviso']; ?>
                    </div>
            	<?php } ?>
            	
            	<?php if(isset($_SESSION['sucesso']) or isset($_SESSION['aviso'])){ ?>
            	<script>
					$(document).ready(function(){
						var dir = window.location.href.split('/');
						var urlC = (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/admin/'):(location.protocol+'//'+document.domain+'/admin/');
						$.ajax({url: urlC+'unset_ajax'});
					});
				</script>
				<?php } ?>
            </div>
        </div>
<?php } ?>
