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
          <?php $nome = explode(' ' ,$this->session->userdata("nomeUsuario")); ?>
          <p><?php echo $nome[0] . ' ' . $nome[1] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
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
        <li <?php echo (isset($mainNav) && $mainNav == 'aovivo')? 'class="active"':'' ?>>
          <a href="<?php echo base_url('AovivoController/viewAovivo') ?>">
            <i class="fa fa-youtube-play text-red"></i> <span>Ao vivo</span>
          </a>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'videos')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-video-camera"></i> <span>Vídeos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroVideo')? 'class="active"':'' ?>><a href="<?php echo base_url('VideosController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaVideos')? 'class="active"':'' ?>><a href="<?php echo base_url('VideosController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'podcasts')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-microphone text-purple"></i> <span>Podcast</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <small class="label pull-right bg-green">novo</small>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroPodcast')? 'class="active"':'' ?>><a href="<?php echo base_url('PodcastController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaPodcast')? 'class="active"':'' ?>><a href="<?php echo base_url('PodcastController/viewLista') ?>"><i class="fa fa-circle-o"></i> Lista</a></li>
          </ul>
        </li>
         <li <?php echo (isset($mainNav) && $mainNav == 'comentarios')? 'class="active"':'' ?>>
          <a href="<?php echo base_url('ComentariosController/viewComentarios') ?>">
            <i class="fa fa-commenting-o text-blue"></i> <span>Comentários</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">novo</small>
              </span>
          </a>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'programas')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-film"></i> <span>Programas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroPrograma')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramasController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaProgramas')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramasController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'imagens')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>Imagens Site</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($mainNavSub) && $mainNavSub == 'slideShow')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-red"></i> SlideShow
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroSlide')? 'class="active"':'' ?>><a href="<?php echo base_url('SlideShowController/viewCadastro') ?>"><i class="fa fa-circle-o primary"></i> Cadastro SlideShow</a></li>
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'listaSlides')? 'class="active"':'' ?>><a href="<?php echo base_url('SlideShowController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista SlideShow</a></li>
              </ul>
            </li>
            <li <?php echo (isset($mainNavSub) && $mainNavSub == 'banners')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-yellow"></i> Banners
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroBanner')? 'class="active"':'' ?>><a href="<?php echo base_url('BannerController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro Banner</a></li>
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'listaBanners')? 'class="active"':'' ?>><a href="<?php echo base_url('BannerController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista Banner</a></li>
              </ul>
            </li>
            <li <?php echo (isset($mainNavSub) && $mainNavSub == 'testeiras')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-aqua"></i> Testeiras
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroTesteira')? 'class="active"':'' ?>><a href="<?php echo base_url('TesteiraController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro Testeira</a></li>
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'listaTesteiras')? 'class="active"':'' ?>><a href="<?php echo base_url('TesteiraController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista Testeira</a></li>
              </ul>
            </li>
            <li <?php echo (isset($mainNavSub) && $mainNavSub == 'logos')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-blue"></i> Logos Footer
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'listaLogos')? 'class="active"':'' ?>><a href="<?php echo base_url('LogosController/viewLista') ?>"><i class="fa fa-circle-o"></i> Lista Logos</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'programacao')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-table"></i> <span>Programação</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroProgramacao')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramacaoController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'envioArquivo')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramacaoController/viewArquivo') ?>"><i class="fa fa-circle-o"></i> Envio de Arquivo</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaProgramacao')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramacaoController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'imprensa')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa  fa-newspaper-o"></i> <span>Imprensa</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li <?php echo (isset($subMainNav) && $subMainNav == 'imprensa')? 'class="active"':'' ?>><a href="<?php echo base_url('ImprensaController/viewImprensa') ?>"><i class="fa fa-circle-o"></i> Imprensa</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'apresentadores')? 'class="active"':'' ?>><a href="<?php echo base_url('imprensaController/viewApresentadores') ?>"><i class="fa fa-circle-o"></i> Apresentadores</a></li>

          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'comoAssistir')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa  fa-tv"></i> <span>Como Assistir</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
							<small class="label pull-right bg-green">novo</small>
            </span>
          </a>
          <ul class="treeview-menu">
          	<li <?php echo (isset($subMainNav) && $subMainNav == 'outrosCanais')? 'class="active"':'' ?>><a href="<?php echo base_url('ComoAssistirController/viewOutrosCanais') ?>"><i class="fa fa-circle-o"></i> Outros Canais</a></li>
						<li <?php echo (isset($subMainNav) && $subMainNav == 'oiTv')? 'class="active"':'' ?>><a href="<?php echo base_url('ComoAssistirController/viewOiTv') ?>"><i class="fa fa-circle-o"></i> Oi TV</a></li>
						<li <?php echo (isset($subMainNav) && $subMainNav == 'internet')? 'class="active"':'' ?>><a href="<?php echo base_url('ComoAssistirController/viewInternet') ?>"><i class="fa fa-circle-o"></i> Internet</a></li>
						<li <?php echo (isset($subMainNav) && $subMainNav == 'tvAberta')? 'class="active"':'' ?>><a href="<?php echo base_url('ComoAssistirController/viewTvAberta') ?>"><i class="fa fa-circle-o"></i> TV Aberta</a></li>

          </ul>
				</li>
		<li <?php echo (isset($mainNav) && $mainNav == 'parceriasInstitucionais')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-thumbs-up"></i> <span>Parcerias Institucionais</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'texto')? 'class="active"':'' ?>><a href="<?php echo base_url('ParceriasInstitucionaisController/viewTexto') ?>"><i class="fa fa-circle-o"></i> Texto</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'lista')? 'class="active"':'' ?>><a href="<?php echo base_url('ParceriasInstitucionaisController/viewLista') ?>"><i class="fa fa-circle-o"></i> Lista</a></li>
          </ul>
        </li>
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
        <li <?php echo (isset($mainNav) && $mainNav == 'noticias')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Notícias</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroNoticia')? 'class="active"':'' ?>><a href="<?php echo base_url('NoticiasController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaNoticias')? 'class="active"':'' ?>><a href="<?php echo base_url('NoticiasController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'figurinos')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-female" aria-hidden="true"></i><i class="fa fa-male" aria-hidden="true"></i>
            <span>Figurino</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <small class="label pull-right bg-green">novo</small>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'cadastroFigurino')? 'class="active"':'' ?>><a href="<?php echo base_url('FigurinoController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaFigurinos')? 'class="active"':'' ?>><a href="<?php echo base_url('FigurinoController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
          </ul>
        </li>
        <li <?php echo (isset($mainNav) && $mainNav == 'relatorios')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Relatórios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <small class="label pull-right bg-green">novo</small>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('RelatoriosControllerAnalytics/oauth2callback') ?>"><i class="fa fa-unlock-alt text-red"></i> Autenticar Google</a></li>
            <li <?php echo (isset($mainNavSub) && $mainNavSub == 'analytics')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-green"></i> Google Analytics
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'publico')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatoriosControllerAnalytics/visaoGeral') ?>"><i class="fa fa-user text-purple"></i> Público</a></li>
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'aquisicao')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatoriosControllerAnalytics/aquisicao') ?>"><i class="fa fa-share-alt text-green"></i> Aquisição</a></li>
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'comportamento')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatoriosControllerAnalytics/comportamento') ?>"><i class="fa fa-desktop text-purple"></i> Comportamento</a></li>
              </ul>
            </li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'relatoriosAcessos')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatorioAcessosController/relatorioDeAcessos') ?>"><i class="fa fa-circle-o text-yellow"></i> Vídeos Mais Acessados</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'relatoriosDownloads')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatorioDownloadsController/relatorioDeDownload') ?>"><i class="fa fa-circle-o text-aqua"></i> Vídeos Mais Baixados</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'relatoriosStreaming')? 'class="active"':'' ?>><a href="<?php echo base_url('RelatorioStreamingController/relatorioStreaming') ?>"><i class="fa fa-circle-o text-purple"></i> Streaming Canal Saúde</a></li>
          </ul>
        </li>


        <li class="header">SISTEMAS</li>
        <li <?php echo (isset($mainNav) && $mainNav == 'producaoAudioVisual')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-sitemap text-green"></i>
            <span>Produção AudioVisual</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-left"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="http://157.86.124.178/nova_intranet" target="_blank">
                <i class="fa fa-circle-o text-red"></i> <span>Fluxo de Produção</span>
                <span class="pull-right-container">
                  <small class="label pull-right bg-green">novo</small>
                </span>
              </a>
            </li>
	        <li <?php echo (isset($mainNavSub) && $mainNavSub == 'sistemasMidias')?'class="active treeview"':'class="treeview"' ?>>
              <a href="#"><i class="fa fa-circle-o text-blue"></i> Sistema de Mídias
                <span class="pull-right-container">
                <small class="label pull-right bg-green">novo</small><i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <!--<li <?php echo (isset($subMainNav) && $subMainNav == 'listarProgramas')? 'class="active"':'' ?>><a href="<?php echo base_url('midiasController/viewLista') ?>"><i class="fa fa-circle-o text-red"></i> Programas Casa</a></li>-->
                 <li <?php echo (isset($subMainNav) && $subMainNav == 'listarProgramasParceiros')? 'class="active"':'' ?>><a href="<?php echo base_url('midiasParceirosController/viewProgramasParceiros') ?>"><i class="fa fa-circle-o text-red"></i> Programas Parceiros</a></li>
              </ul>
            </li>
            <li>
	          <a href="<?php echo base_url('Product_filter/index') ?>" target="_blank">
	            <i class="fa fa-circle-o text-yellow"></i> <span>Fluxo</span>
	            <span class="pull-right-container">
	              <small class="label pull-right bg-red">antigo</small>
	            </span>
	          </a>
	        </li>
          </ul>
        </li>

        <li><a href="https://www.canal.fiocruz.br/" target="_blank"><i class="fa fa-circle-o text-aqua"></i><span>Site Canal Saúde</span></a></li>
        
        <li <?php echo (isset($mainNav) && $mainNav == 'restrito')?'class="active treeview"':'class="treeview"' ?>>
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Acesso Restrito</span>
           <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (isset($subMainNav) && $subMainNav == 'restrito')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewCadastro') ?>"><i class="fa fa-circle-o"></i> Cadastro</a></li>
            <li <?php echo (isset($subMainNav) && $subMainNav == 'listaUsuarios')? 'class="active"':'' ?>><a href="<?php echo base_url('RestritoController/viewLista') ?>"><i class="fa fa-circle-o"></i> lista</a></li>
             <li <?php echo (isset($subMainNav) && $subMainNav == 'listaProgramas')? 'class="active"':'' ?>><a href="<?php echo base_url('ProgramasController/viewLista') ?>"><i class="fa fa-circle-o"></i> Acessar Arquivos</a></li>
          </ul>
        </li>
         <li class="header"></li>
      </ul>

      <a href="http://coopas.tv.br/" target="_blank"><img src="<?php echo base_url()?>assets/img/logos/logo_coopas.png" class="img-responsive img-thumbnail" style="margin-left:33%;margin-top:20px;" ></a>

    </section>
    <!-- /.sidebar -->


  </aside>
