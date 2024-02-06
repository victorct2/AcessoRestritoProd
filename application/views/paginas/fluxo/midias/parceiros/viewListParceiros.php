<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Mídias
        <small>Lista Parceiros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Mídias</a></li>
        <li class="active">Lista Parceiros</li>
      </ol>
    </section>

      <!-- Main content -->
    <section class="content">
    

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Programas Parceiros</h3>

          <div class="box-tools pull-right">
            <a href="<?php echo base_url('midiasParceirosController/viewAreaParceiros')?>" class="btn btn-primary"><i class="fa fa-list-alt"></i> Sistema de Controle dos Parceiros</a>            
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>            
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            

        <div class="row">
          <?php foreach ($listParceiros as $parceiro) { ?>

              <div class="col-md-4">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <a href="<?php echo base_url('midiasParceirosController/viewfluxoParceiros/'.$parceiro->idParceiros) ?>">
                  <div class="widget-user-header bg-gray">    										              
                    <div class="widget-user-image">
                      <?php if($parceiro->imagem != ''){ ?>
                          <img class="attachment-img" src="<?php echo IMAGEM_PARCEIRO.$parceiro->imagem?>" width="144px" height="144px" alt="<?php echo $parceiro->nomeParceiro?>">
                      <?php } ?>                      
                    </div><br>
                    <!-- /.widget-user-image -->
										<h3 class="widget-user-username"><?php echo $parceiro->nomeParceiro?></h3>
									
                    <hr />
                    <div class="gradeProgramas" id="<?php echo $parceiro->idParceiros?>">
                          <span class="badge bg-grey carregando">carregando...</span>                      
                    </div>                 
                  </div>
                  </a>
                </div>
                <!-- /.widget-user -->
              </div>
              <!-- /.col -->  
              
          <?php } ?>
          
        </div>
        <!-- /.row -->
            
      
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 
