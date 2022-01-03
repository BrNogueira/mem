

<script src="<?php echo $urlC; ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.bxslider.js"></script>
<script src="<?php echo $urlC; ?>assets/js/bootstrap-select.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/bootstrap-colorselector.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.mixitup.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.ellipsis.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.stellar.js"></script>
<script src="<?php echo $urlC; ?>assets/js/countUp.js"></script>
<script src="<?php echo $urlC; ?>assets/js/bootstrap-filestyle.js"></script>
<script src="<?php echo $urlC; ?>assets/datatables/datatables.min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.dotdotdot.js"></script>
<script src="<?php echo $urlC; ?>assets/js/masonry.pkgd.min.js"></script>
<script src="<?php echo $urlC; ?>assets/owlcarousel/owl.carousel.min.js"></script>
<script src="<?php echo $urlC; ?>assets/chosen-multiselect/chosen.jquery.js"></script>
<script src="<?php echo $urlC; ?>assets/js/wow.min.js"></script>
<script>
new WOW({ 
	offset: 0,
	mobile: false 
}).init();
</script>
<script src="<?php echo $urlC; ?>assets/js/masks.js"></script>
<script src="<?php echo $urlC; ?>assets/js/jquery.matchHeight-min.js"></script>
<script src="<?php echo $urlC; ?>assets/js/scripts.js?<?php echo date('His'); ?>"></script>



<?php if(isset($_SESSION['aviso']) && !empty($_SESSION['aviso'])){ ?>
<div class="modal fade modal-form" id="modal-aviso" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-danger alert-dismissible no-margin">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<strong>Aviso!</strong> <?php echo $_SESSION['aviso']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
		$('#modal-aviso').modal('show');
		$.ajax({url: urlC+'unset_ajax'});
	});
</script>
<?php } ?>

<?php if(isset($_SESSION['sucesso']) && !empty($_SESSION['sucesso'])){ ?>
<div class="modal fade modal-form" id="modal-sucesso" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-success alert-dismissible no-margin">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<strong>Pronto!</strong> <?php echo $_SESSION['sucesso']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
		
		$('#modal-sucesso').modal('show');
		$.ajax({url: urlC+'unset_ajax'});
	});
</script>
<?php } ?>


</body>
</html>