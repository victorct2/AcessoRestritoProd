<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo IMAGEM_AVATAR.$this->session->userdata("avatar")?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <?php $nome = $this->session->userdata("nomeUsuario"); ?>
          <p><?php echo $nome ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
	  <!--INICIO DO COMENT REDES SOCIAUS--> <section>
	  <li class="header">
	  <div class=col-xs-3 >   
       <a href="https://www.facebook.com/coopastv/" target="_blank"><img src="https://coopas.tv.br/acessorestrito/assets/img/face-icone.png" alt="icone facebook" class="img-responsive"></a>
	  </div>
	  
	  <div class=col-xs-3 >
       <a href="https://www.instagram.com/coopas_/" target="_blank"><img src="https://coopas.tv.br/acessorestrito/assets/img/insta-icone.png" alt="icone instagram"  class="img-responsive"></a>
	  </div>
	  <div class=col-xs-3 >   
       <a href="https://api.whatsapp.com/send?phone=5521982680822&text=" target="_blank"><img src="https://coopas.tv.br/acessorestrito/assets/img/WhatsApp-icone.png" alt="icone whatsapp"  class="img-responsive"></a> 
	  </div>  
	  </li>
	  </section>
	  
      <li>''</li><!--FIM DO COMENT REDES SOCIAIS-->
        <li class="header">MENU NAVEGAÇÃO</li>
        <li <?php echo (isset($mainNav) && $mainNav == 'home')? 'class="active"':'' ?> >
          <a href="<?php echo base_url('Home') ?>">
            <i class="fa fa-th"></i> <span>Home</span>
          </a>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'perfil')? 'class="active"':'' ?>>
          <a href="<?php echo base_url('UsuariosController/viewPerfil') ?>">
            <i class="fa fa-user-circle text-yellow"></i> <span>Perfil</span>
          </a>
        </li>
		<?php $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("50", $grupos)) {
			?>
        <li <?php echo (isset($mainNav) && $mainNav == 'usuarios')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-user"></i> <span>Usuários</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroUsuario')? 'class="active"':'' ?>><a href="<?php echo base_url('UsuariosController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaUsuarios')? 'class="active"':'' ?>><a href="<?php echo base_url('UsuariosController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
		
		<?php } else{?>
			<li>  </li>
		<?php }?>
        
       
      <?php if(in_array("1", $grupos) || in_array("50", $grupos)) { ?>
        <li <?php echo (isset($mainNav) && $mainNav == 'grupos')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-users"></i> <span>Grupos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroGrupo')? 'class="active"':'' ?>><a href="<?php echo base_url('GruposController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaGrupos')? 'class="active"':'' ?>><a href="<?php echo base_url('GruposController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
		<?php } else{?>
			<li> </li>
		<?php }?>

         <li <?php echo (isset($mainNav) && $mainNav == 'restrito')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-lock "></i> <span>Acesso Restrito</span>
           <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		   <?php if(in_array("1", $grupos) || in_array("50", $grupos)) { ?>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'restrito')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a> <?php } else{?>
			<li> </li>
			<?php }?></li>
			<?php if(in_array("1", $grupos) || in_array("50", $grupos)) {?>
			<li <?php echo (isset($subMainNav) && $subMainNav == 'restrito')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewCadastroGeral') ?>"><i class="fa fa-circle-o"></i> Arquivo Para todos</a><?php } else{?>
			<li> </li>
			<?php }?></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'restrito')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
            <?php if(in_array("1", $grupos) || in_array("50", $grupos)) {?>
			<li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroGrupo')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewCadastroArquivo') ?>"><i class="fa fa-circle-o"></i> Cadastro Tipo de Arquivo</a><?php } else{?>
			<li> </li>
			<?php }?></li>             
          </ul>
        </li>

        
		 <?php if(in_array("1", $grupos) || in_array("50", $grupos)) {?>
         <li <?php echo (isset($mainNav) && $mainNav == 'avisos')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Avisos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroAvisos')? 'class="active"':'' ?>><a href="<?php echo base_url('AvisosController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaAvisos')? 'class="active"':'' ?>><a href="<?php echo base_url('AvisosController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
		<?php } else{?>
			<li> </li>
			<?php }?>
		     <li <?php echo (isset($mainNav) && $mainNav == 'envio')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-upload "></i> <span>Envio de arquivos</span>
           <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'envio')? 'class="active"':'' ?>><a href="<?php echo base_url('EnvioController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'envio')? 'class="active"':'' ?>><a href="<?php echo base_url('EnvioController/viewLista') ?>"><i class="fa fa-circle-o"></i> Arquivos Enviados</a></li>           
          </ul>
        </li>
		 <li <?php echo (isset($mainNav) && $mainNav == 'perfil')? 'class="active"':'' ?>>
          <a href="https://coopas.tv.br/acessorestrito/assets/arquivos/Manual Intranet COOPAS.pdf" target="_blank">
            <i class="fa fa-book"></i> <span>Manual do Usuário</span>
          </a>
        </li>
        <br>
        <a href="http://coopas.tv.br/" target="_blank">&nbsp&nbsp&nbsp&nbsp<img  class="whatsapp" src="http://coopas.tv.br/acessorestrito/assets/img/logo-verde-claro.png" width="30px"></i><span>Site COOPAS</span></a>
        <br>
        <br>
        <br>
          <!--<li class="header">Redes Sociais</li>
        <!--<li <?php# echo (isset($mainNav) && $mainNav == 'producaoAudioVisual')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-sitemap text-green"></i>
            <span>Produção AudioVisual</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-left"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li>
              <a href="http://157.86.124.178/nova_intranet" target="_blank">
                <i class="fa fa-circle-o text-red"></i> <span>Fluxo de Produção</span>
                <span class="pull-right-container">
                  <small class="label pull-right bg-green">novo</small>
                </span>
              </a>
            </li> -->
          <!--<li <?php #echo (isset($mainNavSub) && $mainNavSub == 'sistemasMidias')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-blue"></i> Sistema de Mídias
                <span class="pull-right-container">
                <small class="label pull-right bg-green">novo</small><i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <!--<li <?php #echo (isset($subMainNav) && $subMainNav == 'listarProgramas')? 'class="active"':'' ?>><a href="<?php #echo base_url('midiasController/viewLista') ?>"><i class="fa fa-circle-o text-red"></i> Programas Casa</a></li>-->
                <!-- <li <?php# echo (isset($subMainNav) && $subMainNav == 'listarProgramasParceiros')? 'class="active"':'' ?>><a href="<?php# echo base_url('midiasParceirosController/viewProgramasParceiros') ?>"><i class="fa fa-circle-o text-red"></i> Programas Parceiros</a></li>
              </ul>
	    </li>-->

           <!-- <li>
            <a href="<?php echo base_url('Plataformas') ?>" target="_blank">
              <i class="fa fa-circle-o text-yellow"></i> <span>Fluxo</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-red">antigo</small>
              </span>
            </a>
          </li>-->
          </ul>
        </li>

     

        


       
       


        
    <!-- /.sidebar -->


  </aside>
