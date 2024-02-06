<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Logos
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Logos</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

           
          <div class="row">

              <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                <div class="col-md-3">
                  <div class="box box-default box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 1</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">

                      <?php if($logos[0]->imagem != ''){ ?>
                        <p id="imgLogo1_<?php echo $logos[0]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[0]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo1" id="<?php echo $logos[0]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[0]->link ?>">
                      </div>

                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[0]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[0]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo1" class="control-label">Selecionar Imagens:</label>
                          <input id="logo1" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo1"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="1">
                      <button type="submit" class="btn btn-default" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                </form>
              </div><!-- /.col -->

              <div class="col-md-3">
                <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                  <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 2</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">

                      <?php if($logos[1]->imagem != ''){ ?>
                        <p id="imgLogo2_<?php echo $logos[1]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[1]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo2" id="<?php echo $logos[1]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[1]->link ?>">
                      </div>
                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[1]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[1]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo2" class="control-label">Selecionar Imagens:</label>
                          <input id="logo2" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo2"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="2">
                      <button type="submit" class="btn btn-primary" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                </form>
              </div><!-- /.col -->

              <div class="col-md-3">
                <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                  <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 3</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <?php if($logos[2]->imagem != ''){ ?>
                        <p id="imgLogo3_<?php echo $logos[2]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[2]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo3" id="<?php echo $logos[2]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[2]->link ?>">
                      </div>
                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[2]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[2]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo3" class="control-label">Selecionar Imagens:</label>
                          <input id="logo3" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo3"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="3">
                      <button type="submit" class="btn btn-warning" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                </form>
              </div><!-- /.col -->


              <div class="col-md-3">
                <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                  <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 4</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <?php if($logos[3]->imagem != ''){ ?>
                        <p id="imgLogo4_<?php echo $logos[3]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[3]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo4" id="<?php echo $logos[3]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[3]->link ?>">
                      </div>
                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[3]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[3]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo4" class="control-label">Selecionar Imagens:</label>
                          <input id="logo4" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo4"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="4">
                      <button type="submit" class="btn btn-danger" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                </form>
              </div><!-- /.col -->


              <div class="col-md-3">
                <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                  <div class="box box-info box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 5</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <?php if($logos[4]->imagem != ''){ ?>
                        <p id="imgLogo5_<?php echo $logos[4]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[4]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo5" id="<?php echo $logos[4]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[4]->link ?>">
                      </div>
                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[4]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[4]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo5" class="control-label">Selecionar Imagens:</label>
                          <input id="logo5" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo5"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="5">  
                      <button type="submit" class="btn btn-info" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                </form>
              </div><!-- /.col -->


              <div class="col-md-3">
                <form action="<?php echo base_url('LogosController/inserirLogo'); ?>" method="POST">
                  <div class="box box-success box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Logo 6</h3>
                      <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <?php if($logos[5]->imagem != ''){ ?>
                        <p id="imgLogo6_<?php echo $logos[5]->id ?>">
                          <img src="<?php echo base_url().'assets/img/logos/footer/'. $logos[5]->imagem?>" class="img-responsive img-thumbnail imgAlign" width="250" height="150">
                          <a href="#" class="excluirLogo6" id="<?php echo $logos[5]->id ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      <?php }else{  ?>
                        <h3><span class="label bg-navy">Sem Imagem</span></h3>
                      <?php } ?>

                      <hr />

                      <div class="form-group">
                          <label for="link">Link:</label>
                          <input type="text" name="link" class="form-control" id="link" placeholder="Informe o link" value="<?php echo $logos[5]->link ?>">
                      </div>
                      <div class="form-group">
                        <label>Mostrar no Site</label>
                        <select name="status" class="form-control" style="width: 100%;">
                          <option value="S" <?php echo ($logos[5]->status == 'S')? 'selected="selected"':'' ?>>SIM</option>
                          <option value="N" <?php echo ($logos[5]->status == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                        </select>
                      </div>

                      <hr />

                      <div class="form-group">
                          <label for="logo6" class="control-label">Selecionar Imagens:</label>
                          <input id="logo6" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          <div id="respLogo6"></div>                    
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="idLogo" value="6"> 
                      <button type="submit" class="btn btn-success" >Inserir Logo</button>
                    </div>
                  </div><!-- /.box -->
                  </form>
              </div><!-- /.col -->

          </div>
            
            
      
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