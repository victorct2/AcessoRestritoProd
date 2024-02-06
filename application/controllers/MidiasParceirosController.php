<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MidiasParceirosController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
    $grupos = $this->session->userdata('grupos');
    if(in_array("1", $grupos) || in_array("17", $grupos) || in_array("20", $grupos) || in_array("15", $grupos) || in_array("16", $grupos)
|| in_array("14", $grupos) || in_array("19", $grupos) || in_array("21", $grupos) || in_array("22", $grupos) || in_array("23", $grupos)
|| in_array("24", $grupos) || in_array("28", $grupos)){
    }else{
        redirect(base_url() . 'Home', 'refresh');
    }
		$this->load->model('parceirosDao_model','parceirosDao');
		$this->load->model('ingestDao_model','ingestDao');
		$this->load->model('revisaoDao_model','revisaoDao');
		$this->load->model('revisaoClosedCaptionDao_model','revisaoClosedCaptionDao');
		$this->load->model('fichaConclusaoDao_model','fichaConclusaoDao');
		$this->load->model('catalogacaoDao_model','catalogacaoDao');
		$this->load->model('RevisaoCatalogacaoDao_model','revisaoCatalogacaoDao');
		$this->load->model('usuariosDao_model','usuariosDao');
	}


    public function viewProgramasParceiros(){

        $open['assetsBower'] = '';
        $open['assetsCSS'] = 'fluxo/midias/parceiros/home-parceiros.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
		$data['subMainNav'] = 'listarProgramasParceiros';
		$data['listParceiros'] = $this->parceirosDao->selectProgramasParceiros();
		$this->load->view('paginas/fluxo/midias/parceiros/viewListParceiros',$data);

        $footer['assetsJsBower'] = '';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/home-parceiros.js';
        $this->load->view('include/footer',$footer);
	}

	public function dadosFluxoParceiro($idParceiro){

		$data['revisao'] = $this->parceirosDao->selectTotalRevisao($idParceiro);
		$data['correcao'] = $this->parceirosDao->selectTotalCorrecao($idParceiro);
		$data['fichaConclusao'] = $this->parceirosDao->selectTotalFichaConclusao($idParceiro);
		$data['catalogacao'] = $this->parceirosDao->selectTotalCatalogacao($idParceiro);
		$data['correcaoCatalogacao'] = $this->parceirosDao->selectTotalCorrecaoCatalogacao($idParceiro);
		$data['revisaoCatalogacao'] = $this->parceirosDao->selectTotalRevisaoCatalogacao($idParceiro);

		$data['autorizacao'] = $this->parceirosDao->selectTotalAutorizacao($idParceiro);
		$data['exclusao'] = $this->parceirosDao->selectTotalExclusao($idParceiro);

		//Closed Caption
		$data['ingestClosedCaption'] = $this->parceirosDao->selectTotalIngestClosedCaption($idParceiro);
		$data['correcaoIngestClosedCaption'] = $this->parceirosDao->selectTotalCorrecaoIngestClosedCaption($idParceiro);
		$data['revisaoClosedCaption'] = $this->parceirosDao->selectTotalRevisaoClosedCaption($idParceiro);
    $data['catalogacaoClosedCaption'] = $this->parceirosDao->selectTotalCatalogacaoClosedCaption($idParceiro);
		$data['correcaoCatalogacaoClosedCaption'] = $this->parceirosDao->selectTotalCorrecaoCatalogacaoClosedCaption($idParceiro);
		$data['autorizacaoClosedCaption'] = $this->parceirosDao->selectTotalAutorizacaoClosedCaption($idParceiro);
		$data['revisaocatalogacaoClosedCaption'] = $this->parceirosDao->selectTotalRevisaoCatalogacaoClosedCaption($idParceiro);
		$data['exclusaoClosedCaption'] = $this->parceirosDao->selectTotalExclusaoClosedCaption($idParceiro);

		echo json_encode($data);

	}



    public function viewAreaParceiros(){
        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['assetsCSS'] = 'fluxo/midias/parceiros/parceiros-list.css';
        $open['pluginCSS'] = 'iCheck/all.css,jqueryUi/jquery-ui.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
		$data['subMainNav'] = 'listarProgramasParceiros';
        $data['listParceiros'] = $this->parceirosDao->selectProgramasParceiros();
		$this->load->view('paginas/fluxo/midias/parceiros/viewListAreaParceiro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/parceiros-list.js';
        $footer['pluginJS'] = 'iCheck/icheck.min.js';
        $this->load->view('include/footer',$footer);
    }

    public function listaAreaParceirosDataTables(){

        $fetch_data = $this->parceirosDao->make_datatables_AreaParceiros();
		$dataArray = array();

        foreach($fetch_data as $row){

			$situacao = '';
			if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green infoParceiroList">ATIVO</span><br>';
            }
			if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red infoParceiroList">INATIVO</span><br>';
            }

            $site = '';
            $bgButtom = 'bg-green';
			if($row->site == 'S'){
                $site = '<span class="label pull-right bg-yellow infoParceiroList">NO SITE</span><br>';
                $bgButtom = 'bg-red';
            }
			if($row->site == 'N'){
                $site = '<span class="label pull-right bg-navy infoParceiroList">FORA DO SITE</span><br>';
                $bgButtom = 'bg-green';
            }

			$sub_array = array();
			$sub_array[] = '<img src="'.IMAGEM_PARCEIRO.$row->imagem.'" class="img-rounded  imgList" width="210" height="150" />';
			$sub_array[] = $row->nomeParceiro;
            $sub_array[] = $row->descricaoParceiro;
			$sub_array[] = $situacao.$site;
            $sub_array[] = '<a href="'.base_url('MidiasParceirosController/viewAlterarParceiro/'.$row->idParceiros).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('MidiasParceirosController/excluirParceiro/'.$row->idParceiros).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>
                            <a href="'.base_url('MidiasParceirosController/viewIncluirProgramaParceiro/'.$row->idParceiros).'" class="btn btn-app"><i class="fa  fa-plus"></i> Incluir</a>
							<a href="#" title="'.$row->idParceiros.'" class="btn btn-app '.$bgButtom.' ativarSite"><i class="fa fa-power-off"></i> NO SITE</a>';

            $dataArray[] = $sub_array;
		}

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->parceirosDao->get_all_data_AreaParceiros(),
            "recordsFiltered" => $this->parceirosDao->get_filtered_data_AreaParceiros(),
            "data" => $dataArray
        );
        echo json_encode($output);
    }

    function ativarSite(){
		$idParceiros = $this->input->post('idParceiros');
		if($this->parceirosDao->updateAtivarSite($idParceiros)){
			echo 'success';
		}else{
			echo 'false';
		}
	}


    public function viewCadastroParceiro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
		$data['subMainNav'] = 'listarProgramasParceiros';
		$this->load->view('paginas/fluxo/midias/parceiros/viewCadastroParceiro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/cadastroParceiros.js';

		$this->load->view('include/footer',$footer);
    }

    public function cadastroParceiro(){

        $nome   = $this->input->post('nome');
        $descricao   = $this->input->post('descricao');
        $situacao   = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;

        $friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($imagens)){
			$mensagem[] = 'A <b>IMAGEM</b> do programa é Obrigatória.';
		}

		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do programa é Obrigatório.';
        }

        /**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		$nome_existente = $this->parceirosDao->verificarParceiro($nome);
		if (count($nome_existente) > 0){
			$mensagem[] = 'o parceiro <b>'.$nome.'</b> já foi cadastrado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'MidiasParceirosController/viewCadastroParceiro','refresh');
		}
		else{

			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename('uploadImagens/arquivos/'.$imagens[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idParceiros'] = null;
            $data['nomeParceiro'] = $nome;
            $data['descricaoParceiro'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['ativo'] = $situacao;
			$data['site'] = $site_novo;

			if($this->parceirosDao->insertParceiro($data)){

				if(!empty($novo_nome_imagem)){
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceiros/'.$novo_nome_imagem);
					chmod('assets/img/parceiros/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}
				$this->session->set_flashdata('resultado_ok','O Parceiro <b>'.$nome.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Parceiro!');
				redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros','refresh');
			}

		}

    }

    public function viewAlterarParceiro($idParceiro){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
        $data['subMainNav'] = 'listarProgramasParceiros';
        $data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/viewAlterarParceiro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/cadastroParceiros.js';

		$this->load->view('include/footer',$footer);
    }

    public function alterarParceiro(){


        $idParceiro = $this->input->post('idParceiro');
        $nome   = $this->input->post('nome');
        $descricao   = $this->input->post('descricao');
        $situacao   = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;

        $dadosAtuais = $this->parceirosDao->selectParceiroById($idParceiro);
        $friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do programa é Obrigatório.';
        }

        /**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
        if($nome != $dadosAtuais[0]->nomeParceiro){
            $nome_existente = $this->parceirosDao->verificarParceiro($nome);
            if (count($nome_existente) > 0){
                $mensagem[] = 'o parceiro <b>'.$nome.'</b> já foi cadastrado.';
            }
        }

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'MidiasParceirosController/viewAlterarParceiro','refresh');
		}
		else{


            if(!empty($imagens)){
				chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($nome !== $dadosAtuais[0]->nomeParceiro){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dadosAtuais[0]->imagem));
				}else{
					$novo_nome_imagem = $dadosAtuais[0]->imagem;
				}
			}

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idParceiros'] = $idParceiro;
            $data['nomeParceiro'] = $nome;
            $data['descricaoParceiro'] = $descricao;
			$data['imagem'] = $novo_nome_imagem;
			$data['ativo'] = $situacao;
			$data['site'] = $site_novo;

			if($this->parceirosDao->updateParceiro($data)){

				if(!empty($imagens)){
					unlink('assets/img/parceiros/'.$dadosAtuais[0]->imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceiros/'.$novo_nome_imagem);
					chmod('assets/img/parceiros/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/parceiros/'.$dadosAtuais[0]->imagem,'assets/img/parceiros/'.$novo_nome_imagem);
                }

				$this->session->set_flashdata('resultado_ok','O Parceiro <b>'.$nome.'</b> foi alterado com sucesso!');
				redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros','refresh');
			}
			else {

				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Parceiro!');
				redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros','refresh');
			}

		}

    }

    public function viewIncluirProgramaParceiro($idParceiro){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
        $data['subMainNav'] = 'listarProgramasParceiros';
        $data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
        $data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/viewIncluirProgramaParceiro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/incluirProgramaParceiros.js';

		$this->load->view('include/footer',$footer);
    }


    public function cadastrarProgramaParceiro(){

        $idParceiro  = $this->input->post('idParceiro');
        $nome  = $this->input->post('nome');
        $descricao   = $this->input->post('descricao');
        $sigla   = $this->input->post('sigla');
        $duracao   = $this->input->post('duracao');
        $inedito   = $this->input->post('inedito');
        $horariosAlternativos   = $this->input->post('horariosAlternativos');
        $situacao   = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;

        $friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($imagens)){
			$mensagem[] = 'A <b>IMAGEM</b> do programa é Obrigatória.';
		}

		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do programa é Obrigatório.';
        }

        if(empty($duracao)){
			$mensagem[] = 'A <b>DURAÇÃO</b> do programa é Obrigatório.';
        }

        /**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
		$nome_existente = $this->parceirosDao->verificarProgramaParceiro($nome);
		if (count($nome_existente) > 0){
			$mensagem[] = 'o programa parceiro <b>'.$nome.'</b> já foi cadastrado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
		}
		else{

			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename('uploadImagens/arquivos/'.$imagens[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idProgramasParceiros'] = null;
            $data['nomePrograma'] = $nome;
            $data['descricao'] = $descricao;
            $data['imagem'] = $novo_nome_imagem;
            $data['sigla'] = $sigla;
            $data['duracao'] = $duracao;
            $data['inedito'] = $inedito;
            $data['horariosAlternativos'] = $horariosAlternativos;
			$data['ativo'] = $situacao;
            $data['site'] = $site_novo;
            $data['parceiros_id'] = $idParceiro;

			if($this->parceirosDao->insertProgramaParceiro($data)){

				if(!empty($novo_nome_imagem)){
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceiros/programas/'.$novo_nome_imagem);
					chmod('assets/img/parceiros/programas/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}
				$this->session->set_flashdata('resultado_ok','O Programa parceiro <b>'.$nome.'</b> foi cadastrado com sucesso!');
				redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Programa Parceiro!');
				redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
			}

		}
    }

    public function modalAlterarProgramaParceiro(){
        $idProgramaParceiro = $this->input->post('idProgramaParceiro');
        $data['programa'] = $this->parceirosDao->selectProgramaParceiroById($idProgramaParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalAlterarProgramaParceiro',$data);
    }

    public function alterarProgramaParceiro(){

        $idParceiro  = $this->input->post('idParceiro');
        $idProgramaParceiro = $this->input->post('idProgramaParceiro');
        $nome  = $this->input->post('nome');
        $descricao   = $this->input->post('descricao');
        $sigla   = $this->input->post('sigla');
        $duracao   = $this->input->post('duracao');
        $inedito   = $this->input->post('inedito');
        $horariosAlternativos   = $this->input->post('horariosAlternativos');
        $situacao   = $this->input->post('situacao');
		$site_novo   = $this->input->post('site_novo');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;

        $dadosAtuais = $this->parceirosDao->selectProgramaParceiroById($idProgramaParceiro);
        $friendly_url = getRawUrl($nome);
		$mensagem = array();

		if(empty($nome)){
			$mensagem[] = 'O <b>NOME</b> do programa é Obrigatório.';
		}

		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do programa é Obrigatório.';
        }

        if(empty($duracao)){
			$mensagem[] = 'A <b>DURAÇÃO</b> do programa é Obrigatório.';
        }

        /**
		 * VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
		 */
        if($nome != $dadosAtuais[0]->nomePrograma){
            $nome_existente = $this->parceirosDao->verificarProgramaParceiro($nome);
            if (count($nome_existente) > 0){
                $mensagem[] = 'o programa parceiro <b>'.$nome.'</b> já foi cadastrado.';
            }
        }


		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
		}
		else{

			if(!empty($imagens)){
				chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($nome !== $dadosAtuais[0]->nomePrograma){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dadosAtuais[0]->imagem));
				}else{
					$novo_nome_imagem = $dadosAtuais[0]->imagem;
				}
			}

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idProgramasParceiros'] = $idProgramaParceiro;
            $data['nomePrograma'] = $nome;
            $data['descricao'] = $descricao;
            $data['imagem'] = $novo_nome_imagem;
            $data['sigla'] = $sigla;
            $data['duracao'] = $duracao;
            $data['inedito'] = $inedito;
            $data['horariosAlternativos'] = $horariosAlternativos;
			$data['ativo'] = $situacao;
            $data['site'] = $site_novo;

			if($this->parceirosDao->updateProgramaParceiro($data)){

				if(!empty($imagens)){
					unlink('assets/img/parceiros/programas/'.$dadosAtuais[0]->imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceiros/programas/'.$novo_nome_imagem);
					chmod('assets/img/parceiros/programas/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/parceiros/programas/'.$dadosAtuais[0]->imagem,'assets/img/parceiros/programas/'.$novo_nome_imagem);
                }
				$this->session->set_flashdata('resultado_ok','O Programa parceiro <b>'.$nome.'</b> foi alterado com sucesso!');
				redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Programa Parceiro!');
				redirect(base_url() . 'MidiasParceirosController/viewIncluirProgramaParceiro/'.$idParceiro,'refresh');
			}

		}
    }

    public function excluirParceiro($idParceiro){

        $dadosAtuais = $this->parceirosDao->selectParceiroById($idParceiro);
        if($this->parceirosDao->deleteParceiros($idParceiro)){
			unlink('assets/img/parceiros/' . $dadosAtuais[0]->imagem);
            $this->session->set_flashdata('resultado_ok', 'Exclusão do parceiro <b>'.$dadosAtuais[0]->nome.'</b> foi efetuada com sucesso!');
            redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros', 'refresh');
        }
        else{
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir o parceiro <b>'.$dadosAtuais[0]->nome.'</b>!');
            redirect(base_url() . 'MidiasParceirosController/viewAreaParceiros','refresh');
        }
    }


    public function excluirProgramaParceiro(){
        $idProgramaParceiro = $this->input->post('idProgramaParceiro');
        $dadosAtuais = $this->parceirosDao->selectProgramaParceiroById($idProgramaParceiro);
        if($this->parceirosDao->deleteProgramaParceiros($idProgramaParceiro)){
			unlink('assets/img/parceiros/programas/' . $dadosAtuais[0]->imagem);
            echo 'success';
        }
        else{
            echo 'false';
        }
	}



	/*=====================================================================*/

	public function viewInsertProgramasParceiros($idParceiro){
        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['assetsCSS'] = 'fluxo/midias/parceiros/fluxo-list.css';
        $open['pluginCSS'] = 'iCheck/all.css,jqueryUi/jquery-ui.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
		$data['subMainNav'] = 'listarProgramasParceiros';
        $data['listParceiros'] = $this->parceirosDao->selectProgramasParceiros();
		$data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$data['idParceiro'] = $idParceiro;
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/viewInsertProgramasParceiros',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/programasParceirosAdd.js';
        $footer['pluginJS'] = 'iCheck/icheck.min.js,input-mask/jquery.inputmask.js';
        $this->load->view('include/footer',$footer);
	}

	function listaInsertProgramasDataTables(){


		$idParceiro = $this->input->post('idParceiro');
		$fetch_data = $this->ingestDao->make_datatablesProgramasParceiros($idParceiro);

        $data = array();
        foreach($fetch_data as $row){

			$linksFinais = '';
			$statusIngest = '';

			$datas = '<span class="label pull-right bg-navy datas">Cadastro: '.(($row->dataCadastro !="")? converteDataInterface($row->dataCadastro):'').'</span><br>';
			$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarInfoParceiro" data-toggle="modal" data-target="#modal-alterarInfoParceiro"><i class="fa fa-pencil"></i> Alterar</a>';
			//$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red cancelarProgama"><i class="fa fa-ban"></i> Cancelar</a>';
			$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey excluirInfoParceiro"><i class="fa fa-trash"></i> Excluir</a>';

			if($row->statusIngest == 'LIBERADO'){
				$statusIngest .='<span class="label pull-right bg-green datas">Liberado para Edição</span>';
			}
			else if($row->statusIngest == 'AGUARDANDO'){
				$statusIngest .='<span class="label pull-right bg-yellow datas">Aguardando a liberação para Edição</span>';
			}
			else if($row->statusIngest == 'CANCELADO'){
				$statusIngest .='<span class="label pull-right bg-red datas">Programa Cancelado</span>';
			}

            $sub_array = array();
            $sub_array[] = '<img src="'.IMAGEM_PROGRAMA_PARCEIRO.$row->imgPgmParceiro.'" class="img-thumbnail imgProgramaParceiro"/>';
            $sub_array[] = $row->nomePrograma;
			$sub_array[] = $row->tituloPrograma;
			$sub_array[] = $row->numeroPGM;
			$sub_array[] = ($row->recebido == 'PG')? 'Plano Geral':$row->recebido;
			$sub_array[] = $row->observacao;
			$sub_array[] = $datas;
			$sub_array[] = $statusIngest;
			$sub_array[] = $linksFinais;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->ingestDao->get_all_dataProgramasParceiros($idParceiro),
            "recordsFiltered" => $this->ingestDao->get_filtered_dataProgramasParceiros($idParceiro),
            "data" => $data
		);
		//header('Content-Type: application/json');
		$outputJson = json_encode($output, true);
		echo $outputJson;
		exit();
	}

	public function modalAlterarInfoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalAlterarInfoParceiro',$data);
	}

