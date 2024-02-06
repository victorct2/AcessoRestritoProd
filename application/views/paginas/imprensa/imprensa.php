<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Imprensa
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('NoticiasController/viewLista') ?>">Imprensa</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('ImprensaController/alterarImprensa') ?>" method="POST">
              

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Informações</h3>
            <?php $this->load->view('include/alertsMsg') ?>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <input type="hidden" name="idImprensa" value="<?php echo $imprensa[0]->idImprensa ?>">

            <div class="row">
              <div class="col-md-12">
                <div class="box-body pad">
                  <form>
                        <textarea id="editor1" name="descricaoCompleta" rows="10" cols="80">
                            <?php echo $imprensa[0]->descricao ?>
                        </textarea>
                  </form>
                </div>
                <hr>
                <button type="submit" class="btn btn-warning ">Alterar Imprensa</button>
              </div>
              
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->
      

     </form>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->