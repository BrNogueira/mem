
<span data-active="newsletter"></span>

<?php if(isset($_SESSION['login'])){
	
	$select_fields	= '*';			
	$select_table	= 'newsletter_email';	
	$select_join	= '';			
	$select_where	= '';
	$select_group	= '';
	$select_order	= 'ORDER BY nome';
	$select_limit 	= '';
	$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order, $select_limit);	
	?>
	
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">
	            Newsletter <small>/cadastros</small>
	        </h2>
	        <ol class="breadcrumb">
	        	<li>
                    <a href="<?php echo $urlC.'home'; ?>">Home</a>
                </li>
	            <li class="active">
	                Newsletter cadastros
	            </li>
	        </ol>
	    </div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		
		    <?php if($consulta->num_rows > 0){ ?>
				<a href="<?php echo $urlC.'download_emails.php?acesso=bVVzZXI=';?>"> 
					<button class="btn btn-sm btn-warning"> <i class="fa fa-download-alt"></i>Download</button>
				</a>
			<?php } ?>
			
			<div class="table-responsive">
			    <table class="table table-striped datatable">
			        <thead>
			            <th class="text-left">E-mail</th>
						<th class="p5">Excluir</th>
			        </thead>
			        <tbody>
					<?php while($result = $consulta->fetch_array()){ ?>
						
						<tr>
							<td class="text-left"><?php echo $result['email']; ?></td>								
							<td>
								<form method="post" action="<?php echo $urlC.'acao'; ?>">
									<input type="hidden" name="tabela" value="<?php echo $select_table; ?>"/>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
									<input type="hidden" name="acao" value="delete"/>
									<button type="button" class="fa fa-trash confirm" data-title="Deseja realmente excluir?"></button>
								</form>
							</td>
						</tr>
					<?php } ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
<?php }else{

	header("location:".$urlC."login");
} ?>