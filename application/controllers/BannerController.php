<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BannerController extends CI_Controller {

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
		$this->load->model('bannersDao_model');
	}


    public function viewLista($offset=0){

        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
        $open['assetsCSS'] = 'banner/banner-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imagens';
        $data['mainNavSub'] = 'banners';
		$data['subMainNav'] = 'listaBanners';
		$this->load->view('paginas/banner/lista',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
        $footer['assetsJs'] = 'banner/banner-home.js';
        $this->load->view('include/footer',$footer);
    }

	public function listaBannersDataTables(){

        $fetch_data = $this->bannersDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){

            $situacao = '';
            if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>';
            }else if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';
            }

            $sub_array = array();
            $sub_array[] = '<img src="'.IMAGEM_BANNER.$row->imagem.'" class="img-rounded  imgList" />';
            $sub_array[] = $row->nome;
            $sub_array[] = $row->url;
            $sub_array[] = $situacao;
            $sub_array[] = '<a href="'.base_url('BannerController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('BannerController/excluirBanner/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->bannersDao_model->get_all_data(),
            "recordsFiltered" => $this->bannersDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }


	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $open['assetsCSS'] = 'banner/banner-cadastro.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imagens';
        $data['mainNavSub'] = 'banners';
		$data['subMainNav'] = 'cadastroBanner';
		$this->load->view('paginas/banner/cadastro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'banner/banner-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarBanner(){

        $nome   = $this->input->post('nome');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$url   = $this->input->post('url');
		$situacao   = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');

		$friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($imagens)){
			$mensagem[] = 'A <b>IMAGEM</b> do programa é Obrigatória.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do programa é Obrigatório.';
		}

		/**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		$nome_existente = $this->bannersDao_model->nome_disponivel($nome);
		if (count($nome_existente) > 0){
			$mensagem[] = 'Nome <b>'.$nome.'</b> já cadastrado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'bannerController/viewCadastro','refresh');
		}
		else{

			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = null;
			$data['nome'] = $nome;
			$data['imagem'] = $novo_nome_imagem;
			$data['url'] = $url;
			$data['ativo'] = $situacao;
			$data['site_novo'] = $site_novo;


			if($this->bannersDao_model->insertBanner($data)){

				if(!empty($novo_nome_imagem)){
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/banners/'.$novo_nome_imagem);
					chmod('assets/img/banners/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}

				$this->session->set_flashdata('resultado_ok','Banner <b>'.$nome.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'BannerController/viewLista','refresh');
			}
			else {

				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Banner!');
				redirect(base_url() . 'BannerController/viewLista','refresh');
			}

		}
    }

	public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
		$open['assetsCSS'] = 'banner/banner-cadastro.css';

        $this->load->view('include/openDoc',$open);

		$data['banner'] = $this->bannersDao_model->selectBannerById($id);
		$this->load->view('paginas/banner/alterar',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'banner/banner-cadastro.js';

		$this->load->view('include/footer',$footer);
	}


	public function alterarBanner(){

		$id = $this->input->post('id');
        $nome = $this->input->post('nome');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$url = $this->input->post('url');
		$situacao = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');

		$dadosAtuais = $this->bannersDao_model->selectBannerById($id);

		$friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do programa é Obrigatório.';
		}

		/**
		* VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		*/
		if($nome != $dadosAtuais[0]->nome){
			$nome_existente = $this->bannersDao_model->nome_disponivel($nome);
			if(count($nome_existente) > 0){
				$mensagem[] = 'Nome <b>'.$nome.'</b> já cadastrado.';
			}
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'BannerController/viewAlterar/'.$id,'refresh');
		}
		else{

			if(!empty($imagens)){
				chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($nome !== $dadosAtuais[0]->titulo){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dadosAtuais[0]->imagem));
				}else{
					$novo_nome_imagem = $dadosAtuais[0]->imagem;
				}
			}

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['id'] = $id;
			$data['nome'] = $nome;
			$data['imagem'] = $novo_nome_imagem;
			$data['url'] = $url;
			$data['ativo'] = $situacao ;
			$data['site_novo'] = $site_novo;

			if($this->bannersDao_model->updateBanner($data)){

				if(!empty($imagens)){
					unlink('assets/img/banners/'.$dadosAtuais[0]->imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/banners/'.$novo_nome_imagem);
					chmod('assets/img/banners/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/banners/'.$dadosAtuais[0]->imagem,'assets/img/banners/'.$novo_nome_imagem);
				}

				$this->session->set_flashdata('resultado_ok','Banner <b>'.$nome.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'BannerController/viewLista','refresh');
			}
			else {

				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Banner!');
				redirect(base_url() . 'BannerController/viewLista','refresh');
			}

		}
    }

    function excluirBanner($id){

		$dadosAtuais = $this->bannersDao_model->selectBannerById($id);

        if($this->bannersDao_model->deleteBanner($id)){

			unlink('assets/img/banners/' . $dadosAtuais[0]->imagem);

            $this->session->set_flashdata('resultado_ok', 'Exclusão de Banner efetuada com sucesso!');
            redirect(base_url() . 'BannerController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir a Banner!');
            redirect(base_url() . 'BannerController/viewLista','refresh');
        }
	}


}
