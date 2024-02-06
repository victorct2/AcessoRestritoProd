<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VideosController extends CI_Controller {

    function __construct() {
		parent:: __construct();

        if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos) || in_array("12", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

        $this->load->model('videosDao_model');
        $this->load->model('programasDao_model');

	}

    public function viewLista(){
        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'videos/videos-list.css';
        $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'videos';
        $data['subMainNav'] = 'listaVideos';
        $data['listProgramas'] = $this->programasDao_model->listarProgramas();
        $this->load->view('paginas/videos/lista',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'videos/videos-home.js';
        $this->load->view('include/footer',$footer);
    }


    public function listaVideosDataTables(){

        $fetch_data = $this->videosDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){



            $destaque = ($row->destaque == 'S')? '<span class="label pull-right bg-blue">Destaque</span><br>': '';
            $situacao = '';
            if($row->situacao == 'ATIVO'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>';
            }else if($row->situacao == 'INATIVO'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';
            }
            else if($row->situacao == 'INCOMPLETO'){
                $situacao = '<span class="label pull-right bg-yellow">INCOMPLETO</span><br>';
            }

            $sub_array = array();
            //$sub_array[] = '<img src="'.IMAGEM_VIDEO.$row->imagem.'" class="img-rounded imgList" width="250" height="150" />';
            $sub_array[] = '<img src="'.base_url().'assets/img/videos/'.$row->imagem.'" class="img-rounded imgList" width="210" height="150" />';
            $sub_array[] = $row->nome;
            $sub_array[] = $row->descricao;
            $sub_array[] = '<span class="label pull-right bg-navy">'.$row->titulo.'</span><br>';
            $sub_array[] = '<span class="label pull-right bg-teal">'. $row->data_video .'</span><br>';
            $sub_array[] = $destaque.$situacao;
            $sub_array[] = '<a href="'.base_url().'/VideosController/viewAlterar/'.$row->id.'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                       <a class="btn btn-app assistir fancybox.ajax" href="'.base_url().'VideosController/assistirVideo/'.$row->id.'"  title="'.$row->nome.'"><i class="fa fa-play"></i> Assistir</a>
                       <a href="https://www.canalsaude.fiocruz.br/canal/videoAberto/'.$row->friendly_url.'" target="_blank" class="btn btn-app"><i class="fa fa-youtube-play"></i> Ver no Site</a>
                       <a href="'.base_url().'/VideosController/viewClosedCaption/'.$row->id.'" class="btn btn-app"><i class="fa fa-cc"></i> Closed Caption</a>
                       <a class="btn btn-app" href="'.base_url().'VideosController/excluirVideo/'.$row->id.'"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->videosDao_model->get_all_data(),
            "recordsFiltered" => $this->videosDao_model->get_filtered_data(),
            "data" => $data
        );
        //echo $this->db->last_query();
        echo json_encode($output);
    }

    function assistirVideo($idVideo=0){

        $arquivo = $this->videosDao_model->arquivoVideo($idVideo);
        $video = $this->videosDao_model->selectVideoById($idVideo);
        $data['img'] = base_url().'assets/img/videos/'.$video[0]->imagem;

        foreach ($arquivo as $a) {
            if($a->id_taxa == 5){
                $data['url'] = "https://intranet.canalsaude.fiocruz.br/streaming/".$a->nome;
                break;
            }else if($a->id_taxa == 4){
                $data['url'] = "https://intranet.canalsaude.fiocruz.br/streaming/".$a->nome;
                break;
            }else if($a->id_taxa == 3){
                $data['url'] = "https://intranet.canalsaude.fiocruz.br/streaming/".$a->nome;
                break;
            }else if($a->id_taxa == 2){
                $data['url'] = "https://intranet.canalsaude.fiocruz.br/streaming/".$a->nome;
                break;
            }else if($a->id_taxa == 1){
                $data['url'] = "https://intranet.canalsaude.fiocruz.br/streaming/".$a->nome;
                break;
            }
        }

        $this->load->view('paginas/videos/assistir',$data);
    }


	public function viewCadastro(){
        $open['assetsBower'] = 'select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'videos/videos-cadastro.css';
        $this->load->view('include/openDoc',$open);

        /*$caminhoVideo = $_SERVER['DOCUMENT_ROOT'] . '/canalintranet/uploadVideos/arquivos/';
        echo $caminhoVideo;*/

        $data['listProgramas'] = $this->programasDao_model->listarProgramas();
        $data['mainNav'] = 'videos';
		$data['subMainNav'] = 'cadastroVideo';
		$this->load->view('paginas/videos/cadastro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'videos/videos-cadastro.js';

		$this->load->view('include/footer',$footer);
    }

    /**
	* Verificando O LOGIN
	*/
	function nomeExistente(){
		$nomeUsuario = $this->input->post('nomeUsuario');
		$nome_atual = $this->videosDao_model->nome_disponivel($nomeUsuario);
		if (count($nome_atual) > 0) {
			echo 'false';
		}else{
			echo 'success';
		}
	}

    public function adicionarVideo(){

       /* echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit();*/

        $nome = $this->input->post('nome');
        $numeroPgm = $this->input->post('numeroPgm');
        $descricao = $this->input->post('descricao');
        $programa = $this->input->post('programa');
        $duracao = $this->input->post('duracao');
        $dataExibicao = $this->input->post('dataExibicao');
        $situacao = $this->input->post('situacao');
        $destaque = $this->input->post('destaque');
        $conferencia = $this->input->post('conferencia');
        $coronavirus = $this->input->post('coronavirus');
        $imagem = $this->input->post('hidden_imagem');
        $videos = is_array($this->input->post('listVideos'))? $this->input->post('listVideos') : null;

        $friendly_url = getRawUrl($nome);
        $mensagem = array();
        $nome_atual = $this->videosDao_model->nome_disponivel($nome);

        if (count($nome_atual) > 0){
			$mensagem[] = '<b>NOME</b> de vídeo já cadastrado.';
		}

		if(empty($nome)){
			$mensagem[] = 'O campo <b>NOME</b> é obrigatório.';
		}

		if(empty($programa)){
			$mensagem[] = 'O campo <b>PROGRAMA</b> é obrigatório.';
		}

		if(empty($duracao)){
			$mensagem[] = 'O campo <b>DURAÇÃO</b> é obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'O campo <b>SITUAÇÃO</b> é obrigatório.';
		}

		if(empty($destaque)){
			$mensagem[] = 'O campo <b>DESTAQUE</b> é obrigatório.';
		}

		if(empty($videos[0])){
			$mensagem[] = 'O campo <b>UPLOAD VIDEO</b> é obrigatório.';
		}

		if(empty($dataExibicao)){
			$mensagem[] = 'O <b>DATA DE EXIBIÇÃO</b> da programação é Obrigatória.';
		}else if(!validaData($dataExibicao)){
			$mensagem[] = '<b>DATA</b> Inválida.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'VideosController/viewCadastro/','refresh');
        }
        else{

            $novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagem));
			chmod('uploadVideos/videos/img/'.$imagem, 0777);
			rename('uploadVideos/videos/img/'.$imagem, 'uploadVideos/videos/img/'.$novo_nome_imagem);

            $data['id'] = null;
			$data['nome'] = $nome;
            $data['descricao'] = $descricao;
            $data['numeroPgm'] = $numeroPgm;
			$data['duracao'] = $duracao;
			$data['imagem'] = $novo_nome_imagem;
			$data['data_video'] = converteDataBanco($dataExibicao);
			$data['sequencia_programa'] =  $this->videosDao_model->gerarSequencia($programa);
			$data['friendly_url'] = $friendly_url;
			$data['decs'] = '';
			$data['situacao'] = $situacao;
            $data['destaque'] = $destaque;
            $data['xvconferencia'] = $conferencia;
            $data['id_programa'] = $programa;
            $data['coronavirus'] = $coronavirus;


            if($this->videosDao_model->insertVideo($data,$videos[0],$novo_nome_imagem)){

                $nomeDelete = explode('.',$videos[0]);
                unlink('uploadVideos/arquivos/'.$videos[0]);
                unlink('uploadVideos/arquivos/'.$nomeDelete[0].'_240.txt');
                unlink('uploadVideos/arquivos/'.$nomeDelete[0].'_720.txt');


                $this->session->set_flashdata('resultado_ok','Vídeo <b>'.$nome.'</b> Cadastrado com sucesso!');
                redirect(base_url() . 'VideosController/viewLista','refresh');

            }else{

                $this->session->set_flashdata('resultado_error','Erro ao Cadastrar o Vídeo <b>'.$nome.'</b>!');
                redirect(base_url() . 'VideosController/viewLista','refresh');

            }

        }


    }

    public function viewAlterar($idVideo){
        $open['assetsBower'] = 'select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,videojs/video-js.css,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'videos/videos-cadastro.css';
        $this->load->view('include/openDoc',$open);

        $data['listProgramas'] = $this->programasDao_model->listarProgramas();
        $data['video'] = $this->videosDao_model->selectVideoById($idVideo);
        $data['arquivo'] = $this->videosDao_model->selectArquivoByIdVideo($idVideo);

        $data['mainNav'] = 'videos';
        $this->load->view('paginas/videos/alterar',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,videojs/video.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'videos/videos-alterar.js';

		$this->load->view('include/footer',$footer);
    }

    public function alterarVideo(){

       /* echo '<pre>';
        print_r($_POST);
        echo '</pre>';*/


        $idVideo = $this->input->post('idVideo');
        $nome = $this->input->post('nome');
        $numeroPgm = $this->input->post('numeroPgm');
        $descricao = $this->input->post('descricao');
        $programa = $this->input->post('programa');
        $apresentador = $this->input->post('apresentador');
        $diretor = $this->input->post('diretor');
        $reporter = $this->input->post('reporter');
        $convidados = $this->input->post('convidados');
        $produtor = $this->input->post('produtor');
        $entrevistados = $this->input->post('entrevistados');
        $tags = $this->input->post('tags');
        $duracao = $this->input->post('duracao');
        $dataExibicao = $this->input->post('dataExibicao');
        $situacao = $this->input->post('situacao');
        $destaque = $this->input->post('destaque');
        $conferencia = $this->input->post('conferencia');
        $coronavirus = $this->input->post('coronavirus');
        $videos = is_array($this->input->post('listVideos'))? $this->input->post('listVideos') : null;
        $imagem = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;

        $friendly_url = getRawUrl($nome);
        $mensagem = array();
        $dadosAtuais = $this->videosDao_model->selectVideoById($idVideo);


        if ($dadosAtuais[0]->nome != $nome){
            $nome_existente = $this->videosDao_model->nome_disponivel($nome);
            if (count($nome_existente) > 0){
                $mensagem[] = '<b>NOME</b> de vídeo já cadastrado.';
            }
        }


        if(empty($nome)){
            $mensagem[] = 'O campo <b>NOME</b> é obrigatório.';
        }

        if(empty($programa)){
            $mensagem[] = 'O campo <b>PROGRAMA</b> é obrigatório.';
        }

        if(empty($duracao)){
            $mensagem[] = 'O campo <b>DURAÇÃO</b> é obrigatório.';
        }

        if(empty($situacao)){
            $mensagem[] = 'O campo <b>SITUAÇÃO</b> é obrigatório.';
        }

        if(empty($destaque)){
            $mensagem[] = 'O campo <b>DESTAQUE</b> é obrigatório.';
        }


        if(empty($dataExibicao)){
            $mensagem[] = 'O <b>DATA DE EXIBIÇÃO</b> da programação é Obrigatória.';
        }else if(!validaData($dataExibicao)){
            $mensagem[] = '<b>DATA</b> Inválida.';
        }

        if (count($mensagem) > 0) {
            $this->session->set_flashdata('mensagem',$mensagem);
            redirect(base_url() . 'VideosController/viewAlterar/'.$idVideo,'refresh');
        }
        else{

            $atualizarImagem = false;
            if(!is_null($imagem)){
                $novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagem[0]));
                chmod('uploadImagens/arquivos/'.$imagem[0], 0777);
                rename('uploadImagens/arquivos/'.$imagem[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);
                $atualizarImagem = true;
            }else{
                $novo_nome_imagem = $dadosAtuais[0]->imagem;
            }


            $data['id'] = $idVideo;
            $data['nome'] = $nome;
            $data['descricao'] = $descricao;
            $data['numeroPgm'] = $numeroPgm;
            $data['duracao'] = $duracao;
            $data['imagem'] = $novo_nome_imagem;
            $data['data_video'] = converteDataBanco($dataExibicao);
            if($dadosAtuais[0]->id_programa != $programa){
				$data['sequencia_programa'] =  $this->videosDao_model->gerarSequencia($programa);
			}else{
                $data['sequencia_programa'] =  $dadosAtuais[0]->sequencia_programa;
            }
            //$data['sequencia_programa'] =  $this->videosDao_model->gerarSequencia($programa);
            $data['friendly_url'] = $friendly_url;
            $data['decs'] = '';
            $data['situacao'] = $situacao;
            $data['destaque'] = $destaque;
            $data['xvconferencia'] = $conferencia;
            $data['id_programa'] = $programa;
            $data['apresentador'] = $apresentador;
            $data['diretor'] = $diretor;
            $data['produtor'] = $produtor;
            $data['reporter'] = $reporter;
            $data['convidados'] = $convidados;
            $data['entrevistados'] = $entrevistados;
            $data['tags'] = $tags;
            $data['coronavirus'] = $coronavirus;


            if($this->videosDao_model->updateVideo($data,$videos[0],$novo_nome_imagem,$dadosAtuais,$atualizarImagem)){

                $nomeDelete = explode('.',$videos[0]);
                unlink('uploadVideos/arquivos/'.$videos[0]);
                unlink('uploadVideos/arquivos/'.$nomeDelete[0].'_240.txt');
                unlink('uploadVideos/arquivos/'.$nomeDelete[0].'_720.txt');

                $this->session->set_flashdata('resultado_ok','Vídeo <b>'.$nome.'</b> Alterado com sucesso!');
                redirect(base_url() . 'VideosController/viewLista','refresh');

            }else{
                $this->session->set_flashdata('resultado_error','Erro ao Alterar o Vídeo <b>'.$nome.'</b>!');
                redirect(base_url() . 'VideosController/viewLista','refresh');

            }

        }

    }

    function excluirVideo($idVideo){

        $arquivosArray = $this->videosDao_model->selectArquivoByIdVideo($idVideo);
        $dados_atuais = $this->videosDao_model->selectVideoById($idVideo);

        if($this->videosDao_model->deleteVideo($idVideo)){

            unlink('assets/img/videos/' . $dados_atuais[0]->imagem);

            foreach($arquivosArray as $arquivo){
                if($arquivo->id_formato == 3){
                    unlink('streaming/'.$arquivo->nome);
                }elseif($arquivo->id_formato == 2){
                    unlink('download/'.$arquivo->nome);
                }
            }

            $this->session->set_flashdata('resultado_ok', 'Vídeo <b>'.$dados_atuais[0]->nome.'</b> Excluído com sucesso!');
            redirect(base_url() . 'VideosController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir o Vídeo <b>'.$dados_atuais[0]->nome.'</b>!');
            redirect(base_url() . 'VideosController/viewLista','refresh');
        }
    }

     function ajustarFriendlyUrl(){
        $videos = $this->videosDao_model->allVideos();
        foreach ($videos as $video) {
            $arrayNome = explode('#',$video->nome);
            $nome1= getRawUrl($arrayNome[0]);
            if($arrayNome[1] != ''){
                $nome2 = explode('-',$arrayNome[1]);
                $novaUrl= $nome1.'-'.trim($nome2[0]).'-'.trim($nome2[1]);
            }else{
                $novaUrl= $nome1;
            }

            if($this->videosDao_model->updateFriendlyUrl($novaUrl,$video->id)){
                echo 'Sucesso';
            }else{
                echo 'Deu ruim';
            }
        }
    }

    function atualizarVideoByFichaConclusao(){
        $videos = $this->videosDao_model->allVideos();
        foreach ($videos as $video) {
            if($this->videosDao_model->updateAllVideosDados($video->id,$video->numeroPgm,$video->id_programa)){
                echo 'Vídeo Atualizado com sucesso<br>';
            }else{
                echo 'Erro ao atualizar o Vídeo<br>';
            }
        }
    }


    function viewClosedCaption($idVideo){
        $open['assetsBower'] = 'select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,videojs/video-js.css,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'videos/videos-cadastro.css';
        $this->load->view('include/openDoc',$open);

        $data['video'] = $this->videosDao_model->selectVideoById($idVideo);
        $arquivo = $this->videosDao_model->arquivoVideo($idVideo);
        foreach ($arquivo as $a) {
            if($a->id_taxa == 5){
                $data['arquivo'] = $a->nome;
                break;
            }else if($a->id_taxa == 4){
                $data['arquivo'] = $a->nome;
                break;
            }else if($a->id_taxa == 3){
                $data['arquivo'] = $a->nome;
                break;
            }else if($a->id_taxa == 2){
                $data['arquivo'] = $a->nome;
                break;
            }else if($a->id_taxa == 1){
                $data['arquivo'] = $a->nome;
                break;
            }
        }
        $data['closedCaption'] = $this->videosDao_model->selectClosedCaptionByIdVideo($idVideo);

        $data['mainNav'] = 'videos';
        $this->load->view('paginas/videos/viewClosedCaption',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,videojs/video.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'videos/videos-closedCaption.js';

		$this->load->view('include/footer',$footer);
    }

    public function modalInserirClosedCaption(){
		$data['idVideo'] = $this->input->post('idVideo');
		$this->load->view('paginas/videos/modalInserirClosedCaption',$data);
	}

	public function modalAlterarClosedCaption(){
		$idClosedCaption = $this->input->post('idClosedCaption');
		$data['idClosedCaption'] = $idClosedCaption;
		$data['closedCaption'] = $this->videosDao_model->selectClosedCaptionById($idClosedCaption);
		$this->load->view('paginas/videos/modalAlterarClosedCaption',$data);
    }

    public function inserirClosedCaption(){
        $label   = $this->input->post('label');
		$arquivo = is_array($this->input->post('listaArquivos'))? $this->input->post('listaArquivos') : null;
		$srcLang   = $this->input->post('srcLang');
		$default   = $this->input->post('default');
		$status   = $this->input->post('status');
		$video_id   = $this->input->post('idVideo');

		$friendly_url = getRawUrl($label.'_'.$srcLang.'_'.$video_id);
		$mensagem = array();

		if(empty($label)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($arquivo)){
			$mensagem[] = 'O <b>ARQUIVO VTT</b> do Closed Caption é Obrigatório.';
		}



		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
		}
		else{

			chmod('uploadArquivos/arquivos/'.$arquivo[0], 0777);
			$novo_nome_arquivo = $friendly_url . '.' . @end(explode(".",$arquivo[0]));
			rename( 'uploadArquivos/arquivos/'.$arquivo[0],  'uploadArquivos/arquivos/'.$novo_nome_arquivo);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = null;
            $data['closedCaption'] = $novo_nome_arquivo;
            $data['label'] = $label;
            $data['srclang'] = $srcLang;
			$data['default'] = $default;
			$data['video_id'] = $video_id;
			$data['status'] = $status;


			if($this->videosDao_model->insertClosedCaption($data)){

				if(!empty($novo_nome_arquivo)){
					copy('uploadArquivos/arquivos/'.$novo_nome_arquivo, 'assets/closedCaption/'.$novo_nome_arquivo);
					chmod('assets/closedCaption/'.$novo_nome_arquivo, 0777);
					unlink('uploadArquivos/arquivos/'.$novo_nome_arquivo);
				}

				$this->session->set_flashdata('resultado_ok','Closed Caption <b>'.$label.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Closed Caption!');
				redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
			}

		}
    }

    public function alterarClosedCaption(){
        $idClosedCaption   = $this->input->post('idClosedCaption');
        $label   = $this->input->post('label');
		$arquivo = is_array($this->input->post('listaArquivos'))? $this->input->post('listaArquivos') : null;
		$srcLang   = $this->input->post('srcLang');
		$default   = $this->input->post('default');
		$status   = $this->input->post('status');

        $dadosAtuais = $this->videosDao_model->selectClosedCaptionById($idClosedCaption);
        $video_id   = $dadosAtuais[0]->video_id;
		$friendly_url = getRawUrl($label.'_'.$srcLang.'_'.$video_id);
		$mensagem = array();



		if(empty($label)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}



		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
		}
		else{

            if(!empty($arquivo)){
                chmod('uploadArquivos/arquivos/'.$arquivo[0], 0777);
                $novo_nome_arquivo = $friendly_url . '.' . @end(explode(".",$arquivo[0]));
                rename( 'uploadArquivos/arquivos/'.$arquivo[0],  'uploadArquivos/arquivos/'.$novo_nome_arquivo);
            }else {
                $friendly_url = $friendly_url.'.vtt';
                $novo_nome_arquivo = $friendly_url;

            }



			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = $idClosedCaption;
            $data['closedCaption'] = $novo_nome_arquivo;
            $data['label'] = $label;
            $data['srclang'] = $srcLang;
			$data['default'] = $default;
			$data['status'] = $status;


			if($this->videosDao_model->updateClosedCaption($data)){

                if(!empty($arquivo)){
                    if(!empty($novo_nome_arquivo)){
                        unlink('assets/closedCaption/'.$dadosAtuais[0]->closedCaption);
                        copy('uploadArquivos/arquivos/'.$novo_nome_arquivo, 'assets/closedCaption/'.$novo_nome_arquivo);
                        chmod('assets/closedCaption/'.$novo_nome_arquivo, 0777);
                        unlink('uploadArquivos/arquivos/'.$novo_nome_arquivo);

                    }
                }else if(!empty($arquivo) && $dadosAtuais[0]->closedCaption != $novo_nome_arquivo){
                    rename( 'assets/closedCaption/'.$dadosAtuais[0]->closedCaption,  'assets/closedCaption/'.$novo_nome_arquivo);
                }

				$this->session->set_flashdata('resultado_ok','Closed Caption <b>'.$label.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Closed Caption!');
				redirect(base_url() . 'VideosController/viewClosedCaption/'.$video_id,'refresh');
			}

		}
    }

    function upload(){

       $this->load->library("upload");
        $this->upload->initialize(array(
                "upload_path" => './uploadVideos/arquivos/',
                'allowed_types' => 'mp4|mov|dif|flv|mkv|wmv|rmvb|vob|mpg|dv|mxf',
                "overwrite" => FALSE,
                "max_filename" => 0,
                "encrypt_name" => TRUE,
        ));

        $successful = $this->upload->do_upload('userfile');
        $fileName = '';

        if($successful)
        {
            $data = $this->upload->data();
            $image_file = $data['file_name'];
            $msg = "<p>File: {$image_file}</p>";
            $fileName = $image_file;
            //$this->data_models->update($this->data->INFO, array("image" => $image_file));
        } else {

            $msg = $this->upload->display_errors();
        }

        echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);

    }

    public function excluirClosedCaption(){
        $id = $this->input->post('id');
        $dadosAtuais = $this->videosDao_model->selectClosedCaptionById($id);

        if($this->videosDao_model->deleteClosedCaption($id)){
			unlink('assets/closedCaption/' . $dadosAtuais[0]->closedCaption);
            echo true;
        }
        else {
            echo false;
        }
    }

}