/*================================================= Fluxo parceiros =======================================*/

	public function viewfluxoParceiros($idParceiro, $tab=""){
        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['assetsCSS'] = 'fluxo/midias/parceiros/fluxo-list.css';
        $open['pluginCSS'] = 'iCheck/all.css,jqueryUi/jquery-ui.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'producaoAudioVisual';
		$data['mainNavSub'] = 'sistemasMidias';
		$data['subMainNav'] = 'listarProgramasParceiros';
        $data['listParceiros'] = $this->parceirosDao->selectProgramasParceiros();
		$data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$data['idParceiro'] = $idParceiro;
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['tab'] = $tab;
		$this->load->view('paginas/fluxo/midias/parceiros/viewFluxoParceiros',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'fluxo/midias/parceiros/fluxo-list.js';
        $footer['pluginJS'] = 'iCheck/icheck.min.js,input-mask/jquery.inputmask.js';
        $this->load->view('include/footer',$footer);
    }

	function listaProgramasDataTables(){


		$idParceiro = $this->input->post('idParceiro');
		$etapa = $this->input->post('etapa');
		$fetch_data = $this->ingestDao->make_datatables($idParceiro);

        $data = array();
        foreach($fetch_data as $row){

			$usuario = '';
			$datas = '';
			$linksFinais = '';
			switch ($etapa) {
				case 'ingest':
					if($row->usuario_id){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
					}
					if($row->dataFim){
						$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					}
					if($row->usuario_id){
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarIngest" data-toggle="modal" data-target="#modal-alterarIngest"><i class="fa fa-pencil"></i> Alterar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarIngest" data-toggle="modal" data-target="#modal-visualizarIngest"><i class="fa fa-search"></i> Visualizar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey excluirIngest"><i class="fa fa-trash"></i> Excluir</a>';
						if($row->statusRevisao == 'R'){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red corrigirIngest"  data-toggle="modal" data-target="#modal-corrigirIngest"><i class="fa fa-flag"></i> Corrigir</a>';
						}
						if($row->statusRevisao == 'C'){
							$linksFinais .='<a class="btn btn-app bg-yellow" disabled><i class="fa fa-flag"></i> Corrigido</a>';
						}
					}else{
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-green alterarIngest" data-toggle="modal" data-target="#modal-alterarIngest"><i class="fa fa-database"></i> Ingestar</a>';
					}

					break;
				case 'revisaoIngest':
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					if($row->usuario_id_revisao != ''){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_revisao);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
						$datas .= '<span class="label pull-right bg-yellow datas">Revisão: '.(($row->dataRevisao !="")? converteDataInterface($row->dataRevisao):'').'</span><br>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarRevisao" data-toggle="modal" data-target="#modal-visualizarRevisao"><i class="fa fa-search"></i> Visualizar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idRevisao.'" class="btn btn-app bg-grey excluirRevisao"><i class="fa fa-trash"></i> Excluir</a>';

						if($row->statusRevisao == 'R'){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarRevisao" data-toggle="modal" data-target="#modal-alterarRevisao"><i class="fa fa-pencil"></i> Alterar</a>';
							$linksFinais .='<a class="btn btn-app bg-red" disabled><i class="fa fa-flag"></i> Corrigir</a>';
						}
						if($row->statusRevisao == 'C'){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow corrigirRevisaoIngest"  data-toggle="modal" data-target="#modal-corrigirRevisaoIngest"><i class="fa fa-flag"></i> Revisão de Correção</a>';
						}
					}else if($row->usuario_id_revisao == '' && $row->dataFim != ''){
						$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue cadastrarRevisao" data-toggle="modal" data-target="#modal-revisarIngest"><i class="fa fa-clipboard"></i> Revisar</a>';
					}

					break;
					case 'ingestClosedCaption':
						$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
						$datas .= '<span class="label pull-right bg-yellow datas">Revisão: '.(($row->dataRevisao !="")? converteDataInterface($row->dataRevisao):'').'</span><br>';
						if($row->usuario_id_ingest_closedCaption != ''){
							$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_ingest_closedCaption);
							$nome = explode(' ' ,$nomeUsuario[0]->nome);
							$usuario = @$nome[0] . ' ' . @$nome[1];
							$datas .= '<span class="label pull-right bg-blue datas">Ingest <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataIngestClosedCaption !="")? converteDataInterface($row->dataIngestClosedCaption):'').'</span><br>';


							if($row->statusRevisaoClosedCaption == 'R'){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red corrigirIngestClosedCaption"  data-toggle="modal" data-target="#modal-corrigirIngestClosedCaption"><i class="fa fa-flag"></i> Corrigir</a>';
							}
							if($row->statusRevisaoClosedCaption == 'C'){
								$linksFinais .='<a class="btn btn-app bg-yellow" disabled><i class="fa fa-flag"></i> Corrigido</a>';
							}
						}else if($row->usuario_id_ingest_closedCaption == '' && $row->statusRevisao == 'A'){
							if($row->closedCaption == '' || $row->closedCaption == null){

								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-green ingestClosedCaption"><i class="fa fa-cc"></i> Ingest</a>';

								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red semIngestClosedCaption"><i class="fa fa-cc"></i>Não possui</a>';
							}

						}

						if(($row->closedCaption != '' || $row->closedCaption != null) &&
								($row->dataRevisaoClosedCaption == null)){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow desfazerClosedCaption"><i class="fa fa-reply"></i> Desfazer</a>';
						}else if($row->closedCaption == 'N' && $row->dataFichaConclusao == null){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow desfazerClosedCaption"><i class="fa fa-reply"></i> Desfazer</a>';
						}


						break;
					case 'revisaoClosedCaption':
						$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
						if($row->usuario_id_revisao_closedCaption != ''){
							$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_revisao_closedCaption);
							$nome = explode(' ' ,$nomeUsuario[0]->nome);
							$usuario = @$nome[0] . ' ' . @$nome[1];
							$datas .= '<span class="label pull-right bg-blue datas">Ingest <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataIngestClosedCaption !="")? converteDataInterface($row->dataIngestClosedCaption):'').'</span><br>';
							$datas .= '<span class="label pull-right bg-navy datas">Revisão <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataRevisaoClosedCaption !="")? converteDataInterface($row->dataRevisaoClosedCaption):'').'</span><br>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idRevisaoClosedCaption.'" class="btn btn-app bg-grey visualizarRevisaoClosedCaption" data-toggle="modal" data-target="#modal-visualizarRevisaoClosedCaption"><i class="fa fa-search"></i> Visualizar</a>';
							//$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idRevisaoClosedCaption.'" class="btn btn-app bg-grey excluirRevisao"><i class="fa fa-trash"></i> Excluir</a>';

							if($row->statusRevisaoClosedCaption == 'R'){
								//$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarRevisaoClosedCaption" data-toggle="modal" data-target="#modal-alterarRevisao"><i class="fa fa-pencil"></i> Alterar</a>';
								$linksFinais .='<a class="btn btn-app bg-red" disabled><i class="fa fa-flag"></i> Corrigir</a>';
							}
							if($row->statusRevisaoClosedCaption == 'C'){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow corrigirRevisaoIngestClosedCaption"  data-toggle="modal" data-target="#modal-corrigirRevisaoIngestClosedCaption"><i class="fa fa-flag"></i> Revisão de Correção</a>';
							}
						}else if($row->usuario_id_revisao_closedCaption == '' && $row->dataIngestClosedCaption != ''){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue cadastrarRevisaoClosedCaption" data-toggle="modal" data-target="#modal-revisarClosedCaption"><i class="fa fa-cc"></i> Revisar</a>';
						}

						break;
				case 'fichaConclusao':
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					if($row->usuario_id_fichaConclusao != ''){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_fichaConclusao);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
						$datas .= '<span class="label pull-right bg-yellow datas">Ficha de Conclusão: '.(($row->dataFichaConclusao !="")? converteDataInterface($row->dataFichaConclusao):'').'</span><br>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarFichaConclusao" data-toggle="modal" data-target="#modal-alterarFichaConclusao"><i class="fa fa-pencil"></i> Alterar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarFichaConclusao" data-toggle="modal" data-target="#modal-visualizarFichaConclusao"><i class="fa fa-search"></i> Visualizar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idFichaConclusao.'" class="btn btn-app bg-navy excluirFichaDeConclusao"><i class="fa fa-trash"></i> Excluir</a>';
					}else{
						if($row->statusRevisao == 'A'){
							if($row->usuario_id_revisao_closedCaption != '' && $row->statusRevisaoClosedCaption == 'A'){
								$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue cadastrarFichaConclusao" data-toggle="modal" data-target="#modal-cadastrarFichaConclusao"><i class="fa fa-list-alt"></i> Cadastrar Ficha de Conclusão</a>';
							}elseif ($row->usuario_id_ingest_closedCaption == '' && $row->closedCaption == 'N') {
								$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue cadastrarFichaConclusao" data-toggle="modal" data-target="#modal-cadastrarFichaConclusao"><i class="fa fa-list-alt"></i> Cadastrar Ficha de Conclusão</a>';
							}

						}

					}

					break;
				case 'catalogacao':
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					if($row->usuario_id_catalogacao != ''){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_catalogacao);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
						$datas .= '<span class="label pull-right bg-yellow datas">Início Catalogação: '.(($row->dataInicioCatalogacao !="")? converteDataInterface($row->dataInicioCatalogacao):'').'</span><br>';
						$datas .= '<span class="label pull-right bg-red datas">Fim Catalogação: '.(($row->dataFimCatalogacao !="")? converteDataInterface($row->dataFimCatalogacao):'').'</span><br>';
						if($row->dataCatalogacaoClosedCaption != ''){
							$datas .= '<span class="label pull-right bg-navy datas">Fim Catalogação <i class="fa fa-cc"></i>: '.(($row->dataCatalogacaoClosedCaption !="")? converteDataInterface($row->dataCatalogacaoClosedCaption):'').'</span><br>';
						}
						if($row->dataFimCatalogacao == ''){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue catalogar" data-toggle="modal" data-target="#modal-catalogar"><i class="fa fa-plus"></i> Catalogar</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-navy visualizarFichaConclusao" data-toggle="modal" data-target="#modal-visualizarFichaConclusao"><i class="fa fa-list-alt"></i> Ficha Conclusao</a>';
						}else{
							//$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarRevisao"><i class="fa fa-pencil"></i> Alterar</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarCatalogacao" data-toggle="modal" data-target="#modal-visualizarCatalogacao"><i class="fa fa-search"></i> Visualizar</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idCatalogacao.'" class="btn btn-app bg-grey excluirCatalogacao"><i class="fa fa-trash"></i> Excluir</a>';

							if($row->statusRevCatalog == 'R'){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red corrigirCatalogacao"  data-toggle="modal" data-target="#modal-corrigirCatalogacao"><i class="fa fa-flag"></i> Corrigir Catalogação</a>';
							}
							if($row->statusRevCatalog == 'C'){
								$linksFinais .='<a class="btn btn-app bg-yellow" disabled><i class="fa fa-flag"></i> Corrigido</a>';
							}

							if($row->statusRevisaoCatalogacaoClosedCaption == 'R'){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-red corrigirCatalogacaoClosedCaption"  data-toggle="modal" data-target="#modal-corrigirCatalogacaoClosedCaption"><i class="fa fa-flag"></i> Corrigir Catalogação - CC</a>';
							}
							if($row->statusRevisaoCatalogacaoClosedCaption == 'C'){
								$linksFinais .='<a class="btn btn-app bg-yellow" disabled><i class="fa fa-flag"></i> CC - Corrigido</a>';
							}
						}
					}else{
						if($row->dataFichaConclusao !=""){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-navy visualizarFichaConclusao" data-toggle="modal" data-target="#modal-visualizarFichaConclusao"><i class="fa fa-list-alt"></i> Ficha Conclusao</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idIngest.'" class="btn btn-app bg-blue iniciarCatalogacao"><i class="fa fa-plus"></i> Iniciar Catalogação</a>';
						}

					}

					if($row->dataFimCatalogacao != '' && $row->dataFimCatalogacao < $row->dataIngestClosedCaption && $row->dataCatalogacaoClosedCaption == ''){
						$linksFinais ='<a href="#" id="'.$row->idCatalogacao.'" class="btn btn-app bg-green catalogarClosedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Catalogar</a>';
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-navy visualizarFichaConclusao" data-toggle="modal" data-target="#modal-visualizarFichaConclusao"><i class="fa fa-list-alt"></i> Ficha Conclusao</a>';
					}



					break;
				case 'autorizacao':
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					if($row->usuario_id_autorizacao != ''){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_autorizacao);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
						$datas .= '<span class="label pull-right bg-yellow datas">Autorização : '.(($row->dataAutorizacao !="")? converteDataInterface($row->dataAutorizacao):'').'</span><br>';
						if($row->dataAutorizacaoClosedCaption != ''){
							$datas .= '<span class="label pull-right bg-navy datas">Autorização <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataAutorizacaoClosedCaption !="")? converteDataInterface($row->dataAutorizacaoClosedCaption):'').'</span><br>';
						}
						$linksFinais .='<a href="#" id="'.$row->idIngest.'" title="'.$row->idAutorizacao.'" class="btn btn-app bg-grey excluirAutorizacao"><i class="fa fa-trash"></i> Excluir</a>';

					}else{
						if($row->dataFimCatalogacao !=""){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" title="'.$row->idIngest.'" class="btn btn-app bg-green autorizar"><i class="fa fa-check"></i> Autorizar</a>';
						}
					}

					if($row->dataAutorizacao != '' && $row->dataCatalogacaoClosedCaption != '' &&
            $row->dataAutorizacao < $row->dataIngestClosedCaption &&
            ($row->dataAutorizacaoClosedCaption == '' || $row->dataAutorizacaoClosedCaption == null )){
						$linksFinais ='<a href="#" id="'.$row->idAutorizacao.'" title="'.$row->idAutorizacao.'" class="btn btn-app bg-blue autorizarClosedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Autorizar</a>';

					}

					break;
				case 'revisaoExclusao':
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
					if($row->usuario_id_revCatalog != ''){
						$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id_revCatalog);
						$nome = explode(' ' ,$nomeUsuario[0]->nome);
						$usuario = @$nome[0] . ' ' . @$nome[1];
						$datas .= '<span class="label pull-right bg-yellow datas">Revisão: '.(($row->dataRevisaoCatalogacao !="")? converteDataInterface($row->dataRevisaoCatalogacao):'').'</span><br>';
						$datas .= '<span class="label pull-right bg-red datas">Exclusão: '.(($row->dataExclusao !="")? converteDataInterface($row->dataExclusao):'').'</span><br>';
						if($row->dataRevisaoCatalogacaoClosedCaption !=""){
							$datas .= '<span class="label pull-right bg-navy datas">Revisão <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataRevisaoCatalogacaoClosedCaption !="")? converteDataInterface($row->dataRevisaoCatalogacaoClosedCaption):'').'</span><br>';
						}
						if($row->dataExclusaoClosedCaption !=""){
							$datas .= '<span class="label pull-right bg-navy datas">Exclusão <i class="fa fa-cc" aria-hidden="true"></i>: '.(($row->dataExclusaoClosedCaption !="")? converteDataInterface($row->dataExclusaoClosedCaption):'').'</span><br>';
						}
						if($row->usuario_id_revCatalog != '' & $row->statusRevCatalog == 'A' & $row->usuario_id_exclusao == ''){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" title="'.$row->idIngest.'" class="btn btn-app bg-red excluir"><i class="fa fa-trash"></i> Excluir</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarRevisaoCatalogacao" data-toggle="modal" data-target="#modal-visualizarRevisaoCatalogacao"><i class="fa fa-search"></i> Visualizar</a>';
						}else if($row->usuario_id_revCatalog != '' & $row->statusRevCatalog == 'A' & $row->usuario_id_exclusao != ''){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarRevisaoCatalogacao" data-toggle="modal" data-target="#modal-visualizarRevisaoCatalogacao"><i class="fa fa-search"></i> Visualizar</a>';
						}else{
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey alterarRevisao"><i class="fa fa-pencil"></i> Alterar</a>';
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey visualizarRevisaoCatalogacao" data-toggle="modal" data-target="#modal-visualizarRevisaoCatalogacao"><i class="fa fa-search"></i> Visualizar</a>';
							//$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-grey excluirRevisao"><i class="fa fa-trash"></i> Excluir</a>';
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" title="'.$row->idRevisaoCatalogacao.'" class="btn btn-app bg-navy excluirRevisaoCatalogacao"><i class="fa fa-trash"></i> Excluir</a>';

							if($row->statusRevCatalog == 'R'){
								$linksFinais .='<a class="btn btn-app bg-red" disabled><i class="fa fa-flag"></i> Corrigir</a>';
							}
							if($row->statusRevCatalog == 'C'){
								$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow corrigirRevisaoCatalogacao"  data-toggle="modal" data-target="#modal-corrigirRevisaoCatalogacao"><i class="fa fa-flag"></i> Revisão de Correção</a>';
							}


						}

						if($row->dataRevisaoCatalogacao != ''  && $row->idRevisaoCatalogacaoClosedCaption == '' && $row->dataCatalogacaoClosedCaption != ''){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" title="'.$row->idIngest.'" class="btn btn-app bg-blue revisarCatalogacaoClosedCaption" data-toggle="modal" data-target="#modal-revisarCatalogacaoClosedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Revisar Catalogacao</a>';

						}

						if($row->dataExclusao != '' && $row->dataExclusao < $row->dataIngestClosedCaption && $row->statusRevisaoCatalogacaoClosedCaption == 'A' && $row->dataExclusaoClosedCaption == ''){
							$linksFinais ='<a href="#" id="'.$row->idExclusao.'" title="'.$row->idExclusao.'" class="btn btn-app bg-red excluirClosedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Excluir Catalogacao</a>';

						}

						if($row->statusRevisaoCatalogacaoClosedCaption == 'R'){
							$linksFinais .='<a class="btn btn-app bg-red" disabled><i class="fa fa-flag"></i> Corrigir - CC </a>';
						}
						if($row->statusRevisaoCatalogacaoClosedCaption == 'C'){
							$linksFinais .='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-yellow corrigirRevisaoCatalogacaoClosedCaption"  data-toggle="modal" data-target="#modal-corrigirRevisaoCatalogacaoClosedCaption"><i class="fa fa-flag"></i> Revisão de Correção - CC</a>';
						}

					}else{
						if($row->dataFimCatalogacao !=""){
							$linksFinais ='<a href="#" id="'.$row->idIngest.'" class="btn btn-app bg-blue revisarCatalogacao" data-toggle="modal" data-target="#modal-revisarCatalogacao"><i class="fa fa-clipboard"></i> Revisar</a>';
						}


					}



					break;
				default:
					$nomeUsuario = $this->usuariosDao->selectUsuarioById($row->usuario_id);
					$nome = explode(' ' ,$nomeUsuario[0]->nome);
					$usuario = @$nome[0] . ' ' . @$nome[1];
					$datas = '<span class="label pull-right bg-green datas">Ingest: '.(($row->dataFim !="")? converteDataInterface($row->dataFim):'').'</span><br>';
				break;

			}

            $sub_array = array();
            $sub_array[] = '<img src="'.IMAGEM_PROGRAMA_PARCEIRO.$row->imgPgmParceiro.'" class="img-thumbnail imgProgramaParceiro"/>';
            $sub_array[] = $row->sigla.' - '.$row->nomePrograma;
			$sub_array[] = $row->tituloPrograma;
			if($etapa!= 'ingest' && $etapa != 'revisaoIngest'){
				$sub_array[] = ($row->closedCaption == 'S')? $row->numeroPGM.' - CC':$row->numeroPGM;
			}else{
				$sub_array[] = $row->numeroPGM;
			}
			//$sub_array[] = $row->numeroPGM;
			$sub_array[] = $row->versao;
			$sub_array[] =  $datas;
			$sub_array[] = $usuario;
			$sub_array[] = $linksFinais;


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->ingestDao->get_all_data($idParceiro),
            "recordsFiltered" => $this->ingestDao->get_filtered_data($idParceiro),
            "data" => $data
		);
		//header('Content-Type: application/json');
		$outputJson = json_encode($output, true);
		echo $outputJson;
		exit();
	}

