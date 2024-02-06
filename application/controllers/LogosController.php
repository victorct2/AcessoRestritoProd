<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogosController extends CI_Controller {

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
		$this->load->model('logosDao_model');

	}


    public function viewLista($offset=0){

		$open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imagens';
        $data['mainNavSub'] = 'logos';
		$data['subMainNav'] = 'listaLogos';
		$data['logos'] = $this->logosDao_model->listarLogos();
		$this->load->view('paginas/logos/lista',$data);	

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
		$footer['assetsJs'] = 'logos/logos-home.js';
        $this->load->view('include/footer',$footer);

    }

	public function inserirLogo(){


		$id   = $this->input->post('idLogo');
		$imagens = is_array($this->input->post('logo'))? $this->input->post('logo') : null;
		$link   = $this->input->post('link');
		$status   = $this->input->post('status');

		$nomeImagem = '';
		if(count($imagens)>0){
			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$nomeImagem = $imagens[0];
		}
		
		/*
		** Armazenando dados do formulário no Array $data
		*/
		$data['id'] = $id;
		if(!empty($link)){
			$data['link'] = $link;
		}
		if(!empty($nomeImagem)){
			$data['imagem'] = $nomeImagem;	
		}			
		$data['status'] = $status;
		

		if($this->logosDao_model->updateLogo($data)){

			if(!empty($nomeImagem)){

				if($logoAtual[0]->imagem != '' || $logoAtual[0]->imagem != null ){
					unlink('assets/img/logos/footer/'.$logoAtual[0]->imagem);
				}

				copy('uploadImagens/arquivos/'.$imagens[0], 'assets/img/logos/footer/'.$imagens[0]);
				chmod('assets/img/logos/footer/'.$imagens[0], 0777);
				unlink('uploadImagens/arquivos/'.$imagens[0]);
			}
			
			$this->session->set_flashdata('resultado_ok','Logo <b>'.$id.'</b> foi cadastrado com sucesso!');
			redirect(base_url() . 'logosController/viewLista','refresh');
		}
		else {
			$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Logo!');
			redirect(base_url() . 'logosController/viewLista','refresh');
		}

		
	}
    


}