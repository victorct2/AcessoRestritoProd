<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <h1><?php echo converteDataInterface($avisos[0]->dia) ?></h1>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Avisos</li>
      </ol>
    </section>

    <br>

       <?php
    

  
    $estiloColuna_2 = "style='width:70%; text-align: justify; float:none !important; margin:0 auto'";

    //}
    ?>

       
       <div class="col-sm-7 descricaoCompleta" <?php echo $estiloColuna_2; ?>>

      <h3><?php echo $avisos[0]->descricao; ?></h3>

         <br/>

       
        <hr>


               <?php echo $avisos[0]->descricao_completa; ?>

        </div>
        

     

  </div>
                   

     