<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SlideShowController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'HOME', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }
		$this->load->model('slideShowDao_model');

	}


    public function viewLista($offset=0){

		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'slideShow/slideShow-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imagens';
        $data['mainNavSub'] = 'slideShow';
		$data['subMainNav'] = 'listaSlides';
		$this->load->view('paginas/slideShow/lista',$data);

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
		$footer['assetsJs'] = 'slideShow/slideShow-home.js';
        $this->load->view('include/footer',$footer);

    }

	public function listaSlideDataTables(){

        $fetch_data = $this->slideShowDao_model->make_datatables();

        $data = array();
        foreach($fetch_data as $row){
			$situacao = '';
            if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>';
            }else if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';
            }

            $sub_array = array();
            $sub_array[] = '<img src="'. IMAGEM_SLIDESHOW.$row->imagem .'" class=" imgList" width="500" height="160" />';
            $sub_array[] = $row->nome;
            $sub_array[] = $row->descricao;
			$sub_array[] = $row->url;
			$sub_array[] = $situacao;
            $sub_array[] = '<a href="'.base_url('SlideShowController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('SlideShowController/excluirSlide/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->slideShowDao_model->get_all_data(),
            "recordsFiltered" => $this->slideShowDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }


	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $open['assetsCSS'] = 'slideShow/slideshow-cadastro.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imagens';
        $data['mainNavSub'] = 'slideShow';
		$data['subMainNav'] = 'cadastroSlide';
		$this->load->view('paginas/slideShow/cadastro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'slideShow/slideShow-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarSlide(){

		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit();*/

		$nome   = $this->input->post('nome');
		$descricao   = $this->input->post('descricao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$url   = $this->input->post('url');
		$situacao   = $this->input->post('situacao');
		$friendly_url = '';
		$mensagem = array();

		if($nome != ''){
			$friendly_url = getRawUrl($nome);
		}else{
			$friendly_url = geraSenha().getRawUrl(@end(explode(".",$imagens[0])));
		}

		if(empty($imagens)){
			$mensagem[] = 'A IMAGEM do programa é Obrigatória.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A SITUAÇÃO do programa é Obrigatório.';
		}

		/**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		/*$nome_existente = $this->slideShowDao_model->nome_disponivel($nome);
		if (count($nome_existente) > 0){
			$mensagem[] = 'Nome já cadastrado.';
		}*/

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'SlideShowController/viewCadastro','refresh');
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
			$data['descricao'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['url'] = $url;
			$data['ativo'] = $situacao ;

			if($this->slideShowDao_model->insertSlide($data)){

				if(!empty($novo_nome_imagem)){
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/slideshow/'.$novo_nome_imagem);
					chmod('assets/img/slideshow/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}

				$this->session->set_flashdata('resultado_ok','SlideShow cadastrado com sucesso!');
				redirect(base_url() . 'SlideShowController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o SlideShow!');
				redirect(base_url() . 'SlideShowController/viewLista','refresh');
			}

		}
    }

	public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $open['assetsCSS'] = 'slideShow/slideshow-cadastro.css';

        $this->load->view('include/openDoc',$open);

		$data['slideShow']=$this->slideShowDao_model->slideShowById($id);
		$this->load->view('paginas/slideShow/alterar',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'slideShow/slideShow-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

	public function alterarSlide(){

		$id = $this->input->post('id');
		$nome = $this->input->post('nome');
		$descricao   = $this->input->post('descricao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$url = $this->input->post('url');
		$situacao   = $this->input->post('situacao');

		$friendly_url = '';
		if($nome != ''){
			$friendly_url = getRawUrl($nome);
		}else{
			$friendly_url = geraSenha().getRawUrl(@end(explode(".",$imagens[0])));
		}

		$dadosAtuais = $this->slideShowDao_model->slideShowById($id);

		$mensagem = array();




		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do programa é Obrigatório.';
		}

		/**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		/*if($nome != $dadosAtuais[0]->nome){
			$nome_existente = $this->slideShowDao_model->nome_disponivel($nome);
			if (count($nome_existente) > 0){
				$mensagem[] = 'Ops!, <b>NOME</b> já cadastrado.';
			}
		} */


		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'SlideShowController/viewalterar/'.$id,'refresh');
		}
		else{

			if(!empty($imagens)){
				chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($nome !== $dadosAtuais[0]->nome){
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
			$data['descricao'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['url'] = $url;
			$data['ativo'] = $situacao ;

			if($this->slideShowDao_model->updateSlide($data)){

				if(!empty($imagens)){
					unlink('assets/img/slideshow/'.$dadosAtuais[0]->imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/slideshow/'.$novo_nome_imagem);
					chmod('assets/img/slideshow/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/slideshow/'.$dadosAtuais[0]->imagem,'assets/img/slideshow/'.$novo_nome_imagem);
				}

				$this->session->set_flashdata('resultado_ok','SlideShow cadastrado com sucesso!');
				redirect(base_url() . 'SlideShowController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o SlideShow!');
				redirect(base_url() . 'SlideShowController/viewLista','refresh');
			}

		}
    }

    function excluirSlide($id){

		$dadosAtuais = $this->slideShowDao_model->slideShowById($id);

        if($this->slideShowDao_model->deleteSlide($id)){

			unlink('assets/img/slideshow/' . $dadosAtuais[0]->imagem);

            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'SlideShowController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir o slideshow!');
            redirect(base_url() . 'SlideShowController/viewLista','refresh');
        }
	}


}