/*===================== INGEST ===========================*/
	public function modalAlterarIngestParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalAlterarIngestParceiro',$data);
	}

	public function modalCorrigirIngestParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['claquetes'] = $this->revisaoDao->selectClaquetesReprovadasRevisao($idIngest);
		$data['blocos'] = $this->revisaoDao->selectBlocosReprovadasRevisao($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalCorrigirIngestParceiro',$data);
	}

	public function modalVisualizarIngestParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['listSerieParceiros'] = $this->parceirosDao->selectSerieParceiros($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarIngestParceiro',$data);
	}

/*===================== REVISÃO de Ingest ===========================*/

	public function modalRevisarIngestParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarIngestParceiro',$data);
	}

	public function modalAlterarRevisaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['revisao'] = $this->revisaoDao->selectRevisaoByIdIngest($idIngest);
		$data['claquetesRevisao'] = $this->revisaoDao->selectClaquetes($idIngest);
		$data['blocosRevisao'] = $this->revisaoDao->selectBlocos($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalAlterarRevisaoParceiro',$data);
	}

	public function modalRevisarCorrecaoIngestParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['revisao'] = $this->revisaoDao->selectRevisaoByIdIngest($idIngest);
		$data['claquetes'] = $this->revisaoDao->selectClaquetesCorrigidas($idIngest);
		$data['blocos'] = $this->revisaoDao->selectBlocosCorrigidas($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCorrecaoIngestParceiro',$data);
	}

	public function modalVisualizarRevisaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['claquetes'] = $this->revisaoDao->selectClaquetes($idIngest);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarRevisaoIngestParceiro',$data);
	}

