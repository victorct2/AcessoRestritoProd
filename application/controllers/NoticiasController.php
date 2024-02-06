<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoticiasController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }
		$this->load->model('noticiasDao_model');

	}


    public function viewLista($offset=0){

		$open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
		$open['assetsCSS'] = 'noticias/noticias-list.css';
		$open['pluginCSS'] = 'iCheck/all.css,jqueryUi/jquery-ui.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'noticias';
		$data['subMainNav'] = 'listaNoticias';
		$this->load->view('paginas/noticias/lista',$data);

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'noticias/noticias-home.js,noticias/noticias-legendaImagem.js';
        $this->load->view('include/footer',$footer);
    }

	public function listaNoticiasDataTables(){

        $fetch_data = $this->noticiasDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){

            $situacao = '';
            if($row->ativa == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>';
            }else if($row->ativa == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';
			}

			$releaseNoticia = '';
			if($row->releaseNoticia == 'N'){
				$releaseNoticia = '<span class="label pull-right bg-yellow">NOTÍCIA</span><br>';
			}else if($row->releaseNoticia == 'R'){
				$releaseNoticia = '<span class="label pull-right bg-navy">RELEASE</span><br>';
			}else if($row->releaseNoticia == 'NR'){
				$releaseNoticia = '<span class="label pull-right bg-teal">NOTÍCIA E RELEASE</span><br>';
			}

			$linkLegenda = '';
			$imagem = '';
			$arrayImagem = $this->noticiasDao_model->selectImagemNoticiasById($row->id);
			if(count($arrayImagem)>0){
				$linkLegenda ='<a href="#" id="'.$row->id.'" class="btn btn-app bg-blue" data-toggle="modal" data-target="#modal-incluirLegenda"><i class="fa fa-file-image-o"></i> Legenda Foto</a>';
				$imagem = '<img src="'.IMAGEM_NOTICIA.$arrayImagem[0]->nomeImagem.'" class="img-rounded  imgList" width="210" height="150" />';
			}else{
				$imagem = '<img src="'.SEM_IMAGEM.'" class="img-rounded  imgList" width="210" height="150" />';
			}

			$sub_array = array();
			$sub_array[] = $imagem;
            $sub_array[] = converteDataInterface($row->dia);
            $sub_array[] = $row->descricao;
            $sub_array[] = $row->sinopse;
            $sub_array[] = $situacao.$releaseNoticia;
			$sub_array[] = $linkLegenda.'<a href="'.base_url('NoticiasController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('NoticiasController/apagarNoticias/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->noticiasDao_model->get_all_data(),
            "recordsFiltered" => $this->noticiasDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }


	public function viewCadastro(){

		$open['assetsBower'] = 'select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'jqueryUi/jquery-ui.min.css,bootstrap-fileinput/css/fileinput.min.css';
    $open['assetsCSS'] = 'noticias/noticias-cadastro.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'noticias';
		$data['subMainNav'] = 'cadastroNoticia';
		$this->load->view('paginas/noticias/cadastro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,ckeditor/ckeditor.js';
		$footer['pluginJS'] = 'input-mask/jquery.inputmask.js,jqueryUi/jquery-ui.min.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'noticias/noticias-cadastro.js';
		$this->load->view('include/footer',$footer);
	}

    public function cadastrarNoticias(){

        $descricao = $this->input->post('descricao');
		$sinopse = $this->input->post('sinopse');
		$subtitulo = $this->input->post('subtitulo');
		$link = $this->input->post('link');
		$linkVideo = $this->input->post('linkVideo');
		$legendaVideo = $this->input->post('legendaVideo');
		$codigoEmbed = $this->input->post('codigoEmbed');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$releaseNoticia = $this->input->post('releaseNoticia');
        $dia = $this->input->post('dia');
        $situacao = $this->input->post('situacao');
		$descricaoCompleta = $this->input->post('descricaoCompleta');
		$site_novo = $this->input->post('site_novo');
		$friendly_url = getRawUrl($dia.$imagens[0]);
        $mensagem = array();

        if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> da notícia é Obrigatório.';
		}

		if(empty($sinopse)){
			$mensagem[] = 'A <b>SINOPSE</b> de exibição da notícia é Obrigatória.';
		}

		if(empty($descricaoCompleta)){
			$mensagem[] = 'A <b>DESCRIÇÃO COMPLETA</b> da notícia é Obrigatória.';
		}

		if(empty($dia)){
			$mensagem[] = 'A <b>DATA</b> da notícia é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> da notícia é Obrigatória.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'NoticiasController/viewCadastro/','refresh');
		}
		else{


			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['descricao'] = $descricao;
			$data['sinopse'] = $sinopse;
			$data['subtitulo'] = $subtitulo;
			$data['descricao_completa'] = $descricaoCompleta;
			$data['link'] = $link;
			$data['friendly_url'] = getRawUrl($descricao.$dia);
			$data['linkVideo'] = $linkVideo;
			$data['legendaVideo'] = $legendaVideo;
			$data['dia'] = converteDataBanco($dia) ;
			$data['codigoEmbed'] = $codigoEmbed;
			$data['releaseNoticia'] = $releaseNoticia;
			$data['ativa'] = $situacao;
			$data['site_novo'] = $site_novo;
			$data['id'] = null;


			if($this->noticiasDao_model->insertNoticia($data,$imagens)){
				$this->session->set_flashdata('resultado_ok','Notícia cadastrada com sucesso!');
				redirect(base_url() . 'NoticiasController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Notícia!');
				redirect(base_url() . 'NoticiasController/viewLista','refresh');
			}

		}

    }

    public function viewAlterar($id){

		$open['assetsBower'] = 'select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'jqueryUi/jquery-ui.min.css,bootstrap-fileinput/css/fileinput.min.css';
    $open['assetsCSS'] = 'noticias/noticias-cadastro.css';
        $this->load->view('include/openDoc',$open);

		$data['noticias'] = $this->noticiasDao_model->selectNoticiasById($id);
		$data['imagensNoticias'] = $this->noticiasDao_model->selectImagemNoticiasById($id);
		$this->load->view('paginas/noticias/alterar',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,ckeditor/ckeditor.js';
		$footer['pluginJS'] = 'input-mask/jquery.inputmask.js,jqueryUi/jquery-ui.min.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'noticias/noticias-cadastro.js';
		$this->load->view('include/footer',$footer);
	}

    public function alterarNoticias(){

        $id = $this->input->post('id');
        $descricao = $this->input->post('descricao');
		$sinopse = $this->input->post('sinopse');
		$subtitulo = $this->input->post('subtitulo');
		$link = $this->input->post('link');
		$linkVideo = $this->input->post('linkVideo');
		$legendaVideo = $this->input->post('legendaVideo');
		$codigoEmbed = $this->input->post('codigoEmbed');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$imagensExcluir = is_array($this->input->post('imagensExcluir'))? $this->input->post('imagensExcluir') : null;
		$releaseNoticia = $this->input->post('releaseNoticia');
        $dia = $this->input->post('dia');
        $situacao = $this->input->post('situacao');
		$descricaoCompleta = $this->input->post('descricaoCompleta');
		$site_novo = $this->input->post('site_novo');
        $mensagem = array();

        if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> da notícia é Obrigatório.';
		}

		if(empty($sinopse)){
			$mensagem[] = 'A <b>SINOPSE</b> de exibição da notícia é Obrigatória.';
		}

		if(empty($descricaoCompleta)){
			$mensagem[] = 'A <b>DESCRIÇÃO COMPLETA</b> da notícia é Obrigatória.';
		}

		if(empty($dia)){
			$mensagem[] = 'A <b>DATA</b> da notícia é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> da notícia é Obrigatória.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'NoticiasController/viewAlterar/'.$id,'refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['descricao'] = $descricao;
			$data['sinopse'] = $sinopse;
			$data['subtitulo'] = $subtitulo;
			$data['descricao_completa'] = $descricaoCompleta;
			$data['link'] = $link;
			$data['friendly_url'] = getRawUrl($descricao.$dia);
			$data['linkVideo'] = $linkVideo;
			$data['legendaVideo'] = $legendaVideo;
			$data['dia'] = converteDataBanco($dia) ;
			$data['codigoEmbed'] = $codigoEmbed;
			$data['releaseNoticia'] = $releaseNoticia;
			$data['ativa'] = $situacao;
			$data['site_novo'] = $site_novo;
			$data['id'] = $id;


			if($this->noticiasDao_model->updateNoticia($data,$imagens,$imagensExcluir)){
				$this->session->set_flashdata('resultado_ok','Notícia cadastrada com sucesso!');
				redirect(base_url() . 'NoticiasController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Notícia!');
				redirect(base_url() . 'NoticiasController/viewLista','refresh');
			}

		}

    }

    public function apagarNoticias($id){
        if($this->noticiasDao_model->deleteNoticias($id)){
            $this->session->set_flashdata('resultado_ok', 'Exclusão da Notícia foi efetuada com sucesso!');
            redirect(base_url() . 'NoticiasController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir a Notícia!');
            redirect(base_url() . 'NoticiasController/viewLista','refresh');
        }
	}

	public function gerarFriendlyUrl(){
		$noticias = $this->noticiasDao_model->noticiasNotFriendlyUrl();
		echo $this->db->last_query();
		echo count($noticias);
        foreach ($noticias as $noticia) {
            if($this->noticiasDao_model->updateFriendlyUrl($noticia)){
				echo $this->db->last_query();
                echo 'Notícia Atualizado com sucesso<br>';
            }else{
                echo 'Erro ao atualizar a Notícia<br>';
            }
        }
	}


	public function modalIncluirLegenda(){
		$idNoticia = $this->input->post('idNoticia');
		$data['noticias'] = $this->noticiasDao_model->selectNoticiasById($idNoticia);
		$data['imagensNoticias'] = $this->noticiasDao_model->selectImagemNoticiasById($idNoticia);
		$this->load->view('paginas/noticias/modalIncluirLegenda',$data);
	}

	public function adicionarLegenda(){

		$legendaImagem = $this->input->post('legendaImagem');

		if($this->noticiasDao_model->updateLegendaImagem($legendaImagem)){
			$this->session->set_flashdata('resultado_ok','Legenda cadastrada com sucesso!');
			redirect(base_url() . 'NoticiasController/viewLista/', 'refresh');
		}else{
			$this->session->set_flashdata('resultado_error','erro ao cadastrar a Legenda!');
			redirect(base_url() . 'NoticiasController/viewLista/', 'refresh');
		}
	}


  function upload(){

  		$this->load->library("upload");
  		 $this->upload->initialize(array(
  				 "upload_path" => './uploadImagens/arquivos/',
  				 'allowed_types' => 'png|jpg|jpeg|png|gif|psd',
  				 "overwrite" => FALSE,
  				 "max_filename" => 0,
  				 "encrypt_name" => TRUE,
  				 'multi' => 'all'
  		 ));

  		 $successful = $this->upload->do_upload('userfile');
  		 $fileName = array();
  		 $data = array();

  		 if($successful)
  		 {
  			$data[] = $this->upload->data();
  			$resp =  is_array($data);

  			if(count($data[0])>6){
  				foreach ($data as $key => $value) {
  					$fileName[] = $value['file_name'];
  				}
  			}else{
  				foreach ($data as $key => $value) {
  					if(count($value)> 1){
  						foreach ($value as $file) {
  							$fileName[] = $file['file_name'];
  						}
  					}
  				}
  			}



  		 } else {

  			 $msg = $this->upload->display_errors();
  		 }

  		 echo json_encode(['result' => $successful, 'file_name'=>$fileName]);

  	 }

}
