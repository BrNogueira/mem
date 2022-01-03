
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $urlC; ?>">Double One</a>
    </div>
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['login']['nome']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
    			<?php if($_SESSION['login']['id_nivel_acesso'] == 1){ ?>
                    <li>
                        <a href="<?php echo $urlC.'configuracoes'; ?>"><i class="fa fa-fw fa-gears"></i> Configurações</a>
                    </li>
        		<?php } ?>
    			<?php if(in_array($_SESSION['login']['id_nivel_acesso'], array(1,2))){ ?>
                    <li>
                        <a href="<?php echo $urlC.'usuarios'; ?>"><i class="fa fa-fw fa-users"></i> Usuários</a>
                    </li>
        		<?php } ?>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo $urlC.'sair'; ?>"><i class="fa fa-fw fa-power-off"></i> Sair</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
    		<?php if($_SESSION['login']['id_nivel_acesso'] != 3){ ?>
            <li data-active="info">
                <a href="<?php echo $urlC.'informacao_site'; ?>"><i class="fa fa-fw fa-info-circle"></i> Informações do Site</a>
            </li>
            <?php } ?>
            <li data-active="clientes">
                <a href="<?php echo $urlC.'clientes'; ?>"><i class="fa fa-fw fa-users"></i> Clientes</a>
            </li>
            <li data-active="relatorio-vendas">
                <a href="<?php echo $urlC.'relatorio_vendas'; ?>"><i class="fa fa-fw fa-line-chart"></i> Relatório de Vendas</a>
            </li>
            <li data-active="produtos">
                <a href="javascript:;" data-toggle="collapse" data-target="#sub-produtos"><i class="fa fa-fw fa-cubes"></i> Catálogo de Produtos <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="sub-produtos" class="collapse">
                    <li>
                        <a href="<?php echo $urlC.'categorias'; ?>">&raquo; Produtos</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'secoes'; ?>">&raquo; Seções de Produtos</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'cores'; ?>">&raquo; Índice de Cores</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'tamanhos'; ?>">&raquo; Índice de Tamanhos</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'tipos_tecido'; ?>">&raquo; Tipos de Tecido</a>
                    </li>
                </ul>
            </li>
            <li data-active="guias_tamanhos">
                <a href="<?php echo $urlC.'categorias_guias_tamanhos'; ?>"><i class="fa fa-fw fa-crop"></i> Guias de Tamanhos</a>
            </li>
            <li data-active="avise">
                <a href="<?php echo $urlC.'avise_me'; ?>"><i class="fa fa-fw fa-bullhorn"></i> Avise-me</a>
            </li>
            <li data-active="frete">
                <a href="<?php echo $urlC.'frete'; ?>"><i class="fa fa-fw fa-truck"></i> Frete Grátis</a>
            </li>
            <li data-active="cupons">
                <a href="<?php echo $urlC.'cupons'; ?>"><i class="fa fa-fw fa-ticket"></i> Cupons de Desconto</a>
            </li>
            <li data-active="banners">
                <a href="<?php echo $urlC.'banners'; ?>"><i class="fa fa-fw fa-image"></i> Banners Topo</a>
            </li>
            <li data-active="oferta">
                <a href="javascript:;" data-toggle="collapse" data-target="#sub-oferta"><i class="fa fa-fw fa-file-image-o"></i> Banners Oferta <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="sub-oferta" class="collapse">
                    <li>
                        <a href="<?php echo $urlC.'banners_oferta_pequeno'; ?>">&raquo; Banners Oferta - Pequeno</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'banners_oferta_medio'; ?>">&raquo; Banners Oferta - Médio</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'banners_oferta_grande'; ?>">&raquo; Banners Oferta - Grande</a>
                    </li>
                </ul>
            </li>
            <li data-active="quem_somos">
                <a href="javascript:;" data-toggle="collapse" data-target="#sub-quem_somos"><i class="fa fa-fw fa-briefcase"></i> Quem Somos <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="sub-quem_somos" class="collapse">
                    <li>
                        <a href="<?php echo $urlC.'quem_somos'; ?>">&raquo; Texto principal</a>
                    </li>
                    <li>
                        <a href="<?php echo $urlC.'quem_somos_textos'; ?>">&raquo; Textos adicionais</a>
                    </li>
                </ul>
            </li>
            <li data-active="equipe">
                <a href="<?php echo $urlC.'equipe'; ?>"><i class="fa fa-fw fa-user-circle"></i> Equipe</a>
            </li>
            <li data-active="duvidas">
                <a href="<?php echo $urlC.'duvidas_frequentes'; ?>"><i class="fa fa-fw fa-question-circle"></i> Dúvidas Frequentes</a>
            </li>
            <li data-active="paginas-institucionais">
                <a href="<?php echo $urlC.'paginas_institucionais'; ?>"><i class="fa fa-fw fa-info-circle"></i> Páginas Institucionais</a>
            </li>
            <li data-active="noticias">
                <a href="<?php echo $urlC.'noticias'; ?>"><i class="fa fa-fw fa-newspaper-o"></i> Dicas</a>
            </li>
            <li data-active="depoimentos">
                <a href="<?php echo $urlC.'depoimentos'; ?>"><i class="fa fa-fw fa-comments-o"></i> Depoimentos</a>
            </li>
            <li data-active="marcas">
                <a href="<?php echo $urlC.'marcas'; ?>"><i class="fa fa-fw fa-certificate"></i> Marcas/Parceiros</a>
            </li>
            <li data-active="contato">
                <a href="<?php echo $urlC.'contato'; ?>"><i class="fa fa-fw fa-envelope-o"></i> Fale Conosco</a>
            </li>
            <li data-active="newsletter">
                <a href="<?php echo $urlC.'newsletter'; ?>"><i class="fa fa-fw fa-send-o"></i> Newsletter</a>
            </li>
            <li>
                <br/>
            </li>
        </ul>
    </div>
</nav>