/*===================== Ficha de Conclusão ===========================*/

	public function modalCadastrarFichaConclusaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalCadastrarFichaConclusaoParceiro',$data);
	}

	public function modalAlterarFichaConclusaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['fichaConclusao'] = $this->fichaConclusaoDao->selectFichaConclusao($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalAlterarFichaConclusaoParceiro',$data);
	}

	public function modalVisualizarFichaConclusaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['fichaConclusao'] = $this->fichaConclusaoDao->selectFichaConclusao($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarFichaConclusaoParceiro',$data);
	}


/* ============================ Autorização =====================================*/

	function autorizar(){
		$idIngest = $this->input->post('idIngest');
		$data['idAutorizacao'] = null;
		$data['autorizado'] = 'S';
		$data['usuario_id_autorizacao'] = $this->session->userdata('idUsuario');
		$data['ingest_id'] = $idIngest;
		if( $this->parceirosDao->autorizar($data)){
		    echo true;
		}else{
			echo false;
		}
	}

	function autorizarClosedCaption(){
		$idAutorizacao = $this->input->post('idAutorizacao');
		$data['idAutorizacao'] = $idAutorizacao;
		$data['dataAutorizacaoClosedCaption'] = Date("Y-m-d H:i:s");
		if( $this->parceirosDao->autorizarClosedCaption($data)){
		    echo true;
		}else{
			echo false;
		}
	}

	function deleteAutorizacao(){
		$idIngest = $this->input->post('idIngest');
		$idAutorizacao = $this->input->post('idAutorizacao');
		if( $this->parceirosDao->deleteAutorizacao($idIngest,$idAutorizacao)){
		    echo true;
		}else{
			echo false;
		}
	}

