<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Mídias
        <small>Inclusão de Programas Parceiros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('MidiasParceirosController/viewAreaParceiros') ?>">Sistema de Mídias</a></li>
        <li class="active">Inclusão de Programas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('MidiasParceirosController/alterarParceiro') ?>" method="POST">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações Parceiros</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-md-6">

              <input type="hidden" name="idParceiro" id="idParceiro" value="<?php echo $parceiro[0]->idParceiros ?>">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $parceiro[0]->nomeParceiro ?>" disabled>
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..." disabled><?php echo $parceiro[0]->descricaoParceiro ?></textarea>
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                  <label>Mostrar Site novo</label>
                  <select name="site_novo" class="form-control" style="width: 100%;" disabled>
                    <option value="S" <?php echo ($parceiro[0]->site == 'S')? 'selected="selected"': '' ?>>SIM</option>
                    <option value="N" <?php echo ($parceiro[0]->site == 'N')? 'selected="selected"': '' ?>>Não</option>
                  </select>
                </div>
                               
                <div class="form-group">
                  <label>Situação</label>
                  <select name="situacao" class="form-control" style="width: 100%;" disabled>
                    <option value="S" <?php echo ($parceiro[0]->ativo == 'S')? 'selected="selected"': '' ?>>ATIVO</option>
                    <option value="N" <?php echo ($parceiro[0]->ativo == 'N')? 'selected="selected"': '' ?>>INATIVO</option>
                  </select>
                </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      <div class="box box-solid box-success">
          <div class="box-header">
            <div class="box-tools pull-right">
          </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <p id="img_<?php echo $parceiro[0]->idParceiros ?>">
              <img src="<?php echo IMAGEM_PARCEIRO. $parceiro[0]->imagem?>" class="img-responsive img-thumbnail" width="170" height="110">              						 	
            </p>
          </div><!-- /.box-body -->
          
      </div><!-- /.box -->

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Programas do Parceiro</h3>

          <div class="box-tools pull-right">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-incluirPrograma">
              <i class="fa fa-plus"></i> Novo Programa
              </button>
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php foreach ($listSerieParceiros as $programa) { ?>              
                <li class="item">
                  <div class="product-img">
                    <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO. $programa->imagem?>" alt="<?php echo $programa->nomePrograma ?>">
                  </div>
                  <div class="product-info">
                      <span class="product-title"><?php echo $programa->nomePrograma . ' - '. $programa->sigla ?></span>
                      <a href="#" class="btn btn-danger btn-sm pull-right excluirPrograma" id="<?php echo $programa->idProgramasParceiros ?>" ><i class="fa fa-trash"></i> </a> 
                      <a href="#" class="btn btn-primary btn-sm pull-right " id="<?php echo $programa->idProgramasParceiros ?>" data-toggle="modal" data-target="#modal-alterarPrograma"><i class="fa fa-pencil"></i> </a>                     
                      
                      <span class="product-description">
                        <?php echo $programa->descricao ?><br><br>
                      
                        <b>Duração:</b> <span class="label label-warning "><?php echo $programa->duracao ?></span><br>
                        <b>Inédito:</b> <span class="label label-warning "><?php echo $programa->inedito ?></span><br>
                        <b>Horários Alternativos:</b> <span class="label label-warning "><?php echo $programa->horariosAlternativos ?></span><br>
                      </span>
                  </div>
                </li>
                <!-- /.item -->
            <?php } ?>
            </ul>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      </form>

      <div class="modal fade" id="modal-incluirPrograma">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form action="<?php echo base_url('MidiasParceirosController/cadastrarProgramaParceiro') ?>" method="POST">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Cadastro de Programa</h4>
                </div>
                <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">

                          <input type="hidden" name="idParceiro" value="<?php echo $parceiro[0]->idParceiros ?>">

                          <div class="form-group">
                              <label for="nome">Nome :</label>
                              <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome">
                          </div>
                          <div class="form-group">
                              <label for="sigla">Sigla :</label>
                              <input name="sigla" type="text" class="form-control" id="sigla" placeholder="Informe a sigla">
                          </div>

                          <div class="form-group">
                              <label for="descricao">Descrição :</label>
                              <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..." ></textarea>
                          </div>
                          <div class="form-group">
                              <label for="duracao">Duração :</label>
                              <input name="duracao" type="text" class="form-control" id="duracao" placeholder="00:00:00">
                          </div>
                          <div class="form-group">
                              <label for="inedito">inédito :</label>
                              <textarea name="inedito" class="form-control" rows="4" placeholder="Terça - 08:30" ></textarea>
                          </div>
                          <div class="form-group">
                              <label for="horariosAlternativos">Horários Alternativos :</label>
                              <textarea name="horariosAlternativos" class="form-control" rows="4" placeholder="Horários Alternativos ..." ></textarea>
                          </div>

                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

                            <div class="form-group">
                              <label>Mostrar Site novo</label>
                              <select name="site_novo" class="form-control" style="width: 100%;" >
                                <option value="S" <?php echo ($parceiro[0]->site == 'S')? 'selected="selected"': '' ?>>SIM</option>
                                <option value="N" <?php echo ($parceiro[0]->site == 'N')? 'selected="selected"': '' ?>>Não</option>
                              </select>
                            </div>
                                          
                            <div class="form-group">
                              <label>Situação</label>
                              <select name="situacao" class="form-control" style="width: 100%;" >
                                <option value="S" <?php echo ($parceiro[0]->ativo == 'S')? 'selected="selected"': '' ?>>ATIVO</option>
                                <option value="N" <?php echo ($parceiro[0]->ativo == 'N')? 'selected="selected"': '' ?>>INATIVO</option>
                              </select>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="imagens" class="control-label">Selecionar Imagens:</label>
                                    <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                                        <div id="resp"></div>                    
                                  </div>
                                </div>              
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <div class="modal face" id="modal-alterarPrograma" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 