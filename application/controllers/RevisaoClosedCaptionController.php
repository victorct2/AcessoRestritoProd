<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RevisaoClosedCaptionController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
    $grupos = $this->session->userdata('grupos');
    if(in_array("1", $grupos) || in_array("17", $grupos) || in_array("20", $grupos) || in_array("15", $grupos) || in_array("16", $grupos)
|| in_array("17", $grupos) || in_array("19", $grupos) || in_array("21", $grupos) || in_array("22", $grupos) || in_array("23", $grupos)
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


	function cadastrarRevisao(){


		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
		$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$closedCaption = $this->input->post('closedCaption');
		$obs_closedCaption = $this->input->post('obs_closedCaption');
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoClosedCaption/midias';
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisaoClosedCaption';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoClosedCaption';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisaoClosedCaption';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisaoClosedCaption';
				break;
			default:
				break;
		}

		$mensagem = array();
		$status = "";

		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);


		if(empty($closedCaption) && $data['ingest'][0]->closedCaption == 'S'){
			$mensagem[] = "Por favor, entre com as informações <b>APROVADO/REPROVADO</b> do <b>Closed Caption</b>";
		}

		if($closedCaption == 'REPROVADO' && $obs_closedCaption == ''){
			$mensagem[] = "Por favor, entre com a observação do <b>Closed Caption</b>";
		}else if($closedCaption == 'REPROVADO' && $obs_closedCaption != ''){
			$status = "R";
		}


       // exit();

		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$revisaoClosedCaption['idRevisaoClosedCaption'] = null;
			$revisaoClosedCaption['usuario_id_revisao_closedCaption'] = $this->session->userdata('idUsuario');
			$revisaoClosedCaption['ingest_id'] = $idIngest;
			$revisaoClosedCaption['statusRevisaoClosedCaption'] = ($status == '')? 'A':$status;

			if($this->revisaoClosedCaptionDao->insertRevisao($revisaoClosedCaption,$idIngest,$obs_closedCaption)){
				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Revisão de <b>Closed Caption</b> cadastrada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Revisão de <b>Closed Caption</b> cadastrada com sucesso!');
				}
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Revisão de <b>Closed Caption</b>!');
				redirect(base_url() . $url,'refresh');
			}


		}


	}

	function revisaoCorrecao(){

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idRevisaoClosedCaption = $this->input->post('idRevisaoClosedCaption');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$closedCaption = $this->input->post('closedCaption');
		$idRevisaoClosedCaptionProblema = $this->input->post('idRevisaoClosedCaptionProblema');
		$obs_closedCaption = $this->input->post('obs_closedCaption');


		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoClosedCaption/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoClosedCaption/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisaoClosedCaption';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/revisaoClosedCaption';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoClosedCaption';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisaoClosedCaption';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisaoClosedCaption';
				break;

			default:

				break;
		}

		$mensagem = array();
		$status = "";




		if($closedCaption == 'REPROVADO' && $obs_closedCaption == ''){
			$mensagem[] = "Por favor, entre com a observação do <b>closed Caption</b> Reprovado";
		}else if($closedCaption == 'REPROVADO' && $obs_closedCaption != ''){
			$status = "R";
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$revisaoClosedCaption['idRevisaoClosedCaption'] = $idRevisaoClosedCaption;
			$revisaoClosedCaption['usuario_id_revisao_closedCaption'] = $this->session->userdata('idUsuario');
			$revisaoClosedCaption['ingest_id'] = $idIngest;
			$revisaoClosedCaption['statusRevisaoClosedCaption'] = ($status == '')? 'A':$status;


			if($this->revisaoClosedCaptionDao->updateRevisaoCorrecao($revisaoClosedCaption,$idRevisaoClosedCaption,$idIngest,$idRevisaoClosedCaptionProblema,$obs_closedCaption)){

				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Revisão de correção efetuada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Revisão de correção efetuada com sucesso!');
				}
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao revisar a Correção!');
				redirect(base_url() . $url,'refresh');
			}


		}

	}


	function alterarRevisao(){

		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		//exit();

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idRevisao = $this->input->post('idRevisao');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
		$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$claquetes = is_array($this->input->post('claquete'))? $this->input->post('claquete'):null;
		$obs_claquete = is_array($this->input->post('obs_claquete'))? $this->input->post('obs_claquete'):null;
		$blocos = is_array($this->input->post('bloco'))? $this->input->post('bloco'):null;
		$obs_bloco = is_array($this->input->post('obs_bloco'))? $this->input->post('obs_bloco'):null;
		$materias = is_array($this->input->post('materia'))? $this->input->post('materia'): null ;
		$obs_materia = is_array($this->input->post('obs_materia'))? $this->input->post('obs_materia'):null;
		$materiasRedacao = is_array($this->input->post('materiaRedacao'))? $this->input->post('materiaRedacao'): null ;
		$obs_materiasRedacao = is_array($this->input->post('obs_materiaRedacao'))? $this->input->post('obs_materiaRedacao'):null;
		$blocoProblema = is_array($this->input->post('blocoProblema'))? $this->input->post('blocoProblema'):null;
		$claqueteProblema = is_array($this->input->post('claqueteProblema'))? $this->input->post('claqueteProblema'):null;
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisao/midias';
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoIngest';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisao';
				break;
			default:
				break;
		}

		$mensagem = array();
		$status = "";

		$data['ingest'] = $this->ingestDao->selectIngest($idIngest);


		if(count($claquetes) < $data['ingest'][0]->claquetes){
			$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Claquete(s)";
		}

		if(count($blocos) < $data['ingest'][0]->blocos){
			$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO do(s) Bloco(s)";
		}

		if($tipoIngest == 'C' || $tipoIngest == 'CH'  ){
			$data['materiasRedacao'] = $this->dao_midiascasa_model->materiasRedacaoDaPauta($data['ingest'][0]->pauta_id);
			if( $idPrograma != 39  & $idPrograma != 2 & $idPrograma != 15 & $idPrograma != 32){
				if(count($materiasRedacao) < count($data['materiasRedacao'])){
					$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Matéria(s) de Redação";
				}
			}

			$data['materias'] = $this->dao_midiascasa_model->materiasDaPauta($data['ingest'][0]->pauta_id);
			if( $idPrograma != 39  & $idPrograma != 2 & $idPrograma != 15 & $idPrograma != 32){
				if(count($materias) < count($data['materias'])){
					$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Matéria(s)";
				}
			}
		}

		for ($c = 1; $c <= count($claquetes); $c++) {
			/*echo 'claquete ' .$c .': '. $claquetes[$c][0] . '<br>';
			echo 'Observação claquete ' .$c .': '. $obs_claquete[$c][0] . '<br>';
			*/
			if($claquetes[$c][0] == 'REPROVADO' && $obs_claquete[$c][0] == ''){
				$mensagem[] = "Por favor, entre com a observação da claquete ".$c;
			}else if($claquetes[$c][0] == 'REPROVADO' && $obs_claquete[$c][0] != ''){
				$status = "R";
			}

		}

		for ($b=1; $b <= count($blocos); $b++) {
			/*echo 'bloco ' .$b .': '. $blocos[$b][0] . '<br>';
			echo 'Observação bloco ' .$b .': '. $obs_bloco[$b][0] . '<br>';*/

			if($blocos[$b][0] == 'REPROVADO' && $obs_bloco[$b][0] == ''){
				$mensagem[] = "Por favor, entre com a observação do bloco ".$b;
			}else if($blocos[$b][0] == 'REPROVADO' && $obs_bloco[$b][0] != ''){
				$status = "R";
			}
		}


        if($tipoIngest == 'C' || $tipoIngest == 'CH'){
			if($idPrograma != 15 || $idPrograma != 2 || $idPrograma != 32 || $idPrograma != 39){
				foreach ($materias as $key => $m) {
					if($m[0] == 'REPROVADO' && $obs_materia[$key][0] == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria Reprovada";
					}else if($m[0] == 'REPROVADO' && $obs_materia[$key][0] != ''){
						$status = "R";
					}
				}

				foreach ($materiasRedacao as $key => $mr) {
					if($mr[0] == 'REPROVADO' && $obs_materiasRedacao[$key][0] == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria de Redação Reprovada";
					}else if($mr[0] == 'REPROVADO' && $obs_materiasRedacao[$key][0] != ''){
						$status = "R";
					}
				}
			}
        }




       //

		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$revisao['idRevisao'] = $idRevisao;
			$revisao['usuario_id_revisao'] = $this->session->userdata('idUsuario');
			$revisao['ingest_id'] = $idIngest;
			$revisao['statusRevisao'] = ($status == '')? 'A':$status;


			if($this->revisaoDao->updateRevisao($revisao,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiasRedacao,$tipoIngest,$blocoProblema,$claqueteProblema)){
				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Revisão de Ingest alterada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Revisão de Ingest alterada com sucesso!');
				}
				//exit();
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao alterar a Revisão!');
				//exit();
				redirect(base_url() . $url,'refresh');
			}


		}

	}

	function deleteRevisaoParceiro(){
		$idIngest = $this->input->post('idIngest');
		$idRevisaoIngest = $this->input->post('idRevisaoIngest');

		if( $this->revisaoDao->deleteRevisaoParceiro($idIngest,$idRevisaoIngest)){
		    echo true;
		}else{
			echo false;
		}
	}



	/*================================================================*/

	function cadastrarRevisaoCatalogacao(){


		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
		$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$closedCaption = $this->input->post('closedCaption');
		$obs_closedCaption = $this->input->post('obs_closedCaption');
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoExclusao/midias';
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisaoExclusao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoExclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisaoExclusao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisaoExclusao';
				break;
			default:
				break;
		}

		$mensagem = array();
		$status = "";

		$data['ingest'] = $this->ingestDao->selectIngestParceiro($idIngest);


		if(empty($closedCaption) && $data['ingest'][0]->closedCaption == 'S'){
			$mensagem[] = "Por favor, entre com as informações <b>APROVADO/REPROVADO</b> do <b>Closed Caption</b>";
		}

		if($closedCaption == 'REPROVADO' && $obs_closedCaption == ''){
			$mensagem[] = "Por favor, entre com a observação do <b>Closed Caption</b>";
		}else if($closedCaption == 'REPROVADO' && $obs_closedCaption != ''){
			$status = "R";
		}


       // exit();

		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$revisaoCatalogacaoClosedCaption['idRevisaoCatalogacaoClosedCaption'] = null;
			$revisaoCatalogacaoClosedCaption['usuario_id_revisaoCatalogacao_closedCaption'] = $this->session->userdata('idUsuario');
			$revisaoCatalogacaoClosedCaption['ingest_id'] = $idIngest;
			$revisaoCatalogacaoClosedCaption['statusRevisaoCatalogacaoClosedCaption'] = ($status == '')? 'A':$status;

			if($this->revisaoClosedCaptionDao->insertRevisaoCatalogacao($revisaoCatalogacaoClosedCaption,$idIngest,$obs_closedCaption)){
				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Revisão de Catalogação de <b>Closed Caption</b> cadastrada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Revisão de Catalogação de <b>Closed Caption</b> cadastrada com sucesso!');
				}
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a Revisão de Catalogação de <b>Closed Caption</b>!');
				redirect(base_url() . $url,'refresh');
			}


		}


	}

	function revisaoCatalogacaoCorrecao(){

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idRevisaoCatalogacaoClosedCaption = $this->input->post('idRevisaoCatalogacaoClosedCaption');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$closedCaption = $this->input->post('closedCaption');
		$idRevisaoCatalogacaoClosedCaptionProblema = $this->input->post('idRevisaoCatalogacaoClosedCaptionProblema');
		$obs_closedCaption = $this->input->post('obs_closedCaption');


		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoExclusao/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisaoExclusao/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisaoExclusao';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/revisaoExclusao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoExclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisaoExclusao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisaoExclusao';
				break;

			default:

				break;
		}

		$mensagem = array();
		$status = "";




		if($closedCaption == 'REPROVADO' && $obs_closedCaption == ''){
			$mensagem[] = "Por favor, entre com a observação do <b>closed Caption</b> Reprovado";
		}else if($closedCaption == 'REPROVADO' && $obs_closedCaption != ''){
			$status = "R";
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$revisaoClosedCaption['idRevisaoCatalogacaoClosedCaption'] = $idRevisaoCatalogacaoClosedCaption;
			$revisaoClosedCaption['usuario_id_revisaoCatalogacao_closedCaption'] = $this->session->userdata('idUsuario');
			$revisaoClosedCaption['ingest_id'] = $idIngest;
			$revisaoClosedCaption['statusRevisaoCatalogacaoClosedCaption'] = ($status == '')? 'A':$status;


			if($this->revisaoClosedCaptionDao->updateRevisaoCatalogacaoCorrecao($revisaoClosedCaption,$idRevisaoCatalogacaoClosedCaption,$idIngest,$idRevisaoCatalogacaoClosedCaptionProblema,$obs_closedCaption)){

				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Revisão de correção efetuada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Revisão de correção efetuada com sucesso!');
				}
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao revisar a Correção!');
				redirect(base_url() . $url,'refresh');
			}


		}

	}


}