/*=========================== Catalogação ======================================*/

	public function modalCatalogarProgramaParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$data['catalogacao'] = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalCatalogarProgramaParceiro',$data);
	}

	public function modalVisualizarCatalogacaoProgramaParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$data['catalogacao'] = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarCatalogacaoProgramaParceiro',$data);
	}


	public function modalCorrigirCatalogacaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['catalogacao'] = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
		$data['claquetes'] = $this->revisaoCatalogacaoDao->selectClaquetesReprovadasRevisao($idIngest);
		$data['blocos'] = $this->revisaoCatalogacaoDao->selectBlocosReprovadasRevisao($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalCorrigirCatalogacaoParceiro',$data);
	}

	public function modalCorrigirCatalogacaoClosedCaption(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$idRevisaoCatalogacaoClosedCaption = $this->revisaoClosedCaptionDao->selectIdRevisaoCatalogacaoClosedCaption($idIngest);
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['revisaoClosedCaption'] = $this->revisaoClosedCaptionDao->selectRevisaoCatalogacaoById($idRevisaoCatalogacaoClosedCaption[0]->idRevisaoCatalogacaoClosedCaption);
		$data['problemaClosedCaption'] = $this->revisaoClosedCaptionDao->selectProblemasCatalogacaoClosedCaptionCorrigir($idRevisaoCatalogacaoClosedCaption[0]->idRevisaoCatalogacaoClosedCaption);
		$this->load->view('paginas/fluxo/midias/parceiros/modalCorrigirCatalogacaoClosedCaption',$data);
	}

