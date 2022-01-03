<?php if(!isset($_SESSION['login'])){ header("location:".$urlC."login"); } ?>

<span data-active="home"></span>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Bem vindo <small>Administrador</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                Home
            </li>
        </ol>
    </div>
</div>

<div class="row">
	<div class="col-xs-12">
		
		<blockquote><h4> <i class="fa fa-file-text-o"></i>  Detalhes da Empresa </h4>  </blockquote>
		
		<p><i class="fa fa-clock-o"></i> 	Horário do Login: 	<span><b><?php echo Util::fixDataHora($_SESSION['data']); ?></b></span></p>
		<p><i class="fa fa-briefcase"></i>  Empresa: 			<span><b><?php echo $result_info['nome']; ?></b></span></p>
		<p><i class="fa fa-star"></i> 		Nome: 				<span><b><?php echo $_SESSION['login']['nome']; ?></b></span></p>
		<p><i class="fa fa-user"></i> 		Login: 				<span><b><?php echo $_SESSION['login']['login']; ?></b></span></p>
		
		<hr />
	</div>
</div>


            