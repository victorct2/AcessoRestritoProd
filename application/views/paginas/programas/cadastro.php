<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Programas
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('ProgramasController/viewLista') ?>">Sistema de Programas</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <form action="<?php echo base_url('ProgramasController/cadastrarPrograma') ?>" method="POST">
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
            
            
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                    <label for="nome">Nome Programa:</label>
                    <input type="text" name="titulo" class="form-control" id="nome" placeholder="Informe o nome">
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="5" placeholder="Descrição ..."></textarea>
                </div>

                <div class="form-group">
                    <label for="apresentadorPrograma">Apresentador do Programa:</label>
                    <input type="text" name="apresentadorPrograma" class="form-control" id="apresentadorPrograma" placeholder="Informe o Apresentador do Programa">
                </div>

                <div class="form-group">
                    <label>Descrição Aplicativo</label>
                    <textarea name="descricaoApp" class="form-control" rows="5" placeholder="Descrição Aplicativo..."></textarea>
                </div>              

                <div class="form-group">
                    <label>Temas Possíveis</label>
                    <textarea name="temasPossiveis" class="form-control" rows="5" placeholder="Temas Possíveis..."></textarea>
                </div>

                <div class="form-group">
                    <label>Público Alvo</label>
                    <textarea name="publicoAlvo" class="form-control" rows="5" placeholder="Público Alvo..."></textarea>
                </div>
                
                
              </div>
              <!-- /.col -->
              <div class="col-md-6">

                <div class="form-group">
                    <label for="horarioInedito">Horário Inédito:</label>
                    <input type="text" name="horarioInedito" class="form-control" id="horarioInedito" placeholder="Informe o Horário Inédito">
                </div>
                
                <div class="form-group">
                    <label>Horários Alternativos</label>
                    <textarea name="horarioAlternativo" class="form-control" rows="5" placeholder="Horários Alternativos..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="nome">Ano de Estréia:</label>
                    <input type="number" name="anoEstreia" class="form-control" id="anoEstreia" placeholder="Informe o ano de estréia">
                </div>

                <div class="form-group">
                    <label for="periodicidade">Periodicidade:</label>
                    <input type="text" name="periodicidade" class="form-control" id="periodicidade" placeholder="Informe o Periodicidade">
                </div>

                <div class="form-group">
                  <label>Duração:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="duracao" class="form-control"  data-inputmask='"mask": "99:99:99"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
                  
                <div class="form-group">
                    <label for="sigla">Sigla:</label>
                    <input type="text" name="sigla" class="form-control" id="sigla" placeholder="Informe a sigla">
                </div>

                <div class="form-group">
                  <label>Aplicativo</label>
                  <select name="aplicativo" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Mostrar no Novo Site</label>
                  <select name="site_novo" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Mostrar na busca</label>
                  <select name="busca_site" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">SIM</option>
                    <option value="N">NÃO</option>
                  </select>
                </div>

                
                
                <div class="form-group">
                  <label>Mostrar no Site Antigo</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>

              
                <button type="submit" class="btn btn-primary" >Cadastrar</button>
                

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->

        <div class="row">

            <div class="col-md-3">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem Programa</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                      <label for="imagens" class="control-label">Selecionar Imagens:</label>
                      <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="resp"></div>                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-3">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem Programação / No Ar</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                      <label for="imagemProgramacao" class="control-label">Selecionar Imagem Programação:</label>
                      <input id="imagemProgramacao" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="respImagemProgramacao"></div>                    
                  </div>
                </div><!-- /.box-body -->                
              </div><!-- /.box -->
            </div><!-- /.col -->


            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem App</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                      <label for="imagemApp" class="control-label">Selecionar Imagem App:</label>
                      <input id="imagemApp" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="respImagemApp"></div>                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-3">
              <div class="box box-danger box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem Programa Apresentador</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">                    
                  <div class="form-group">
                      <label for="imagemApresentador" class="control-label">Selecionar Imagem Apresentador:</label>
                      <input id="imagemApresentador" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="respImagemApresentador"></div>                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->


           
          </div><!-- /.row -->




      </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 