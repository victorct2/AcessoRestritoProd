<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramacaoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos) || in_array("22", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

		$this->load->model('programacaoDao_model');
		$this->load->model('programasDao_model');


	}


    public function viewLista(){

		$open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['assetsCSS'] = 'programacao/programacao-list.css';
        $open['pluginCSS'] = 'iCheck/all.css,jqueryUi/jquery-ui.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'programacao';
		$data['subMainNav'] = 'listaProgramacao';
		$data['listProgramas'] = $this->programacaoDao_model->todosOsProgramas();
		$this->load->view('paginas/programacao/lista',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'programacao/programacao-home.js';
        $footer['pluginJS'] = 'iCheck/icheck.min.js';
        $this->load->view('include/footer',$footer);
    }

	public function listaProgramacaoDataTables(){

        $fetch_data = $this->programacaoDao_model->make_datatables();
		$dataArray = array();

        foreach($fetch_data as $row){

			$classificacao = '<span class="label pull-right bg-navy">'.$row->classificacao.'</span><br>';
			$genero = '<span class="label pull-right bg-teal">'.$row->genero.'</span><br>';
			$duracao = '<span class="label pull-right bg-green">'.$row->duracao.'</span><br>';
			$destaque = '';
			$inedito = '';
			if($row->inedito == 'S'){
                $inedito = '<span class="label pull-right bg-red infoStatus">INÉDITO</span><br>';
            }

			if($row->destaque == 'S'){
                $destaque = '<span class="label pull-right bg-yellow infoStatus">DESTAQUE</span><br>';
            }

			$imagem = $this->programacaoDao_model->selectImagePrograma($row->programa);

			$sub_array = array();
			$sub_array[] = '<img src="'.$imagem.'" class="img-rounded  imgList" width="180" height="100" />';
			$sub_array[] = $row->veiculacao;
            $sub_array[] = $row->programa;
            $sub_array[] = converteDataInterface($row->dia);
			$sub_array[] = $row->hrinicial;
			$sub_array[] = $row->hrfinal;
			$sub_array[] = $row->tema;
			$sub_array[] = $row->descricao;
            $sub_array[] = $classificacao.$genero.$duracao.$destaque.$inedito;
            $sub_array[] = '<a href="'.base_url('ProgramacaoController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
							<a href="'.base_url('ProgramacaoController/excluirProgramacao/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>
							<a href="#" title="'.$row->id.'" class="btn btn-app bg-red inedito"><i class="fa fa-film"></i> Inedito</a>
							<a href="#" title="'.$row->id.'" class="btn btn-app bg-yellow destaque"><i class="fa fa-star"></i> Destaque</a>';

            $dataArray[] = $sub_array;
		}

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->programacaoDao_model->get_all_data(),
            "recordsFiltered" => $this->programacaoDao_model->get_filtered_data(),
            "data" => $dataArray
        );
        echo json_encode($output);
	}

	function marcarComoInedito(){
		$idProgramacao = $this->input->post('idProgramacao');
		if($this->programacaoDao_model->updateIneditoTrue($idProgramacao)){
			echo 'success';
		}else{
			echo 'false';
		}
	}

	function marcarComoDestaque(){
		$idProgramacao = $this->input->post('idProgramacao');
		if($this->programacaoDao_model->updateDestaqueTrue($idProgramacao)){
			echo 'success';
		}else{
			echo 'false';
		}
	}


	public function viewCadastro(){

        $open['assetsBower'] = 'select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,jqueryUi/jquery-ui.min.css';

        $this->load->view('include/openDoc',$open);

		//$data['listProgramas'] = $this->programasDao_model->listarProgramas();
		$data['listProgramas'] = $this->programacaoDao_model->todosOsProgramas();
		/*echo '<pre>';
		print_r($data['listProgramas']);
		echo '</pre>';*/

		$data['mainNav'] = 'programacao';
		$data['subMainNav'] = 'cadastroProgramacao';
		$this->load->view('paginas/programacao/cadastro',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'programacao/programacao-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

	public function cadastrarProgramacao(){

		$programa   = $this->input->post('programa');
		$dia   = $this->input->post('dia');
		$hrinicial   = $this->input->post('hrinicial');
		$hrfinal   = $this->input->post('hrfinal');
		$tema   = $this->input->post('tema');
		$situacao   = $this->input->post('situacao');

		$mensagem = array();

		if(empty($programa)){
			$mensagem[] = 'O <b>NOME</b> da programação é Obrigatório.';
		}

		if(empty($dia)){
			$mensagem[] = 'O <b>DIA</b> de exibição da programação é Obrigatória.';
		}else if(!validaData($dia)){
			$mensagem[] = '<b>DATA</b> Inválida.';
		}

		if(empty($hrinicial)){
			$mensagem[] = 'A <b>HORA INICIAL</b> da programação é Obrigatória.';
		}

		if(empty($hrfinal)){
			$mensagem[] = 'A <b>HORA FINAL</b> da programação é Obrigatória.';
		}

		if(empty($tema)){
			$mensagem[] = 'O <b>TEMA</b> da programação é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> da programação é Obrigatória.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ProgramacaoController/viewCadastro/','refresh');
		}
		else{

			$data['veiculacao'] = 'Canal Saúde';
			$data['programa'] = $programa;
			$data['dia'] = converteDataBanco($dia);
			$data['hrinicial'] = $hrinicial;
			$data['hrfinal'] = $hrfinal ;
			$data['tema'] = $tema ;
			$data['ativo'] = $situacao ;
			$data['id'] = null;

			if($this->programacaoDao_model->insertProgramacao($data)){
				$this->session->set_flashdata('resultado_ok','Programação cadastrada com sucesso!');
				redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Programação!');
				redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
			}

		}

	}

	public function viewAlterar($id){

        $open['assetsBower'] = 'select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css,jqueryUi/jquery-ui.min.css';

        $this->load->view('include/openDoc',$open);

		$data['listProgramas'] = $this->programacaoDao_model->todosOsProgramas();
		$data['programacao'] = $this->programacaoDao_model->selectProgramacaoById($id);

		$this->load->view('paginas/programacao/alterar',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'programacao/programacao-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

	public function alterarProgramacao(){

		$programa   = $this->input->post('programa');
		$dia   = $this->input->post('dia');
		$hrinicial   = $this->input->post('hrinicial');
		$hrfinal   = $this->input->post('hrfinal');
		$tema   = $this->input->post('tema');
		$situacao   = $this->input->post('situacao');
		$id   = $this->input->post('id');

		$mensagem = array();

		if(empty($programa)){
			$mensagem[] = 'O <b>NOME</b> da programação é Obrigatório.';
		}

		if(empty($dia)){
			$mensagem[] = 'O <b>DIA</b> de exibição da programação é Obrigatória.';
		}else if(!validaData($dia)){
			$mensagem[] = '<b>DATA</b> Inválida.';
		}

		if(empty($hrinicial)){
			$mensagem[] = 'A <b>HORA INICIAL</b> da programação é Obrigatória.';
		}

		if(empty($hrfinal)){
			$mensagem[] = 'A <b>HORA FINAL</b> da programação é Obrigatória.';
		}

		if(empty($tema)){
			$mensagem[] = 'O <b>TEMA</b> da programação é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> da programação é Obrigatória.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ProgramacaoController/viewCadastro/','refresh');
		}
		else{

			$data['programa'] = $programa;
			$data['dia'] = converteDataBanco($dia);
			$data['hrinicial'] = $hrinicial;
			$data['hrfinal'] = $hrfinal ;
			$data['tema'] = $tema ;
			$data['ativo'] = $situacao ;
			$data['id'] = $id;

			if($this->programacaoDao_model->updateProgramacao($data)){
				$this->session->set_flashdata('resultado_ok','Programação alterada com sucesso!');
				redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao alterar a Programação!');
				redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
			}

		}

	}


    public function viewArquivo(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $open['assetsCSS'] = 'programacao/programacao-arquivo.css';

        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'programacao';
		$data['subMainNav'] = 'envioArquivo';
		$this->load->view('paginas/programacao/envioArquivo',$data);

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'programacao/programacao-arquivo.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarArquivo(){


        $nomeArquivo = is_array($this->input->post('listaArquivos'))? $this->input->post('listaArquivos') : null;
		chmod('uploadArquivos/arquivos/'.$nomeArquivo[0], 0777);
		$arquivo = base_url() . 'uploadArquivos/arquivos/' . $nomeArquivo[0];
		$row = 0;
	//$ctx = stream_context_create(array('ssl'=>array('verify_peer'=>true, 'capath'=>'/etc/ssl/certs')));
	$ctx=stream_context_create(array(
	    "ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	    ),
	));
	//echo $arquivo;
        $handle = fopen ($arquivo,"r",false,$ctx);
	//$handle = fopen ($arquivo,"r");

        while ($data = fgetcsv ($handle, 1000, ",")) {
           $num = count ($data);
           $row++;

		   for ($c=0; $c < $num; $c++) {

				switch ($c) {
					case 0:
						$programacao['veiculacao'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 1:
						$programacao['programa'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 2:
						$dia = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						$dia = 	trim($dia);
						if($dia != null){
							if (ValidaData($dia)){
								$dia = converteDataBanco($dia);
							}
						}
						$programacao['dia'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 3:
						$programacao['hrinicial'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 4:
						$programacao['hrfinal'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 5:
						$programacao['tema'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 6:
						$programacao['descricao'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 7:
						$programacao['duracao'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 8:
						$programacao['classificacao'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 9:
						$programacao['genero'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 10:
						$programacao['ativo'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 11:
						$programacao['inedito'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
					case 12:
						$programacao['destaque'] = ($data[$c] != "")?  utf8_encode($data[$c]) : null;
						break;
				}

    		}

			$programacao['id'] = null;

			if(count($programacao)>6){
				if($this->programacaoDao_model->verifyNotExist($programacao)){

					if(!$this->programacaoDao_model->insertProgramacao($programacao)){
						$this->session->set_flashdata('resultado_error','Erro ao Enviar a Programação!');
						redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
					}

				}else{
					$this->session->set_flashdata('resultado_error','Erro ao Enviar a Programação!');
					redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
				}
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao Enviar a Programação!');
				redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
			}

        }

        fclose ($handle);
        unlink('uploadArquivos/arquivos/' . $nomeArquivo[0]);

   		$this->session->set_flashdata('resultado_ok','Programação Enviada com sucesso!');
		redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
    }


    function excluirProgramacao($id){
        if($this->programacaoDao_model->deleteProgramacao($id)){
            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'ProgramacaoController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir a Programação!');
            redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
        }
	}



    function excluirPorPeriodo(){

        $periodo = $this->input->post('periodo');
        $arrayDatas = explode('-',$periodo);
        $dataInicial = converteDataBanco($arrayDatas[0]);
        $dataFinal = converteDataBanco($arrayDatas[1]);

        if($this->programacaoDao_model->deleteProgramacaoPorPeriodo($dataInicial, $dataFinal)){
           /* echo $this->db->last_query();
            exit();*/
            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'ProgramacaoController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir a Programação!');
            redirect(base_url() . 'ProgramacaoController/viewLista','refresh');
        }
	}



}
