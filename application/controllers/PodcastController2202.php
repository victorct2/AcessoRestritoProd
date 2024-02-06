<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PodcastController extends CI_Controller {

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
		$this->load->model('PodcastDao_model');

		$this->load->helper('download');
	}


    public function viewLista($offset=0){

        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
        $open['assetsCSS'] = 'podcast/podcast-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'podcasts';
		$data['subMainNav'] = 'listaPodcast';
		$this->load->view('paginas/podcast/lista',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
        $footer['assetsJs'] = 'podcast/podcast-home.js';
        $this->load->view('include/footer',$footer);
    }

	public function listaPodcastDataTables(){

        $fetch_data = $this->PodcastDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){         

            $situacao = '';
            if($row->status == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>'; 
            }else if($row->status == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';  
            }   			        

            $sub_array = array();  
            $sub_array[] = '<img src="'.IMAGEM_PODCAST.$row->imagem.'" class="img-rounded  imgList" />';  
            $sub_array[] = $row->titulo;  
            $sub_array[] = $row->descricao;   
            $sub_array[] = $situacao;
            $sub_array[] = '<a href="'.base_url('PodcastController/viewEpisodios/'.$row->id).'" class="btn btn-app bg-blue"><i class="fa fa-microphone"></i> Episódios</a>
            				<a href="'.base_url('PodcastController/viewAlterar/'.$row->id).'" class="btn btn-app bg-yellow"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('PodcastController/excluirPodcast/'.$row->id).'" class="btn btn-app bg-red"><i class="fa fa-trash"></i> Excluir</a>';  
            
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->PodcastDao_model->get_all_data(),  
            "recordsFiltered" => $this->PodcastDao_model->get_filtered_data(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }

	
	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
		$open['assetsCSS'] = 'podcast/podcast-cadastro.css';
        
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'podcasts';
		$data['subMainNav'] = 'cadastroPodcast';
		$this->load->view('paginas/podcast/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js,ckeditor/ckeditor.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'podcast/podcast-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarPodcast(){

        $titulo   = $this->input->post('titulo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$descricao   = $this->input->post('descricao');
		$link_anchor   = $this->input->post('link_anchor');
		$link_spotify   = $this->input->post('link_spotify');
		$link_google   = $this->input->post('link_google');
		$link_apple   = $this->input->post('link_apple');
		$link_deezer   = $this->input->post('link_deezer');
		$link_pocket   = $this->input->post('link_pocket');
		$link_breaker   = $this->input->post('link_breaker');
		$link_radioPublic   = $this->input->post('link_radioPublic');
		$status   = $this->input->post('status');

		$friendly_url = getRawUrl($titulo);
		$mensagem = array();

		if(empty($titulo)){
			$mensagem[] = 'O <b>TÍTULO</b> do podcast é Obrigatório.';
		}

		if(empty($imagens)){
			$mensagem[] = 'A <b>IMAGEM</b> do podcast é Obrigatória.';
		}

		if(empty($status)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do podcast é Obrigatório.';
		}

		/**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		$titulo_existente = $this->PodcastDao_model->titulo_disponivel($titulo);
		if (count($titulo_existente) > 0){
			$mensagem[] = 'TÍTULO <b>'.$titulo.'</b> já cadastrado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'PodcastController/viewCadastro','refresh');
		}
		else{

			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = null;
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['friendly_url'] = $friendly_url;
			$data['link_anchor'] = $link_anchor;
			$data['link_spotify'] = $link_spotify;
			$data['link_google'] = $link_google;
			$data['link_apple'] = $link_apple;
			$data['link_deezer'] = $link_deezer;
			$data['link_pocket'] = $link_pocket;
			$data['link_breaker'] = $link_breaker;
			$data['link_radioPublic'] = $link_radioPublic;
			$data['status'] = $status;
			

			if($this->PodcastDao_model->insertPodcast($data)){

				if(!empty($novo_nome_imagem)){
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/podcast/'.$novo_nome_imagem);
					chmod('assets/img/podcast/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}
                
				$this->session->set_flashdata('resultado_ok','Podcast <b>'.$titulo.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'PodcastController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Podcast!');
				redirect(base_url() . 'PodcastController/viewLista','refresh');
			}

		}
    }

	public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
		$open['assetsCSS'] = 'podcast/podcast-cadastro.css';
        
        $this->load->view('include/openDoc',$open);

		$data['podcast'] = $this->PodcastDao_model->selectPodcastById($id);
		$this->load->view('paginas/podcast/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js,ckeditor/ckeditor.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'podcast/podcast-cadastro.js';

		$this->load->view('include/footer',$footer);
	}


	public function alterarPodcast(){

		$id = $this->input->post('id');
        $titulo   = $this->input->post('titulo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$descricao   = $this->input->post('descricao');
		$link_anchor   = $this->input->post('link_anchor');
		$link_spotify   = $this->input->post('link_spotify');
		$link_google   = $this->input->post('link_google');
		$link_apple   = $this->input->post('link_apple');
		$link_deezer   = $this->input->post('link_deezer');
		$link_pocket   = $this->input->post('link_pocket');
		$link_breaker   = $this->input->post('link_breaker');
		$link_radioPublic   = $this->input->post('link_radioPublic');
		$status   = $this->input->post('status');
		

		$dadosAtuais = $this->PodcastDao_model->selectPodcastById($id);

		$friendly_url = getRawUrl($titulo);
		$mensagem = array();

		if(empty($titulo)){
			$mensagem[] = 'O <b>TÍTULO</b> do podcast é Obrigatório.';
		}
		
		if(empty($status)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do podcast é Obrigatório.';
		}

		/**
		* VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		*/
		if($titulo != $dadosAtuais[0]->titulo){
			$titulo_existente = $this->PodcastDao_model->titulo_disponivel($titulo);
			if (count($titulo_existente) > 0){
				$mensagem[] = 'TÍTULO <b>'.$titulo.'</b> já cadastrado.';
			}
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'PodcastController/viewAlterar/'.$id,'refresh');
		}
		else{

			if(!empty($imagens)){
				chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($titulo !== $dadosAtuais[0]->titulo){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dadosAtuais[0]->imagem));
				}else{
					$novo_nome_imagem = $dadosAtuais[0]->imagem;
				}				
			}	

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = $id;
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['friendly_url'] = $friendly_url;
			$data['link_anchor'] = $link_anchor;
			$data['link_spotify'] = $link_spotify;
			$data['link_google'] = $link_google;
			$data['link_apple'] = $link_apple;
			$data['link_deezer'] = $link_deezer;
			$data['link_pocket'] = $link_pocket;
			$data['link_breaker'] = $link_breaker;
			$data['link_radioPublic'] = $link_radioPublic;
			$data['status'] = $status;

			if($this->PodcastDao_model->updatePodcast($data)){

				if(!empty($imagens)){
					unlink('assets/img/podcast/'.$dadosAtuais[0]->imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/podcast/'.$novo_nome_imagem);
					chmod('assets/img/podcast/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/podcast/'.$dadosAtuais[0]->imagem,'assets/img/podcast/'.$novo_nome_imagem);
				}
                
				$this->session->set_flashdata('resultado_ok','Podcast <b>'.$titulo.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'PodcastController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Podcast!');
				redirect(base_url() . 'PodcastController/viewLista','refresh');
			}

		}
	}
	
	
	public function viewEpisodios($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,jqueryUi/jquery-ui.min.css';
		$open['assetsCSS'] = 'podcast/podcast-cadastro.css';
        
        $this->load->view('include/openDoc',$open);

		$data['podcast'] = $this->PodcastDao_model->selectPodcastById($id);
		$data['listEpisodios'] = $this->PodcastDao_model->listarEpisodios($id);
		$this->load->view('paginas/podcast/episodios',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js,ckeditor/ckeditor.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'podcast/episodio.js';

		$this->load->view('include/footer',$footer);
	}

	public function episodioDownload($idEpisodio){
		$episodio = $this->PodcastDao_model->selectEpisodioById($idEpisodio);
		$arquivoPath = file_get_contents(URL_PODCAST_DOWNLOAD.$episodio[0]->midia);
        force_download($episodio[0]->titulo,$arquivoPath,FALSE);
    }

	public function modalInserirEpisodio(){
		$data['idPodcast'] = $this->input->post('idPodcast');
		$this->load->view('paginas/podcast/modalInserirEpisodio',$data);
	}

	public function modalAlterarEpisodio(){
		$idEpisodio = $this->input->post('idEpisodio');
		$data['episodio'] = $this->PodcastDao_model->selectEpisodioById($idEpisodio);
		$data['nomeVideo'] = $this->PodcastDao_model->selectNomeVideoById($data['episodio'][0]->video_id);		
		$this->load->view('paginas/podcast/modalAlterarEpisodio',$data);
	}

	public function videosSearch(){
		$nomeVideo = $this->input->get('q');
		$data = $this->PodcastDao_model->listarVideos($nomeVideo);
		echo json_encode($data);
	}

	public function inserirEpisodio(){

        $titulo   = $this->input->post('titulo');
		$descricao   = $this->input->post('descricao');
		$arquivo = is_array($this->input->post('listaArquivos'))? $this->input->post('listaArquivos') : null;
        $dataEpisodio   = $this->input->post('data');
		$embed   = $this->input->post('embed');
		$idPodcast   = $this->input->post('idPodcast');
		$status   = $this->input->post('status');
		$idVideo   = $this->input->post('idVideo');

		$friendly_url = getRawUrl($titulo.'_'.$dataEpisodio);
		$mensagem = array();

		if(empty($titulo)){
			$mensagem[] = 'O <b>TÍTULO</b> do episódio é Obrigatório.';
		}
		
		if(empty($status)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do episódio é Obrigatório.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
		}
		else{

			chmod('uploadArquivos/arquivos/'.$arquivo[0], 0777);
			$novo_nome_arquivo = $friendly_url . '.' . @end(explode(".",$arquivo[0]));
			rename( 'uploadArquivos/arquivos/'.$arquivo[0],  'uploadArquivos/arquivos/'.$novo_nome_arquivo);
		
			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = null;
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;
			$data['data'] = converteDataBanco($dataEpisodio);
			$data['embed'] = $embed;
			$data['midia'] = $novo_nome_arquivo;
			$data['podcast_id'] = $idPodcast;
			$data['status'] = $status;
			$data['video_id'] = $idVideo;

			if($this->PodcastDao_model->insertEpisodio($data)){

				
				if(!empty($novo_nome_arquivo)){
					copy('uploadArquivos/arquivos/'.$novo_nome_arquivo, 'assets/podcast/'.$novo_nome_arquivo);
					chmod('assets/podcast/'.$novo_nome_arquivo, 0777);
					unlink('uploadArquivos/arquivos/'.$novo_nome_arquivo);
				}

				$this->session->set_flashdata('resultado_ok','Episódio <b>'.$titulo.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Episódio!');
				redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
			}

		}
	}

	public function alterarEpisodio(){

		
        $id   = $this->input->post('id');
		$idPodcast   = $this->input->post('idPodcast');
        $titulo   = $this->input->post('titulo');
        $descricao   = $this->input->post('descricao');
        $dataEpisodio   = $this->input->post('data');
		$embed   = $this->input->post('embed');
		$idPodcast   = $this->input->post('idPodcast');
		$status   = $this->input->post('status');
		$idVideo   = $this->input->post('idVideo');
		$arquivo = is_array($this->input->post('listaArquivos'))? $this->input->post('listaArquivos') : null;
		$midiaExcluir = !is_null($this->input->post('midiaExcluir'))? $this->input->post('midiaExcluir') : 'N';
		$mensagem = array();

		$friendly_url = getRawUrl($titulo.'_'.$dataEpisodio);
		$episodioAtual = $this->PodcastDao_model->selectEpisodioById($id);

		if(empty($titulo)){
			$mensagem[] = 'O <b>TÍTULO</b> do episódio é Obrigatório.';
		}
		
		if(empty($status)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do episódio é Obrigatório.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
		}
		else{

			@chmod('uploadArquivos/arquivos/'.$arquivo[0], 0777);
			$novo_nome_arquivo = $friendly_url . '.' . @end(explode(".",$arquivo[0]));
			@rename( 'uploadArquivos/arquivos/'.$arquivo[0],  'uploadArquivos/arquivos/'.$novo_nome_arquivo);
		
			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = $id;
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;
			$data['data'] = converteDataBanco($dataEpisodio);
			$data['embed'] = $embed;
			$data['midia'] = ($midiaExcluir == 'S' && $arquivo == null)? '':$novo_nome_arquivo;
			$data['podcast_id'] = $idPodcast;
			$data['status'] = $status;
			$data['video_id'] = $idVideo;

			if($this->PodcastDao_model->updateEpisodio($data)){

				if($midiaExcluir == 'S' && $arquivo == null){
					@unlink('assets/podcast/'.$episodioAtual[0]->midia);
				}else if($midiaExcluir == 'N' && $arquivo == null && $novo_nome_arquivo != $episodioAtual[0]->midia){
					@rename('assets/podcast/'.$episodioAtual[0]->midia,  'assets/podcast/'.$novo_nome_arquivo);
				}

				if(!empty($novo_nome_arquivo)){
					@unlink('assets/podcast/'.$episodioAtual[0]->midia);
					@copy('uploadArquivos/arquivos/'.$novo_nome_arquivo, 'assets/podcast/'.$novo_nome_arquivo);
					@chmod('assets/podcast/'.$novo_nome_arquivo, 0777);
					@unlink('uploadArquivos/arquivos/'.$novo_nome_arquivo);
				}

				$this->session->set_flashdata('resultado_ok','Episódio <b>'.$titulo.'</b> foi alterado com sucesso!');
				redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Episódio!');
				redirect(base_url() . 'PodcastController/viewEpisodios/'.$idPodcast,'refresh');
			}

		}
	}



    function excluirpodcast($id){

		$dadosAtuais = $this->PodcastDao_model->selectpodcastById($id);
		$midiasAtuais = $this->PodcastDao_model->selectAllEpisodiosDoPodcast($id);

        if($this->PodcastDao_model->deletePodcast($id)){

			unlink('assets/img/podcast/' . $dadosAtuais[0]->imagem);
			foreach ($midiasAtuais as $value) {
				unlink('assets/podcast/' . $value->midia);
			}			

            $this->session->set_flashdata('resultado_ok', 'Exclusão de Podcast efetuada com sucesso!');
            redirect(base_url() . 'PodcastController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir a Podcast!');
            redirect(base_url() . 'PodcastController/viewLista','refresh');
        }
	}

    function excluirEpisodio(){

		$id = $this->input->post('id');
		$dadosAtuais = $this->PodcastDao_model->selectEpisodioById($id);

        if($this->PodcastDao_model->deleteEpisodio($id)){			
			unlink('assets/podcast/' . $dadosAtuais[0]->midia);
           	echo true;
        }
        else {
            echo false;
        }
	}


}