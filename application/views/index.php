<div class="wrapper">
  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
  <div class="content-wrapper">
  <section id="parallaxBar" class="avisos" data-speed="6">
  <div class="container-fluid">
    <div class="hero">
      <hgroup>    
    <h1>Avisos</h1><big><?php echo date("d/m/Y");?></big>
  <br>
      </hgroup>
    </div>
    <div class="overlay-internos"></div>
  </div>
</section>
<section>
  <div class="container textos-internos "> 
    <div class="row">
          <div class="col-sm-6 busca-header" style="padding:0" >
            <form action="<?php echo base_url('Home/buscar') ?>" method="GET">
              <div class="form-group col-sm-12" style="padding-right:80px">
                <input type="text" name="palavraChave" class="form-control" placeholder="Buscar Noticias" value="<?php echo @$palavraChave ?>" >
                <button type="submit" class="btn" style="position:absolute; right:0; top:0">Buscar</button>
              </div>
            </form>
          </div>
        </div>
         <?php 
    
        if(@$palavraChave){
        echo '<b>Você buscou por:</b> '. @$palavraChave. ' '; } 
        
        if(!$listAvisos){
        echo '<br><b>Não há resultados para o termo pesquisado</b>'; 
        }
        /*echo '<pre>';
        print_r($listNoticias);
        echo '</pre>';*/
        ?>
        <!--LINHA-->
        <hr>
        <?php foreach ($listAvisos as $key => $avisos) { ?>
          <?php  echo (!(intval($key) % 2) || $key == '0') ? '<div class="row linhaNoticia"> ' : '';   

          if ($avisos->imagens != '') {
                    $imagem = explode(',',$avisos->imagens);
                    //print_r($imagem);


          ?>   
		  

          <div class="col-sm-6">        
                      <h3><a href="<?php echo base_url('Home/avisoAberto/'.$avisos->friendly_url)?>"><img src="<?php echo IMAGEM_NOTICIA_SITE.$imagem[0] ?> " class="fotoNoticiaLista" width="75" height="50"></a>
                       <?php echo converteDataInterface($avisos->dia) .' :: '. $avisos->descricao ?> 
                      </h3>
                      <p>
                        <a href="<?php echo base_url('Home/avisoAberto/'.$avisos->friendly_url)?>">
                          <?php echo $avisos->sinopse ?>»»
                        </a>
                      </p>
                  </div>
                <?php }else{ ?>

                   <div class="col-sm-6">        
                      <h3><a href="<?php echo base_url('Home/avisoAberto/'.$avisos->friendly_url)?>"></a></h3>
<h3><span class="glyphicon glyphicon-arrow-right " aria-hidden="true"></span><?php echo converteDataInterface($avisos->dia) .' :: '. $avisos->descricao ?> </h3>
<p><a href="<?php echo base_url('Home/avisoAberto/'.$avisos->friendly_url)?>"><?php echo $avisos->sinopse ?>»»</a></p>
                  </div>

              <?php } ?>
                
            
            <?php echo ((intval($key) % 2) && $key != '0') ? '</div><hr> ' : '';?>                   
            
        <?php } ?>
        

      </div>

      
</section>

<div class="row" >                       
        <div  style="text-align:center"> 
            <?php echo $paginacao ?>
        </div>
</div>

</div>



    
  