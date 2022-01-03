
<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Dúvidas Frequentes</span></li>
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
					<h2 class="main_title heading">Dúvidas Frequentes</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 ui-accordion">
                <div data-accordion="true" class="accordion-first">
                	<?php $cont = 0; ?>
                	<?php $query = $conn->query("SELECT * FROM duvida_frequente ORDER BY ordem DESC"); ?>
					<?php while($result = $query->fetch_array()){ ?>
                		<?php $cont++; ?>
	                    <p class="default header-accordion text-uppercase <?php echo ($cont == 1)?('index'):(NULL); ?>"><?php echo $result['nome']; ?></p>
	                    <div data-accordion-target="<?php echo $result['nome']; ?>">
	                        <div class="texto"><?php echo $result['texto']; ?></div>
	                    </div>
                    <?php } ?>
                </div> 
                <br/>
			</div>	
		</div>
	</div>
</section>