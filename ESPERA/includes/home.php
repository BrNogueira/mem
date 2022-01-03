<section>
    <div class="container pagina_espera">
        <div class="row"> 
            <div class="col-md-12 text-center">
                <figure class="">    
                    <img class="visible-xs wow bounceInUp imagem_direita_espera_inicial" src="assets/img/logo_M&M_GRAFISMO_Logo_01.png">
                </figure>    
            </div>    

            <div class="wow slideInLeft col-md-6" data-wow-duration = "3s" >
                <img class="wow pulse imagem_esquerda_espera_inicial" src="assets/img/Personagem_vertical.png">
            </div>
            <div class="wow slideInRight col-md-6 bloco_botao_contato"data-wow-duration = "3s">
                <span class="titulo" >Estamos em construção!!<br> Aguarde que logo teremos novidades!</span>
                <br>
                <a class="btn  btn-custom efects btn-contato" type="button" data-toggle="modal" data-target="#modal_contato">ENTRE EM CONTATO</a>

            </div>
            <div class="col-md-6"> 
                <img class="hidden-xs wow bounceInUp imagem_direita_espera_inicial" src="assets/img/logo_M&M_GRAFISMO_Logo_01.png">
                
                <div class="row rodape_contato wow fadeIn" data-wow-delay="2s">
                    <div class="col-md-12"> 
                        <p class="nome_empre font-600">Nosso contato</p>
                    </div>
                    <div class="col-md-12"> 
                            <i class="fa fa-phone"></i>&nbsp;&nbsp;<b>Telefone:</b> 55 51 99794 6969<br>
                            <!-- <i class="fa fa-map-o"></i>&nbsp;&nbsp;<b>Endereço: </b>Rua teste, 123<br> -->
                            <i class="fa fa-envelope"></i>&nbsp;&nbsp;<b>E-mail: </b>contato@memkids.com.br
                        </p>
                    </div>

                </div>

            </div>
        </div>


    </div>
</section>


<div class="modal fade" id="modal_contato" tabindex="-1" role="dialog" aria-labelledby="contatoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <blockquote class="modal-title" id="contatoModalLabel">Fale conosco<small>Informe seus dados</small></blockquote>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=$urlC."acao"?>">
        <input type="hidden" value="send" name="acao"/>
        <input type="hidden" value="contato" name="tipo"/>
            <div class="row">
                <div class="form-group col-md-12">
                    <input class="form-control" type="text" value="" name="nome" id="nome" placeholder="Nome" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <input class="form-control fone-mask" type="phone" value="" name="telefone" id="telefone" placeholder="Telefone" required>
                </div>
                <div class="form-group col-md-6">
                    <input class="form-control" type="email" value="" name="email" id="email" placeholder="E-mail" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <textarea class="form-control" maxlength="5000" rows="3" name="mensagem" id="mensagem" placeholder="Digite sua mensagem" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>

      </div>
    </div>
  </div>
</div>