/*=========================== Revisão de Catalogação ======================================*/

	public function modalRevisarCatalogacaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		//$data['blocos'] = $this->revisaoDao->selectBlocos($idIngest);
		$data['catalogacao'] = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
		$data['claquetes'] = $this->revisaoCatalogacaoDao->selectClaquetesCatalogadasSemRevisar($idIngest);
		$data['blocos'] = $this->revisaoCatalogacaoDao->selectBlocosCatalogadasSemRevisar($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCatalogacaoParceiro',$data);
	}


	public function modalRevisarCorrecaoCatalogacaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
        $data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['revisaoCatalogacao'] = $this->revisaoCatalogacaoDao->selectIdRevisaoCatalogacaoParceiro($idIngest);
		$data['claquetes'] = $this->revisaoCatalogacaoDao->selectClaquetesCorrigidas($idIngest);
		$data['blocos'] = $this->revisaoCatalogacaoDao->selectBlocosCorrigidas($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCorrecaoCatalogacaoParceiro',$data);
	}

	public function modalVisualizarRevisaoCatalogacaoParceiro(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$data['catalogacao'] = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
		$data['blocos'] = $this->revisaoCatalogacaoDao->selectBlocos($idIngest);
		$data['claquetes'] = $this->revisaoCatalogacaoDao->selectClaquetes($idIngest);
		$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarRevisaoCatalogacaoParceiro',$data);
	}

	public function modalRevisarCatalogacaoClosedCaption(){
		$idParceiro = $this->input->post('idParceiro');
		$idIngest = $this->input->post('idIngest');
		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
		$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
		$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCatalogacaoClosedCaption',$data);
	}

/*=========================== Ingest Closed Caption ======================================*/

public function modalCorrigirIngestClosedCaption(){
	$idParceiro = $this->input->post('idParceiro');
	$idIngest = $this->input->post('idIngest');
	$idRevisaoClosedCaption = $this->revisaoClosedCaptionDao->selectIdRevisaoClosedCaption($idIngest);
	$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
	$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
	$data['revisaoClosedCaption'] = $this->revisaoClosedCaptionDao->selectRevisaoById($idRevisaoClosedCaption[0]->idRevisaoClosedCaption);
	$data['problemaClosedCaption'] = $this->revisaoClosedCaptionDao->selectProblemasClosedCaptionCorrigir($idRevisaoClosedCaption[0]->idRevisaoClosedCaption);
	$this->load->view('paginas/fluxo/midias/parceiros/modalCorrigirIngestClosedCaption',$data);
}

/*=========================== Revisão Closed Caption ======================================*/

public function modalRevisarClosedCaption(){
	$idParceiro = $this->input->post('idParceiro');
	$idIngest = $this->input->post('idIngest');
	$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
	$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
	$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarClosedCaption',$data);
}

public function modalVisualizarRevisaoClosedCaption(){
	$idParceiro = $this->input->post('idParceiro');
	$idIngest = $this->input->post('idIngest');
	$idRevisaoClosedCaption = $this->input->post('idRevisaoClosedCaption');
	$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
	$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
	$data['revisaoClosedCaption'] = $this->revisaoClosedCaptionDao->selectRevisaoById($idRevisaoClosedCaption);
	$data['problemaClosedCaption'] = $this->revisaoClosedCaptionDao->selectProblemasClosedCaption($idRevisaoClosedCaption);
	$this->load->view('paginas/fluxo/midias/parceiros/modalVisualizarRevisaoClosedCaption',$data);
}

public function modalRevisarCorrecaoIngestClosedCaption(){
	$idParceiro = $this->input->post('idParceiro');
	$idIngest = $this->input->post('idIngest');
	$idRevisaoClosedCaption = $this->revisaoClosedCaptionDao->selectIdRevisaoClosedCaption($idIngest);
	$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
	$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
	$data['revisaoClosedCaption'] = $this->revisaoClosedCaptionDao->selectRevisaoById($idRevisaoClosedCaption[0]->idRevisaoClosedCaption);
	$data['problemaClosedCaption'] = $this->revisaoClosedCaptionDao->selectProblemasClosedCaptionCorrigidos($idRevisaoClosedCaption[0]->idRevisaoClosedCaption);
	$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCorrecaoIngestClosedCaption',$data);
}


public function modalRevisarCorrecaoCatalogacaoClosedCaption(){
	$idParceiro = $this->input->post('idParceiro');
	$idIngest = $this->input->post('idIngest');
	$idRevisaoCatalogacaoClosedCaption = $this->revisaoClosedCaptionDao->selectIdRevisaoCatalogacaoClosedCaption($idIngest);
	$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);
	$data['parceiro'] = $this->parceirosDao->selectParceiroById($idParceiro);
	$data['revisaoClosedCaption'] = $this->revisaoClosedCaptionDao->selectRevisaoCatalogacaoById($idRevisaoCatalogacaoClosedCaption[0]->idRevisaoCatalogacaoClosedCaption);
	$data['problemaClosedCaption'] = $this->revisaoClosedCaptionDao->selectProblemasCatalogacaoClosedCaptionCorrigidos($idRevisaoCatalogacaoClosedCaption[0]->idRevisaoCatalogacaoClosedCaption);
	$this->load->view('paginas/fluxo/midias/parceiros/modalRevisarCorrecaoCatalogacaoClosedCaption',$data);
}

/*=========================== Exclusão ======================================*/
	function excluir(){
		$idIngest = $this->input->post('idIngest');
		$data['idExclusao'] = null;
		$data['exclusao'] = 'S';
		$data['usuario_id_exclusao'] = $this->session->userdata('idUsuario');
		$data['ingest_id'] = $idIngest;
		if( $this->parceirosDao->excluir($data)){
		    echo true;
		}else{
			echo false;
		}
	}

	function excluirClosedCaption(){
		$idExclusao = $this->input->post('idExclusao');
		$data['idExclusao'] = $idExclusao;
		$data['dataExclusaoClosedCaption'] = Date("Y-m-d H:i:s");
		if( $this->parceirosDao->excluirClosedCaption($data)){
		    echo true;
		}else{
			echo false;
		}
	}

}
